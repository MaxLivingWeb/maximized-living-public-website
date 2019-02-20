<?php

//Starting session
session_start();

//UTM Tags
global $utmTags;
$utmTags = $_GET;

//Loop through query string to set session variables
foreach ( $utmTags as $tag => $value ) {
	if ( ! isset( $_SESSION[ $tag ] ) ) {
		if ( isset( $_GET[ $tag ] ) ) {
			$_SESSION[ $tag ] = $value;
		}
	}
}

/**
 *
 * Handles query string variables when going from corporate to the store
 *
 * @param string $type
 * @param string $url
 * @param string $set
 *
 * @return string
 */
function utmURL( $type = '', $url = '', $set = '?' ) {
	//Child Site for affiliate id query string
	if ( $type === 'child' ) {
		$set = '&';
	}
	//Loop through session variables to build url
    if(get_current_user_id() != 1) {
        foreach ( $_SESSION as $tag => $value ) {
            $url .= $set . $tag . '=' . $value;
            $set = '&';
        }
    }

	//Send url back with query string items if available
	return $url;
}
