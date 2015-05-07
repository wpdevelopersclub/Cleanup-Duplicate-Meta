<noscript>
	<p>
		<em><?php esc_html_e( $this->config['labels']['no_js'] ); ?></em>
	</p>
</noscript>

<h2><?php esc_html_e( $this->config['labels']['header'] ); ?></h2>
<hr>
<p class="header-message"><strong><?php esc_html_e( $this->config['labels']['backup'] ); ?></strong></p>
<p>
	<?php esc_html_e( $this->config['labels']['p1'] ); ?>
</p>
<p>
	<?php esc_html_e( $this->config['labels']['p2'] ); ?>
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
<p><?php esc_html_e( $this->config['labels']['p3'] ); ?></p>