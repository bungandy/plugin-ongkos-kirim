<div class="wrap pok-wrapper">
	<h1 class="wp-heading-inline">Plugin Ongkos Kirim</h1>
	<hr class="wp-header-end">
	<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
		<?php foreach ( $tabs as $key => $value ) : ?>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=pok_setting&tab=' . $key ) ); ?>" class="nav-tab <?php echo $tab === $key ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $value['label'] ); ?></a>
		<?php endforeach; ?>
		<div class="additional-tab">
			<a href="http://pustaka.tonjoostudio.com/plugins/woo-ongkir-manual/" target="_blank"><span class="dashicons dashicons-book"></span> <?php esc_html_e( 'Documentation', 'pok' ) ?></a>
			<a href="https://forum.tonjoostudio.com/thread-category/woo-ongkir/" target="_blank"><span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Support Forum', 'pok' ) ?></a>
		</div>
	</nav>
	<div class="pok-setting-content">
		<?php
		if ( isset( $tabs[ $tab ]['callback'] ) ) {
			call_user_func( $tabs[ $tab ]['callback'] );
		}
		?>
	</div>
</div>
