<hr>

<div class="cleanup-dup-<?php esc_attr_e( $this->config['table'] ); ?>-container cleanup-dup-container">

	<h3><?php esc_html_e( $this->config['labels']['title'] ); ?></h3>
	<p>
		<?php esc_html_e( $this->config['labels']['explanation'] ); ?>
	</p>

	<form id="cleanup-dup-<?php esc_attr_e( $this->config['table'] ); ?>-form" method="post" action="">

		<?php wp_nonce_field( esc_attr( $this->config['nonce'] ) ); ?>

		<p>
			<input type="radio" name="cleanup-dup-meta-keep" value="first"><?php _e( 'Keep the first duplicate meta', 'cleanup_dup_meta' ); ?>
		</p>
		<p>
			<input type="radio" name="cleanup-dup-meta-keep" value="last" checked="checked"><?php _e( 'Keep the last duplicate meta', 'cleanup_dup_meta' ); ?>
		</p>
		<p>
			<input type="text" id="<?php esc_attr_e( $this->config['ids']['cleanup_button'] ); ?>" name="cleanup-dup-meta" class="button hide-if-no-js" value="<?php esc_html_e( $this->config['labels']['cleanup_button'] ); ?>">

			<input type="text" id="<?php esc_attr_e( $this->config['ids']['count_button'] ); ?>" name="cleanup-dup-meta-count" class="button hide-if-no-js" value="<?php esc_html_e( $this->config['labels']['count_button'] ); ?>">
		</p>
		<footer class="status">
			<img src="<?php echo esc_url( $this->config['loading_image']['src'] ); ?>" width="<?php esc_attr_e( $this->config['loading_image']['width'] ); ?>" height="<?php esc_attr_e( $this->config['loading_image']['height'] ); ?>"  style="display: none;" />
			<p class="message-count" style="display: none;">
				<span>0</span> <?php esc_html_e( $this->config['labels']['check_count'] ); ?>
			</p>
			<p class="message-cleanup" style="display: none;">
				<span>0</span> <?php esc_html_e( $this->config['labels']['cleanup_count'] ); ?>
			</p>
		</footer>
	</form>
</div>