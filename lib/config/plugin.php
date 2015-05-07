<?php

global $wpdb;

return array(
	'view'      => CLEANUP_DUP_META_PLUGIN_DIR . 'lib/views/menu-page.php',

	'labels'    => array(
		'no_js'     => __( 'You must enable Javascript in order to proceed!', 'cleanup_dup_meta' ),
		'header'    => __( 'Welcome to Cleanup Duplicate Meta', 'cleanup_dup_meta' ),
		'backup'    => __( 'Backup your database before running the Cleanup.', 'cleanup_dup_meta' ),
		'p1'        => __( 'Use this tool to check for and/or delete duplicate post and/or meta records in the database. The tool runs a simple SQL script, which deletes all of the duplicates and leaves either the first or last duplicate, per your selection.  This tool is broken up into sections for post and user meta.', 'cleanup_dup_meta' ),
		'p2'        => sprintf( __( 'For example, let\'s say the following is within the %s database table:', 'cleanup_dup_meta' ), $wpdb->postmeta ),
		'p3'        => __( 'If you select "Keep the first duplicate meta", then running this tool will delete Meta ID 10 and 15 (i.e. the duplicates but not the first one).  Selecting "Keep the last duplicate meta" deletes the first and second one but leaves the last one.', 'cleanup_dup_meta' ),
	),
);