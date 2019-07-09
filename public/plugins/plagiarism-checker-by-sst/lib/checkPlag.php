<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) 
{ 
die('Direct Access not permitted...'); 
}
function sst_checkPlag()
{
	$query = sanitize_text_field(@$_POST['query']);
	$query = stripslashes($query);

	$data = array(
		"query" => $query,
		"key" => sanitize_text_field(@$_POST['key']),
		"ignore" => get_site_url()
	);
	$fields = http_build_query($data);
	$target = SST_ACTION_SITE.'frontend/checkPlagWPv2';
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