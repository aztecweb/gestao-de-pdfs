<?php

declare(strict_types=1);

namespace Aztec\Filesystem;

use Exception;
use WP_Filesystem_Base;

class Filesystem {

	private WP_Filesystem_Base $filesystem;

	public function __construct() {
		$this->filesystem = $this->init_filesystem();
	}

	private function init_filesystem(): WP_Filesystem_Base {
		global $wp_filesystem;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
		}

		WP_Filesystem();

		return $wp_filesystem;
	}

	public function get_contents( string $path ): string {
		$file_content = $this->filesystem->get_contents( $path );

		if ( ! $file_content ) {
			/* translators: file path */
			throw new Exception( esc_html( sprintf( __( 'Cannot read %s file', 'aztec' ), $path ) ) );
		}

		return $file_content;
	}
}
