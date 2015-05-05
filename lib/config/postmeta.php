<?php
global $wpdb;

return array(
	'table'                 => 'postmeta',

	'view'                  => CLEANUP_DUP_META_PLUGIN_DIR . 'lib/views/meta.php',

	'loading_image'         => array(
		'src'               => CLEANUP_DUP_META_PLUGIN_URL . 'assets/images/ajax-loader.gif',
		'width'             => 128,
		'height'            => 15,
	),

	'nonce'                 => '_cleanup_duplicate_postmeta',

	'labels'                => array(
		'title'             => __( 'Cleanup Post Meta', 'cleanup_dup_meta' ),
		'explanation'       => __( 'You are able to Check for Post Meta Duplicates and/or Cleanup any found duplicates.', 'cleanup_dup_meta' ),
		'cleanup_button'    => __( 'Cleanup Post Meta', 'cleanup_dup_meta' ),
		'count_button'      => __( 'Check for Duplicates', 'cleanup_dup_meta' ),
		'check_count'       => __( "Duplicate records found in the {$wpdb->postmeta} database table", 'cleanup_dup_meta' ),
		'cleanup_count'     => __( "Duplicate records cleaned in the {$wpdb->postmeta} database table", 'cleanup_dup_meta' ),
	),

	'ids'                   => array(
		'cleanup_button'    => 'cleanup-dup-postmeta',
		'count_button'      => 'cleanup-dup-postmeta-count',
	),
);