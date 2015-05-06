<?php
global $wpdb;

$type = 'postmeta';

return array(

	'type'                  => $type,
	'tablename'             => $wpdb->$type,

	'columns'               => array(
		'primary_id'        => 'meta_id',
		'id'                => 'post_id',
	),

	'labels'                => array(
		'title'             => __( 'Cleanup Post Meta', 'cleanup_dup_meta' ),
		'explanation'       => __( 'You are able to Check for Post Meta Duplicates and/or Cleanup any found duplicates.', 'cleanup_dup_meta' ),
		'cleanup_button'    => __( 'Cleanup Post Meta', 'cleanup_dup_meta' ),
		'count_button'      => __( 'Count Duplicates', 'cleanup_dup_meta' ),
		'query_button'      => __( 'Check for Duplicates', 'cleanup_dup_meta' ),
		'check_count'       => __( "Duplicate records found in the {$wpdb->$type} database table", 'cleanup_dup_meta' ),
		'cleanup_count'     => __( "Duplicate records cleaned in the {$wpdb->$type} database table", 'cleanup_dup_meta' ),
	),

	'ids'                   => array(
		'cleanup_button'    => 'cleanup-dup-postmeta',
		'count_button'      => 'cleanup-dup-postmeta-count',
		'query_button'      => 'cleanup-dup-postmeta-query',
	),
);