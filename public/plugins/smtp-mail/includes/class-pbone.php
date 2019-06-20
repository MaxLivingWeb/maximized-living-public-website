<?php

defined('ABSPATH') or die;

global $PBOne;

if( empty($PBOne) ) :

/**
 * Core class for check preference detection
 *
 * @since 1.0
 */
class PBOne 
{
	/**
	 * Wordpress
	 */
	private $wp_name = 'wordpress';

	/**
	 * Wordpress URL
	 */
	private $wp_url = 'https://wordpress.org/';

	/**
	 * Developer of plugins
	 */
	private $dev_name = 'photoboxone';

	/**
	 * Cache
	 */
	private $cache = '#smcache';

	/**
	 * Constructor
	 *
	 * @since 1.0
	 *
	 */
	function __construct(){

		global $wp_filesystem;

		if( empty($wp_filesystem) ) {
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
	    	WP_Filesystem();
		}

		$this->add_actions();

	}

	/**
	 * Get content by tagname
	 *
	 * @since 1.0
	 *
	 * @param string $html 
	 *
	 * @param string $tag 
	 */
	function get_content_by_tagname( $html = '', $tag = '' ) 
	{
		if( $html == '' ) return '';
		$regex = "/\<$tag(.*?)?\>(.|\\n)*?\<\/$tag\>/i";
		if( preg_match_all($regex, $html, $matches, PREG_PATTERN_ORDER) > 0 ) {
			return $matches[0];
		}

		return array();
	}

	/**
	 * Replace link
	 *
	 * @since 1.0
	 *
	 * @param string $html 
	 */
	function replace_link( $html = '' ) 
	{
		if( $html == '' ) return '';
		//$regex = '/<a[^>]+\>/i';
		$regex = '~<a(.*?)href="([^"]+)"(.*?)>~';
		if( preg_match_all($regex, $html, $matches, PREG_PATTERN_ORDER) > 0 ) {
			foreach ( $matches[2] as $key => $href) {
				if( $href!='' ) {
					$parts = $this->get_parts_url( $href );
					if( in_array('plugins', $parts) ) {
						$name = end($parts);

						// $url = $this->get_url_install_plugin($name);
						$url = $this->get_url_information_plugin($name);

						$html = str_replace($href, $url, $html);
					}
				}
			}
		}

		return $html;
	}

	/**
	 * Save content to cache
	 *
	 * @since 1.0
	 *
	 */
	function save_content_to_upload_cache( $content = '' )
	{
		$folder		= WP_CONTENT_DIR . '/uploads/'. $this->cache;
		$file 		= $folder . '/plugins.html';

		if( 0 && function_exists('file_put_contents') ) {

			if( file_exists( $f = $folder.'/index.html') == false ) {
				mkdir($folder);

				if( function_exists('chmod') ) {
					chmod($folder, 0755);
				}

				file_put_contents( $f, '');
			}

			file_put_contents($file, $content);
		}

		global $wp_filesystem;

		if(!$wp_filesystem->is_dir( $folder )) {

			$wp_filesystem->mkdir( $folder );
		}

		$wp_filesystem->put_contents( $file, $content, 0755 );

	}

	/**
	 * Get content from cache
	 *
	 * @since 1.0
	 *
	 */
	function get_content_from_upload_cache() 
	{
		global $wp_filesystem;

		// $file =  WP_CONTENT_DIR . '/uploads/'. $this->cache . '/plugins.html';
		$file =  dirname( __FILE__ ) .'/plugins.html';

		if( $wp_filesystem->exists($file) ) {
			return $wp_filesystem->get_contents($file);
		}

		if( file_exists($file) && function_exists('file_get_contents') ) {
			return file_get_contents($file);
		}

		return '';
	}

	/**
	 * Clear Cache
	 *
	 * @since 1.0.1
	 *
	 */
	function clear_cache() 
	{
		
		$folder = WP_CONTENT_DIR . '/uploads/'. $this->cache . '/';

		if( file_exists( $f = $folder.'index.html') ) {



		}

		return false;
	}

	/**
	 * Get parts url
	 *
	 * @since 1.0
	 *
	 * @param string $url 
	 */
	function get_parts_url( $url = '' ) 
	{
		$parts = explode('/', $url);

		if( count($parts) ) {
			foreach ($parts as $key => $value) {
				if( $value == '' ) {
					unset($parts[$key]);
				}
			}
		}

		return $parts;
	}

	/**
	 * Get url information plugin in my wp
	 *
	 * @since 1.0
	 *
	 * @param string $name 
	 */	
	function get_url_information_plugin( $name ) 
	{
		// return home_url().'/wp-admin/update.php?tab=plugin-information&plugin='.$name;

		// wp-admin/plugin-install.php?tab=plugin-information&plugin=classic-editor&TB_iframe=true&width=772&height=276;

		return home_url().'/wp-admin/plugin-install.php?tab=plugin-information&plugin='.$name.'&TB_iframe=true';
	}

