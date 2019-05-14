<?php
/**
 * Pro-specific functionality for WP Offload SES.
 *
 * @author  Delicious Brains
 * @package WP Offload SES
 */

namespace DeliciousBrains\WP_Offload_SES\Pro;

use DeliciousBrains\WP_Offload_SES\WP_Offload_SES;
use DeliciousBrains\WP_Offload_SES\Pro\Licences_Updates;
use DeliciousBrains\WP_Offload_SES\Pro\Queue\Email_Queue;

/**
 * Class WP_Offload_SES
 *
 * @since 1.1
 */
class WP_Offload_SES_Pro extends WP_Offload_SES {

	/**
	 * The Email_Queue class.
	 *
	 * @var Email_Queue
	 */
	private $email_queue;

	/**
	 * The Licences_Updates class.
	 *
	 * @var Licences_Updates
	 */
	private $licence;

	/**
	 * Construct the parent class and initialize the plugin.
	 *
	 * @param string $plugin_file_path The plugin file path.
	 */
	public function __construct( $plugin_file_path ) {
		parent::__construct( $plugin_file_path );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @param string $plugin_file_path The plugin file path.
	 */
	public function init( $plugin_file_path ) {
		// Load the plugin.
		parent::init( $plugin_file_path );

		// Load pro-specific classes.
		$this->email_queue = new Email_Queue();
		$this->licence     = new Licences_Updates( $this );

		// Pro filters and action hooks.
		add_action( 'wp_ajax_wposes_reports_table', array( $this, 'ajax_reports_table' ) );
		add_filter( 'wposes_settings_sub_nav_tabs', array( $this, 'pro_sub_nav_tabs' ) );
	}

	/**
	 * Perform plugin upgrade routines.
	 *
	 * @param bool $skip_version_check If the version check should be skipped.
	 */
	public function upgrade_routines( $skip_version_check = false ) {
		$version = get_site_option( 'wposes_version', '0.0.0' );

		if ( $skip_version_check || version_compare( $version, $GLOBALS['wposes_meta']['wp-offload-ses']['version'], '<' ) ) {
			$this->get_email_queue()->install_tables();
			parent::upgrade_routines( true );

			if ( ! $skip_version_check ) {
				update_site_option( 'wposes_version', $GLOBALS['wposes_meta']['wp-offload-ses']['version'] );
			}
		}
	}

	/**
	 * Enqueue any styles/scripts.
	 */
	public function plugin_load() {
		parent::plugin_load();
		$this->enqueue_script( 'wposes-licence', 'assets/js/pro/licence', array( 'jquery', 'underscore' ) );
	}

	/**
	 * Sub nav tabs for the pro plugin.
	 *
	 * @param array $tabs The tabs for the subnav.
	 *
	 * @return array
	 */
	public function pro_sub_nav_tabs( $tabs ) {
		if ( ! is_multisite() || is_network_admin() ) {
			$tabs['licence'] = _x( 'License', 'Show the license tab', 'wp-offload-ses'  );
		}

		return $tabs;
	}

	/**
	 * Getter for Email_Queue.
	 *
	 * @return Email_Queue
	 */
	public function get_email_queue() {
		return $this->email_queue;
	}

	/**
	 * Check whether this is the free or pro version.
	 *
	 * @return bool
	 */
	public function is_pro() {
		return true;
	}

	/**
	 * Check if the plugin has a valid license.
	 *
	 * @param bool $skip_transient_check True if license transient should be skipped.
	 *
	 * @return bool
	 */
	public function is_valid_licence( $skip_transient_check = false ) {
		if ( is_null( $this->licence ) ) {
			return false;
		}

		return $this->licence->is_valid_licence( $skip_transient_check );
	}

	/**
	 * Display the reports table over AJAX.
	 */
	public function ajax_reports_table() {
		$reports_table = new Reports_List_Table();
		$reports_table->load();
		$reports_table->ajax_response();
	}

	/**
	 * Mail handler
	 *
	 * @param string|array $to          The email recipient.
	 * @param string       $subject     The email subject.
	 * @param string       $message     The email message.
	 * @param string|array $headers     The email headers.
	 * @param string|array $attachments The email attachments.
	 *
	 * @return bool
	 */
	public function mail_handler( $to, $subject, $message, $headers, $attachments ) {
		$content_type = apply_filters( 'wp_mail_content_type', 'text/plain' );

		// Add Content-Type header now in case filter is removed by time queue is ran.
		if ( 'text/html' === $content_type ) {
			if ( is_array( $headers ) ) {
				$headers[] = 'Content-Type: text/html;';
			} else {
				$headers .= "Content-Type: text/html;\n";
			}
		}

		$subject  = $this->maybe_decode_subject( $subject );
		$atts     = apply_filters( 'wp_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments' ) );
		$email_id = $this->get_email_log()->log_email( $atts );

		if ( ! $this->is_valid_licence() ) {
			return $this->manually_send_email( $atts, $email_id );
		}

		$this->get_email_queue()->process_email( $email_id );

		return true;
	}

}
