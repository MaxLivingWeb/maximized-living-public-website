<?php

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add options page under Settings >> AddSearch.
 *
 * @since  1.1.0
 * @return void
 */
function addsearch_add_setting_page() {

	global $addsearch_settings_page;

	$addsearch_settings_page = add_options_page( __( 'AddSearch settings', 'addsearch' ), __( 'AddSearch', 'addsearch' ), apply_filters( 'addsearch_settings_capability', 'manage_options' ), 'addsearch-options', 'addsearch_options_page' );

}
add_action( 'admin_menu', 'addsearch_add_setting_page' );

/**
 * Registers the plugin settings.
 *
 * @since  1.1.0
 * @return void
 */
function addsearch_register_settings() {
	register_setting( 'addsearch_settings_group', 'addsearch_settings', 'addsearch_settings_sanitize' );
}
add_action( 'admin_init', 'addsearch_register_settings' );

/**
 * Options page.
 *
 * @return void
 */
function addsearch_options_page() {

	/* Get customer key from settings. */
	$addsearch_settings     = get_option( 'addsearch_settings' );
	$addsearch_customer_key = $addsearch_settings['customer_key'];
	$addsearch_installation = $addsearch_settings['installation_method'];

	ob_start(); ?>
	<div class="wrap">

		<h2><?php _e( 'AddSearch Settings', 'addsearch' ); ?></h2>

		<form method="post" action="options.php">

			<?php settings_fields( 'addsearch_settings_group' ); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label><?php _e( 'Your Site Key', 'addsearch' ); ?></label></th>
						<td>
							<label>
								<input type="text" name="addsearch_settings[customer_key]" class="regular-text" value="<?php echo esc_attr( $addsearch_customer_key ); ?>" />
								<p class="description"><?php echo sprintf( _x( 'Enter your Site Key. This will replace all search forms in your site with AddSearch. This means all instances off %s.', '%s stands for function get_search_form()', 'addsearch' ), '<code>get_search_form()</code>' ); ?></p>
							</label>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><label><?php _e( 'Installation method', 'addsearch' ); ?></label></th>
						<td>
							<label>
								<select name="addsearch_settings[installation_method]">
									<option value="widget" <?php if ('widget' === $addsearch_installation) echo 'selected="selected"'; ?>><?php _e('Search as you type (Widget view)', 'addsearch'); ?></option>
									<option value="resultpage" <?php if ('resultpage' === $addsearch_installation) echo 'selected="selected"';?>><?php _e('Separate page for results', 'addsearch') ?></option>
								</select>
								<p class="description">
									<?php _e('Select whether you want to have results as you type, or a separate page for results.', 'addsearch'); ?>
								</p>
							</label>
						</td>
					</tr>
				</tbody>
			</table>

			<?php submit_button(); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label><?php _e( 'About AddSearch', 'addsearch' ); ?></label></th>
						<td>
							<ol>
								<li><?php echo sprintf( __( 'Go to <a href="%s" target="_blank">www.addsearch.com</a> and sign up with your WordPress website address and e-mail.', 'addsearch' ),
								'http://www.addsearch.com/?utm_campaign=Wordpress%20Plugin&utm_source=wordpress_plugin' ); ?></li>
								<li><?php _e( 'Open the confirmation e-mail, and from the bottom, copy your Site Key.', 'addsearch' ); ?></li>
								<li><?php _e( 'Come back to this page in WordPress. Paste your Site Key above and click <strong>Save Changes</strong>.', 'addsearch' ); ?></li>
								<li><?php _e( 'Go to <strong>Appearance &rarr; Widgets</strong>. Drag the WordPress native Search Widget to your preferred widget area.', 'addsearch' ); ?></li>
								<li><?php _e( 'If your theme has search somewhere else, it will automatically be replaced by AddSearch.', 'addsearch' ); ?></li>
								<li><?php _e( 'You\'re done - congrats! :)', 'addsearch' ); ?></li>
							</ol>
						</td>
					</tr>
				</tbody>
			</table>

		</form>

	</div>
	<?php
	echo ob_get_clean();
}

/**
 * Sanitize each setting field as needed
 *
 * @since  1.1.0
 * @param  array $input Contains all settings fields as array keys.
 * @return array $new_input Returns all sanitized settings as array
 */
function addsearch_settings_sanitize( $input ) {
	$required_fields = [ 'customer_key', 'installation_method' ];

	$new_input = array();

	foreach ( $required_fields as $field ) {
		if ( isset( $input[ $field ] ) ) {
			$new_input[ $field ] = esc_attr( $input[ $field ] );
		}
	}

	return $new_input;

}
