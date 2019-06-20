<?php
defined('ABSPATH') or die();

function smtpmail_enqueue_scripts() 
{

	wp_enqueue_script( 'smtpmail-script', smtpmail_assets_url('smtp.js'),  array(), smtpmail_ver(), true  );
	
}
add_action( 'wp_enqueue_scripts', 'smtpmail_enqueue_scripts' );

// Stop wp
function smtpmail_shutdown()
{
    // This is our shutdown function, in 
    // here we can do any last operations
    // before the script is complete.

	// echo 'Script executed with success', PHP_EOL;

	// Check wp has send mail 
	if( isset($_SERVER['SMTPMAIL_WP_MAIL_SENDING']) && $_SERVER['SMTPMAIL_WP_MAIL_SENDING'] ) {
		$_SERVER['SMTPMAIL_WP_MAIL_SENDING'] = false;

		smtpmail_update_data( array(
										'status' => 1,
										'modified' => current_time( 'mysql' ),
									) );
	}

	// var_dump( smtpmail_path() );

	//var_dump($_SERVER);

}
register_shutdown_function('smtpmail_shutdown');

/**
 * WP Check Html
 *
 * @since 1.1.8
 *
 */
function smtpmail_wp_check_html( $html = '' )
{
	// Development

	return $html;
}