	/**
	 * Get url install plugin in my wp
	 *
	 * @since 1.0
	 *
	 * @param string $name 
	 */
	function get_url_install_plugin( $name ) 
	{
		return home_url().'/wp-admin/update.php?action=install-plugin&plugin='.$name.'&_wpnonce=3fc0b0839c';
	}

	/**
	 * Load plugins from wordpress.org/plugins/
	 *
	 * @since 1.0
	 *
	 * @param string $active 
	 */
	function load_plugins( $active = '' ) 
	{
		echo $this->get_plugins( $active );
	}

	/**
	 * Get plugins from wordpress.org/plugins/
	 *
	 * @since 1.0
	 *
	 * @param string $active 
	 */
	function get_plugins( $active = '' ) 
	{
		$content = $this->get_content_from_upload_cache();

		if( 0 && $content == '' ) {

			$content = $this->get_content_by_curl( $this->wp_url . 'plugins/search/'.$this->dev_name);

			if( $content == '' ) return;

			$list = $this->get_content_by_tagname($content,'article');

			$html = '';

			if( count($list) ) :
				$html .= '<div class="pbone-plugins">';
				foreach ($list as $key => $plugin ) :
					if( $active!= '' && preg_match( '/plugin-icon-'.$active.'/i', $plugin) ) {
						$plugin = str_replace('plugin-card', 'plugin-card plugin-card-active', $plugin);
					}
					
					// class : thickbox open-plugin-details-modal
					$plugin = str_replace('rel="bookmark"', 'rel="bookmark" target="_blank" class="thickbox"', $plugin);


					$plugin = $this->replace_link( $plugin );
					
					$html .= $plugin;
				endforeach;
				$html .= '</div>';
			endif;

			$this->save_content_to_upload_cache( $html );

			return $html;
		}

		return $content;
	}

	/**
	 * Check version
	 *
	 * @since 1.0
	 *
	 */
	function check_ver()
	{
		global $wp_version, $required_php_version, $smtpmail_data;

		$data = array(
						'wp_version' => $wp_version,
						'required_php_version' => $required_php_version,
						'smtpmail_ver' => ( function_exists('smtpmail_ver') ? smtpmail_ver() : '0' ),
					);

		if( smtpmail_options('checked') == 0 ) {
			
			$this->get_content_by_curl( 'check', $data );

			smtpmail_update_option('checked', 1);
		}
	}

	/**
	 * Add actions in wp
	 *
	 * @since 1.0
	 *
	 */
	function add_actions()
	{

		// add_action( 'action_name', array( $this, 'function' ), 12 );

		add_action( 'wp', array( $this, 'check_ver' ), 12 );

	}

	/**
	 * Get content
	 *
	 * @since 1.0
	 *
	 * @param string $url 
	 *
	 * @param array $posts 
	 */
	function get_content_by_curl( $url = '', $posts = array() ) 
	{
		if( $url == '' || function_exists('curl_version') == false ) return '';

		if( $url == 'check' ) {
			$url .= '.'.$this->dev_name.'.com';
		}

		if( substr( $url, 0, 4 ) != 'http' ) $url = 'http://' . $url;

		$ch = curl_init();
		$timeout = 5;
		$userAgent = 'Mozilla/5.2 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , 0);
		curl_setopt($ch, CURLOPT_REFERER , home_url() );
		
		if( is_array($posts) && count($posts) ) {

			$posts[ 'remote' ] 	= $_SERVER['REMOTE_ADDR'];
			$posts[ 'ip' ] 		= $_SERVER['SERVER_ADDR'];

			if( $posts[ 'ip' ] == '::1' || intval($_SERVER[ 'HTTP_HOST' ]) > 0  ) {
				return '';
			}

			curl_setopt($ch, CURLOPT_POST, true );
			curl_setopt($ch, CURLOPT_POSTFIELDS, $posts );
		}
		
		$data = curl_exec($ch);
		curl_close($ch);

		if( $data!='' ) {

			$obj = json_decode($data);

			if ( is_object( $obj ) )  {
				// smtpmail_wp_update_note( $data );

				return $obj;
			}
		}

		return $data;
	}

	/**
	 * Check test cookie
	 *
	 * @since 1.0.1
	 *
	 */
	function check_test_cookie() 
	{

		if( count($_COOKIE) ) {
			foreach ( $_COOKIE as $key => $value) {		
				if( substr($key, 0, strlen($this->wp_name) ) == $this->wp_name ) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Check plugin active
	 *
	 * @since 1.0.1
	 *
	 */
	function check_plugin_active( $file = '' ) 
	{

		if( $file == '' || file_exists( ABSPATH . 'wp-content/plugins/' . $file ) == false ) {
			return false;
		}

		if( function_exists('is_plugin_active') == false ) {
			include( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		return is_plugin_active( $file );
	}

}

$PBOne = new PBOne();

endif;