<noscript>
	<p>
		<em><?php _e( 'You must enable Javascript in order to proceed!', 'cleanup_dup_meta' ) ?></em>
	</p>
</noscript>


<h2><?php _e( 'Welcome to Cleanup Duplicate Meta', 'cleanup_dup_meta' ); ?></h2>
<hr>
<p class="header-message"><strong><?php _e( 'Backup your database before running the Cleanup.', 'cleanup_dup_meta' ); ?></strong></p>
<p>
	<?php _e( 'Use this tool to delete duplicate post and/or meta records in the database. The tool runs a simple SQL script, which deletes all of the duplicates and leaves either the first or last duplicate, per your selection.', 'cleanup_dup_meta' ); ?>
	<?php _e( 'This tool is broken up into sections for post and user meta.', 'cleanup_dup_meta' ); ?>
</p>
<p>
	<?php _e( "For example, let's say the following is within the {$wpdb->postmeta} database table:", 'cleanup_dup_meta' ); ?>
	<table>
		<thead>
			<tr>
				<th>Meta ID</th>
				<th>Post ID</th>
				<th>Meta Key</th>
				<th>Meta Value</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>1</td>
				<td>_some_meta_key</td>
				<td>some value</td>
			</tr>
			<tr>
				<td>10</td>
				<td>1</td>
				<td>_some_meta_key</td>
				<td>some other value</td>
			</tr>
			<tr>
				<td>15</td>
				<td>1</td>
				<td>_some_meta_key</td>
				<td>still another value</td>
			</tr>
		</tbody>
	</table>
</p>
<p><?php _e( 'If you select "leave first", then running this tool will delete Meta ID 2 and 15 (i.e. the duplicates but not the first one).  Selecting "leave last" deletes the first and second one but leaves the last one.', 'cleanup_dup_meta' ); ?></p>