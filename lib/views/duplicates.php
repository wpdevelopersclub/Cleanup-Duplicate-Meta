<table class="query-results-table">
	<thead>
		<tr>
			<th><?php esc_html_e( $this->columns['primary_id'] ); ?></th>
			<th><?php esc_html_e( $this->columns['id'] ); ?></th>
			<th>meta_key</th>
			<th>meta_value</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( (array) $local_variables as $result ) : ?>
		<tr>
			<td><?php echo intval( $result->{$this->columns['primary_id']} ); ?></td>
			<td><?php echo intval( $result->{$this->columns['id']} ); ?></td>
			<td><?php esc_html_e( $result->meta_key ); ?></td>
			<td><?php esc_html_e( $result->meta_value ); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>