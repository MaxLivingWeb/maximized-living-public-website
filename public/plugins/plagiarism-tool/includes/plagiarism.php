<?php

namespace MaxLiving\PlagiarismTool\Includes;

use GuzzleHttp;

class Plagiarism
{

    private static $client;

    /**
     * oAuth
     */
    public static function oAuth()
    {
        // Create handler stack to use oauth with guzzle.
        $stack = GuzzleHttp\HandlerStack::create();

        // Add oauth middle to handler stack.
        $stack->push(self::generateAuth());

        // Create guzzle client using Unicheck API base url and oauth handler stack.
        self::$client = new GuzzleHttp\Client([
            'base_uri' => 'https://corpapi.unicheck.com/api/v2/',
            'handler' => $stack,
            'auth' => 'oauth'
        ]);

    }

    /**
     * @return GuzzleHttp\Subscriber\Oauth\Oauth1
     */
    private static function generateAuth()
    {
        return new GuzzleHttp\Subscriber\Oauth\Oauth1([
            'consumer_key' => getenv('UNICHECK_CONSUMER_KEY'),
            'consumer_secret' => getenv('UNICHECK_CONSUMER_SECRET'),
            'token_secret' => '',
            'token' => ''
        ]);
    }

    /**
     * @param $defaults
     * @return mixed
     */
    public static function plagiarism_head($defaults)
    { //Adds column in posts
        $defaults['Plagiarism'] = 'Plagiarism';
        return $defaults;
    }

    /**
     * @param $column_name
     * @param $post_id
     */
    public static function plagiarism_post_table_column($column_name, $post_id)
    {
        $post = get_post($post_id);

        if (!is_object($post)) {
            return;
        }

        if ($column_name === 'Plagiarism') {
            if (!get_post_meta($post_id, 'unicheck_report')) {
                $button_url = admin_url('admin-post.php?action=plagiarism_check&post_id=' . $post_id . '');
                $button_text = 'Validate Content';
                $button_att = '';
                $extraText = '';

            } else {
                $status = get_post_meta($post->ID, 'unicheck_report_status');
                if ($status[0] == 1) {
                    $button_url = get_post_meta($post_id, 'unicheck_report')[0];
                    $button_text = 'View Report';
                    $button_att = 'target="_blank"';
                    $extraText = '';

                } else {
                    $button_url = admin_url('post.php?post=' . $post_id . '&action=edit');
                    $button_text = 'Generating Report';
                    $button_att = '';
                    $extraText = '<br><strong>Click to check report status</strong>';
                }
            }
            echo '<a href="' . $button_url . '" class="button-secondary" ' . $button_att . '>' . $button_text . '</a>' . $extraText;

        }
    }

    /**
     * Adds check for plagiarism button
     */
    public static function add_plagiarism_options()
    {

        self::oAuth();

        global $post;
        if (is_object($post)) {
            if ($post->post_status !== 'auto-draft') {

                if ($post->post_type === 'recipe' || $post->post_type === 'article') {

                    include 'views/plagiarism-button.php';

                    $unicheck_report_status = get_post_meta($post->ID, 'unicheck_report_status');
                    if (!empty($unicheck_report_status)) {
                        if ($unicheck_report_status[0] == "0") {

                            $unicheck_report_id = get_post_meta($post->ID, 'unicheck_report_id');

                            //Check status
                            $report = self::$client->get('check/progress?id=' . (int)$unicheck_report_id[0]);
                            $returnReportStatus = json_decode($report->getBody(), true);

                            //If check is complete
                            if ($returnReportStatus['progress'][$unicheck_report_id[0]] == 1) {
                                include 'views/plagiarism-button-enable.php';
                                update_post_meta($post->ID, 'unicheck_report_status', 1);
                            }

                        }
                    }
                    if (get_post_meta($post->ID, 'unicheck_report_status')) {
                        global $status;
                        $status = get_post_meta($post->ID, 'unicheck_report_status');
                        include 'views/plagiarism-view-report-button.php';
                    }
                }

            }
        }
    }

    /**
     * Send to UniCheck API and get report.
     */
    public static function plagiarism_check()
    {

        //No Post ID Redirect to Admin Dashboard
        if (!isset($_GET['post_id'])) {
            wp_redirect(admin_url());
            exit;
        }

        // Get Post ID
        $post_id = $_GET['post_id'];

        // Get Post Object from WordPress
        $post = get_post($post_id);

        //If != Recipe/Article redirect to post type page
        if ($post->post_type !== 'recipe' && $post->post_type !== 'article') {
            wp_redirect(admin_url('edit.php?post_type=' . $post->post_type));
            exit;
        }

        //Create Content
        $content = self::getContent($post_id, $post);


        //
        // UniCheck API - oAuth
        // Using: https://corpapi.unicheck.com/api/doc/
        //
        self::oAuth();

        //
        // UniCheck API - File Upload
        // Using: https://corpapi.unicheck.com/api/doc/#api-File-async_upload
        //
        $result = self::fileUpload($post_id, $post, $content);

        //
        // UniCheck API - Track File Upload
        // Using: https://corpapi.unicheck.com/api/doc/#api-File-trackfileupload
        //
        $fileResult = self::trackUpload($result);

        //
        // UniCheck API - Request Check
        // Using: https://corpapi.unicheck.com/api/doc/#api-Check
        //
        $resultRequest = self::requestCheck($fileResult);

        //
        // UniCheck API - Get Report Link
        // Using: https://corpapi.unicheck.com/api/doc/#api-Check-get_report_link
        //
        $resultReport = self::report($resultRequest);

        // Function Saving Meta data
        self::unicheck_response($post_id, $resultReport, $resultRequest);


        //Redirect back to post
        $redirect_url = admin_url() . 'post.php?post=' . $post->ID . '&action=edit';
        wp_redirect($redirect_url);
        exit;
    }

