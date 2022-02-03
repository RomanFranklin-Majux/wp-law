<?php defined( 'ABSPATH' ) || exit; ?>

<div class="notice notice-warning">
	<p><strong><?php esc_html_e( 'Shortcodes Ultimate: Additional Skins', 'shortcodes-ultimate-skins' ); ?></strong></p>
	<p><?php esc_html_e( 'Please install and activate the latest version of Shortcodes Ultimate (core plugin) in order to use this add-on.', 'shortcodes-ultimate-skins' ); ?></p>
	<p>
		<a
			href="<?php echo esc_url( $this->get_install_core_link() ); ?>"
			class="thickbox open-plugin-details-modal button"
		><?php esc_html_e( 'Install Now', 'shortcodes-ultimate-skins' ); ?></a>
		<a href="<?php echo esc_url( $this->get_dismiss_link( true ) ); ?>" style="margin-left:1.2em"><?php esc_html_e( 'Remind me later', 'shortcodes-ultimate-skins' ); ?></a>
		<a href="<?php echo esc_url( $this->get_dismiss_link() ); ?>" style="margin-left:1.2em"><?php esc_html_e( 'Dismiss', 'shortcodes-ultimate-skins' ); ?></a>
	</p>
</div>
