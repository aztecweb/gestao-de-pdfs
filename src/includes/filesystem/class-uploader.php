<?php

declare(strict_types=1);

namespace Aztec\Filesystem;

use Aztec\Data\PDF_File_Data;
use Exception;
use WP_Post;

class Uploader {

	private WP_Post $post;

	public function __construct( WP_Post $post ) {
		$this->post = $post;
	}

	public function upload( string $name, string $bits ): PDF_File_Data {
		$upload = wp_upload_bits( $name, null, $bits );
		if ( false !== $upload['error'] ) {
			throw new Exception( esc_html( $upload['error'] ) );
		}

		$path     = $this->extract_relative_path( $upload['file'] );
		$pdf_path = new PDF_File_Data( $this->post, $path );

		return $pdf_path;
	}

	private function extract_relative_path( string $path ): string {
		$upload_dir    = wp_upload_dir();
		$base_dir      = $upload_dir['basedir'];
		$relative_path = str_replace( $base_dir . '/', '', $path );

		return $relative_path;
	}
}