    /**
     * @param $post_id
     * @param $post
     * @return string
     */
    private static function getContent($post_id, $post)
    {
        $content = "";

        // Append a post title to file.
        $content .= strip_tags(html_entity_decode($post->post_title)) . "\n\n";

        // Append a post content to file.
        $content .= strip_tags(html_entity_decode($post->post_content));

        //Remove BB Code from content
        $content = preg_replace('#\[[^\]]+\]#', '', $content);

        // Minimum 30 words or error page.
        $post_length = str_word_count($content);
        $post_type = $post->post_type;
        if ($post_length < 30) {
            wp_die(
                "<h1>" . ucfirst($post_type) . " Length Issue</h1>
                          <p>The " . $post_type . " is only <strong>" . $post_length . "</strong> words. To validate content the " . $post_type . " has to be a <u>minimum <strong>30</strong> words</u></p>
                           <a href='" . admin_url('post.php?post=' . $post_id . '&action=edit') . "'>< Return to " . $post_type . "</a>",
                ucfirst($post_type) . " Length Issue"
            );
        }
        if ($post_length > 100000) {
            wp_die(
                "<h1>" . ucfirst($post_type) . " Length Issue</h1>
                          <p>The " . $post_type . " is <strong>" . $post_length . "</strong> words. To validate content the " . $post_type . " has to <u>less than <strong>100,000</strong> words</u></p>
                           <a href='" . admin_url('post.php?post=' . $post_id . '&action=edit') . "'>< Return to " . $post_type . "</a>",
                ucfirst($post_type) . " Length Issue"
            );
        }

        return $content;
    }

    /**
     * @param $post_id
     * @param $post
     * @param $content
     * @return array|mixed|object
     */
    private static function fileUpload($post_id, $post, $content)
    {
        //File Name from Post Type Name and Post ID
        $post_type = $post->post_type;
        $post_type = ucfirst($post_type);
        $siteID = "";
        if (get_post_meta($post_id, 'siteOriginID')) {
            $originID = get_post_meta($post_id, 'siteOriginID');
            $siteID = '-SITE_' . $originID[0];
        }

        $body = [
            'file_data' => base64_encode($content), //encode file using base64
            'format' => 'txt',
            'name' => $post_type . "-" . $post_id . $siteID
        ];

        //Sending to UniCheck
        $response = self::$client->post('file/async_upload', [ //send HTTP POST request
            'json' => $body
        ]);

        return json_decode($response->getBody(), true);

    }

    /**
     * @param $result
     * @return array|mixed|object
     */
    private static function trackUpload($result)
    {
        $fileResult = NULL;
        while ($fileResult === NULL) {
            $response = self::$client->get('file/trackfileupload?uuid=' . $result['file']['uuid']);
            $trackResult = json_decode($response->getBody(), true);

            if (isset($trackResult['progress']['file'])) {//if upload is complete
                $fileResult = $trackResult['progress']['file'];
                break;
            }
            sleep(1); // Wait a second to see if upload is complete.
        }
        return $fileResult;
    }

    /**
     * @param $fileResult
     * @return array|mixed|object
     */
    private static function requestCheck($fileResult)
    {
        // Send request to UniCheck to check the uploaded file.
        $check = self::$client->request('POST', 'check/create', [ // Send HTTP POST request
            'form_params' => [
                'type' => 'web_and_my_library',
                'file_id' => $fileResult['id'],
                'options' => [
                    'sensitivity' => 0.1,
                    'words_sensitivity' => 8
                ]
            ],
            'headers' => [
                'Accept' => 'application/json' // Force unicheck to give response in JSON
            ]
        ]);

        return json_decode($check->getBody(), true);

    }

    /**
     * @param $resultRequest
     * @return array|mixed|object
     */
    private static function report($resultRequest)
    {
        //Get report link
        $report = self::$client->get('check/get_report_link?id=' . $resultRequest['check']['id']);

        return json_decode($report->getBody(), true);
    }

    /**
     * @param $post_id
     * @param $resultReport
     */
    private static function unicheck_response($post_id, $resultReport, $resultRequest)
    {
        //UniCheck Report
        if (get_post_meta($post_id, 'unicheck_report')) {
            // If the custom field already has a value, update it.
            update_post_meta($post_id, 'unicheck_report', $resultReport['view_url']);
        } else {
            // If the custom field doesn't have a value, add it.
            add_post_meta($post_id, 'unicheck_report', $resultReport['view_url']);
        }

        //UniCheck Report Id
        if (get_post_meta($post_id, 'unicheck_report_id')) {
            // If the custom field already has a value, update it.
            update_post_meta($post_id, 'unicheck_report_id', $resultRequest['check']['id']);
        } else {
            // If the custom field doesn't have a value, add it.
            add_post_meta($post_id, 'unicheck_report_id', $resultRequest['check']['id']);
        }

        //UniCheck Report Status
        if (get_post_meta($post_id, 'unicheck_report_status')) {
            // If the custom field already has a value, update it.
            update_post_meta($post_id, 'unicheck_report_status', 0);
        } else {
            // If the custom field doesn't have a value, add it.
            add_post_meta($post_id, 'unicheck_report_status', 0);
        }
    }
}
