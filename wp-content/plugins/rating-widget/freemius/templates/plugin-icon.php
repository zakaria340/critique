<?php
	/**
	 * @package     Freemius
	 * @copyright   Copyright (c) 2015, Freemius, Inc.
	 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
	 * @since       1.1.4
	 */
	$slug = $VARS['slug'];
	$fs   = freemius( $slug );

	$icons = glob( fs_normalize_path( WP_FS__DIR_IMG . '/icon.*' ) );
	if ( ! is_array( $icons ) || 0 === count( $icons ) ) {
		if ( WP_FS__IS_LOCALHOST && $fs->is_org_repo_compliant() ) {
			/**
			 * IMPORTANT: THIS CODE WILL NEVER RUN AFTER THE PLUGIN IS IN THE REPO.
			 *
			 * This code will only be executed once during the testing
			 * of the plugin in a local environment. The plugin icon file WILL
			 * already exist in the assets folder when the plugin is deployed to
			 * the repository.
			 */
			$suffixes = array(
				'128x128.png',
				'128x128.jpg',
				'256x256.png',
				'256x256.jpg',
				'.svg',
			);

			$base_url = 'https://plugins.svn.wordpress.org/' . $slug . '/assets/icon-';

			$icon_found = false;
			$local_path = fs_normalize_path( WP_FS__DIR_IMG . '/icon.png' );

			foreach ( $suffixes as $s ) {
				$headers = get_headers( $base_url . $s );
				if ( strpos( $headers[0], '200' ) ) {
					$local_path = fs_normalize_path( WP_FS__DIR_IMG . '/icon.' . substr( $s, strpos( $s, '.' ) + 1 ) );
					fs_download_image( $base_url . $s, $local_path );
					$icon_found = true;
					break;
				}
			}

			if ( ! $icon_found ) {
				// No icons found, fallback to default icon.
				copy( fs_normalize_path( WP_FS__DIR_IMG . '/plugin-icon.png' ), $local_path );
			}

			$icons = array( $local_path );
		}
	}

	$relative_url = fs_img_url( substr( $icons[0], strlen( fs_normalize_path( WP_FS__DIR_IMG ) ) ) );
?>
<div class="fs-plugin-icon">
	<img src="<?php echo $relative_url ?>"/>
</div>