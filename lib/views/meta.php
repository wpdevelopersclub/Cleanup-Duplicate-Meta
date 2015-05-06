<hr>

<div class="cleanup-dup-<?php esc_attr_e( $this->type ); ?>-container cleanup-dup-container">

	<h3><?php esc_html_e( $this->config['labels']['title'] ); ?></h3>
	<p>
		<?php esc_html_e( $this->config['labels']['explanation'] ); ?>
	</p>

	<form id="cleanup-dup-<?php esc_attr_e( $this->type ); ?>-form" method="post" action="">

		<?php wp_nonce_field( esc_attr( $this->nonce ) ); ?>

		<p>
			<input type="radio" name="cleanup-dup-meta-keep" value="first"><?php _e( 'Keep the first duplicate meta', 'cleanup_dup_meta' ); ?>
		</p>
		<p>
			<input type="radio" name="cleanup-dup-meta-keep" value="last" checked="checked"><?php _e( 'Keep the last duplicate meta', 'cleanup_dup_meta' ); ?>
		</p>
		<p>
			<input type="text" id="<?php esc_attr_e( $this->config['ids']['query_button'] ); ?>" name="cleanup-dup-meta-query" class="button hide-if-no-js" value="<?php esc_html_e( $this->config['labels']['query_button'] ); ?>" data-action="<?php esc_attr_e( $this->actions['query'] ); ?>">

			<input type="text" id="<?php esc_attr_e( $this->config['ids']['count_button'] ); ?>" name="cleanup-dup-meta-count" class="button hide-if-no-js" value="<?php esc_html_e( $this->config['labels']['count_button'] ); ?>" data-action="<?php esc_attr_e( $this->actions['count'] ); ?>">

			<input type="text" id="<?php esc_attr_e( $this->config['ids']['cleanup_button'] ); ?>" name="cleanup-dup-meta" class="button hide-if-no-js" value="<?php esc_html_e( $this->config['labels']['cleanup_button'] ); ?>" data-action="<?php esc_attr_e( $this->actions['cleanup'] ); ?>">
		</p>
		<footer class="status">
			<img src="<?php echo esc_url( CLEANUP_DUP_META_PLUGIN_URL . 'assets/images/ajax-loader.gif' ); ?>" width="128" height="15"  style="display: none;" />
			<p class="message-count" style="display: none;">
				<span>0</span> <?php esc_html_e( $this->config['labels']['check_count'] ); ?>
			</p>
			<p class="message-cleanup" style="display: none;">
				<span>0</span> <?php esc_html_e( $this->config['labels']['cleanup_count'] ); ?>
			</p>
			<p class="message-query"></p>
		</footer>
	</form>
</div>