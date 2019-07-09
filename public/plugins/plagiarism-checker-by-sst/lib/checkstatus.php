<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) 
{ 
die('Direct Access not permitted...'); 
}
function sst_checkStatus()
{
	$data = array(
		"key" => sanitize_text_field(@$_POST['key']),
		"v" => sanitize_text_field(@$_POST['v'])
	);
	$fields = $data;
	$target = SST_ACTION_SITE.'frontend/checkAccountStatus';
	$response = wp_remote_post( $target, array(
			'method' => 'POST' ,
			'timeout' => 20,
    		'redirection' => '5',
			'body' => $fields
		)
	);
	echo wp_remote_retrieve_body($response);
	exit();
}