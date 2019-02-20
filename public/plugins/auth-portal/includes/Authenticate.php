<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-12-13
 * Time: 4:23 PM
 */

namespace MaxLiving\AuthPortal\Includes;

use Jose\Factory\JWKFactory;
use Jose\Loader;
use Jose\Checker as Checker;

class Authenticate
{
    /**
     * @return bool|void
     */
    public static function from_auth_portal() {
        //get the token, if there isn't one get out
        if(!isset($_GET['idToken'])) {
            return;
        }

        $token = $_GET['idToken'];

        //we have a token so validate it
        $jwk_set = JWKFactory::createFromJKU('https://cognito-idp.' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_COGNITO_IDENTITY_POOL_ID') . '/.well-known/jwks.json', false);
        $loader = new Loader();

        try {
            $jws = $loader->loadAndVerifySignatureUsingKeySet(
                $token,
                $jwk_set,
                ['RS256'],
                $signature_index
            );

            $checker_manager = new Checker\CheckerManager();
            $checker_manager->addClaimChecker(new Checker\ExpirationTimeChecker());
            $checker_manager->addClaimChecker(new Checker\NotBeforeChecker());
            $checker_manager->addClaimChecker(new Checker\AudienceChecker(env('AWS_COGNITO_IDENTITY_APP_CLIENT_ID')));
            $checker_manager->addHeaderChecker(new Checker\CriticalHeaderChecker());
            $checker_manager->checkJWS($jws, $signature_index);

            $email = $jws->getPayload()['email'];
            
            if (!get_user_by('email', $email)) {
	        	$redirect = '<meta http-equiv="refresh" content="5; url='.env('AUTHPORTAL_URL').'">';
            	wp_die('The account '.$email.' is not associated with a MaxLiving Website.'.$redirect,'Website Account Permission Error');
            }

            $user = get_user_by('email', $email);

            wp_set_auth_cookie( (int)$user->data->ID );

            //if super admin, redirect to network level
            if(is_super_admin($user->data->ID)) {

                wp_redirect( network_admin_url() );

                exit;
            }

            //find the blogs the user is associated with and redirect them to the first one
            $users_blogs = get_blogs_of_user( (int)$user->data->ID);

            foreach($users_blogs as $blog => $values) {

                switch_to_blog($blog);

                wp_redirect( admin_url() );

                exit;
            }
        }
        catch(\Exception $e) {
            // signature not verified
            return false;
        }
    }

}
