<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
{
die('Direct Access not permitted...');
}
function sst_b_s()
{

	$html = sanitize_text_field(@$_POST['s']);
	$html = stripslashes($html);
	$data = array(
		"key" => sanitize_text_field(@$_POST['key']),
		"v" => sanitize_text_field(@$_POST['v']),
		"sntence" =>sanitize_text_field(@$html)
	);
	$fields = $data;
	$target = SST_ACTION_SITE.'frontend/sst_break_sentence';
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