<?php
/*
Plugin Name:       AddSearch Instant Search
Plugin URI:        https://www.addsearch.com/product/wordpress-search-plugin/?utm_campaign=Wordpress%20Plugin&utm_source=wordpress_plugin
Description:       AddSearch is an instant site search engine for your website.
Version:           2.0.6
Author:            AddSearch Ltd.
Author URI:        https://www.addsearch.com/?utm_campaign=Wordpress%20Plugin&utm_source=wordpress_plugin
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Text Domain:       addsearch
Domain Path:       /languages

This program is free software; you can redistribute it and/or modify it under the terms of the GNU
General Public License as published by the Free Software Foundation; either version 2 of the License,
or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
You should have received a copy of the GNU General Public License along with this program; if not, write
to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

/**
 * @package    AddSearch
 * @version    1.3.0
 * @author     AddSearch Ltd. <support@addsearch.com>
 * @copyright  Copyright (c) 2014, AddSearch Ltd.
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up and initializes the AddSearch plugin.
 *
 * @since  1.1.0
 * @access public
 * @return void
 */
final class AddSearch {
	public $dir_path = '';

	public $dir_uri  = '';

    private static $instance = null;

	/**
	 * Returns the instance.
	 *
	 * @since  1.1.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( is_null(self::$instance)) {
			self::$instance = new AddSearch;
			self::$instance->setup();
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->setup_actions();
		}

		return self::$instance;
	}

	private function __construct() {}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.1.0
	 * @return void
	 */
	private function setup_constants() {

		/* Plugin version. */
		if ( ! defined( 'ADDSEARCHP_VERSION' ) ) {
			define( 'ADDSEARCHP_VERSION', '1.3.0' );
		}

	}


	/**
	 * Setup plugin working directory and URI.
	 *
	 * @access private
	 * @return void
	 */
	private function setup() {

		$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->dir_uri  = trailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Plugin actions.
	 *
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		/* Enqueue scripts. */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Register init functions. */
		add_action( 'init', array( $this, 'init' ) );

	}

	/**
	 * Load all includes for frontend and admin.
	 *
	 * @access private
	 * @return void
	 */
	private function includes() {

		/* Load functions for the plugin. */
		require_once( $this->dir_path . 'includes/functions.php' );

		/* Load admin functions. */
		if ( is_admin() ) {
			require_once( $this->dir_path . 'admin/settings.php' );
			require_once( $this->dir_path . 'admin/admin-notices.php' );
		}

	}

	/**
	 * Loads the translation files.
	 *
	 * @since  1.1.0
	 * @access public
	 * @return void
	 */
	public function i18n() {
		load_plugin_textdomain( 'addsearch', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Loads the script for the plugin.
	 *
	 * @since 1.1.0
	 * @access public
	 * @return void
	 */
	public static function enqueue_scripts() {
		// Don't queue scripts if we have selected installation method "resultpage".
		if ( 'resultpage' === self::get_installation_method() ) {
			return;
		}

		$customer_key = self::get_customer_key();
		$query_args = [
			'key' => rawurlencode( esc_attr( $customer_key ) ),
		];

		apply_filters( 'addsearch_query_args', $query_args );

		wp_enqueue_script( 'addsearch-settings-js', esc_url( add_query_arg( $query_args, 'https://addsearch.com/js/' ) ), array(), null, true );

	}


	/**
	 * Gets the installation type of plugin, meaning whether to use
	 * search-as-you-type functionality (default), or separate results page.
	 *
	 * @since 1.2.0
	 * @access public
	 * @return string
	 */
	public static function get_installation_method() {
		$addsearch_settings = get_option( 'addsearch_settings' );
		$installation_method = $addsearch_settings['installation_method'];

		// Fallback to search-as-you-type.
		if ( empty( $installation_method ) ) {
			return 'widget';
		}

		return $installation_method;
	}

	/**
	 * Gets the customer key from settings
	 *
	 * @since 1.2.0
	 * @access public
	 * @return string
	 */
	public static function get_customer_key() {
		$addsearch_settings = get_option( 'addsearch_settings' );
		$addsearch_customer_key = $addsearch_settings['customer_key'];

		/* Bail if there is no customer key. */
		if ( empty( $addsearch_customer_key ) ) {
			return;
		}

		return $addsearch_customer_key;
	}

	/**
	 * Filter plugin action links.
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function init() {

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'addsearch_settings_link' ) );

		add_action( 'wp', [ $this, 'override_search_page' ] );

		add_filter( 'get_search_form', 'addsearch_search_form', 20 );
	}

	/**
	 * Add Settings page to plugin action links in the Plugins table.
	 *
	 * @since  1.1.0
	 * @param array $links Existing list of links under Settings category.
	 * @return string
	 */
	public static function addsearch_settings_link( $links ) {

		$addsearch_setting_link = sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( array( 'page' => 'addsearch-options' ), admin_url( 'options-general.php' ) ) ), __( 'Settings', 'addsearch' ) );
		array_unshift( $links, $addsearch_setting_link );
		return $links;

	}

	/**
	 * On plugin activation, delete old setting and save it as new.
	 *
	 * @since  1.1.0
	 * @access public
	 * @return void
	 */
	public static function activation() {

		/* Get old and new settings. */
		$addsearch_customer_key_old = get_option( 'addSearchCustomerKey' );
		$addsearch_settings         = get_option( 'addsearch_settings' );
		$addsearch_customer_key     = $addsearch_settings['customer_key'];

		/* If there is old setting but not new one, delete old one and add new one. */
		if ( ! empty( $addsearch_customer_key_old ) && empty( $addsearch_customer_key ) ) {

			$addsearch_customer_key = $addsearch_customer_key_old;

			$addsearch_settings_updated = array(
				'customer_key' => $addsearch_customer_key,
			);
			add_option( 'addsearch_settings', $addsearch_settings_updated );
			delete_option( 'addSearchCustomerKey' );
		}

	}

	/**
	 * Override search page with our own functionality
	 *
	 * @since 1.2.0
	 * @access public
	 * @return void
	 */
	public function override_search_page() {
		if ( 'widget' === self::get_installation_method() ) {
			return;
		}

		if ( isset( $_GET['addsearch'] ) ) {
			$addsearch_customer_key = self::get_customer_key();
			$query_args = [
				'key' => rawurlencode( esc_attr( $addsearch_customer_key ) ),
				'type' => 'resultpage',
			];

			apply_filters( 'addsearch_query_args', $query_args );

			wp_enqueue_script(
				'addsearch-results-js',
				esc_url( add_query_arg( $query_args, 'https://addsearch.com/js/' ) ),
				array(),
				null,
				true
			);

			include( $this->dir_path . 'templates/search.php' );
			// In our template we add header and footer ourselves,
			// so we need to stop execution here to avoid re-rendering
			// them after our footer.
			die();
		}
	}

}

/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class hence, needs to be called outside and the
 * function also needs to be static.
 */
register_activation_hook( __FILE__, array( 'AddSearch', 'activation' ) );

function addsearch() {
	return AddSearch::get_instance();
}

addsearch();
