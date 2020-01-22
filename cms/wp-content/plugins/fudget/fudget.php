<?php
/**
 * Plugin Name: Brownie Fudget
 * Description: A fudget spinner
 * Version: 1.0
 * Author: Lazaro
 * License: GPL2
*/

// Register an additional theme directory
if ( function_exists( 'register_theme_directory' ) )
   register_theme_directory( $_SERVER[ 'DOCUMENT_ROOT' ] . '/resources/wordpress-themes' );

/*
 *
 * Add (more like restore) a couple of upload-related fields
 * 	You can actually find the markup for these settings in `wp-admin/options-media.php`
 *
 */
add_action( 'load-options-media.php', function () {

	// Upload path (on filesystem)
	register_setting( 'media', 'upload_path', 'esc_attr' );
	add_settings_field( 'upload_path', __( 'Store uploads in this folder' ), function ( $args ) {
		?>
			<input type="text" name="upload_path" id="upload_path" class="regular-text code" value=<?= esc_attr( get_option( 'upload_path' ) ) ?>>
			<p class="description">Default is <code>wp-content/uploads</code></p>
		<?php
	}, 'media', 'uploads', [ 'label_for' => 'upload_path' ] );

	// URL to uploads
	register_setting( 'media', 'upload_url_path', 'esc_attr' );
	add_settings_field( 'upload_url_path', __( 'Full URL path to files' ), function ( $args ) {
		?>
			<input type="text" name="upload_url_path" id="upload_url_path" class="regular-text code" value=<?= esc_attr( get_option( 'upload_url_path' ) ) ?>>
			<p class="description"><?= __( 'Configuring this is optional. By default, it should be blank.' ); ?></p>
		<?php
	}, 'media', 'uploads', [ 'label_for' => 'upload_url_path' ] );

} );

?>
