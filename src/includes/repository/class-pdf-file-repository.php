<?php

declare(strict_types=1);

namespace Aztec\Repository;

use Aztec\Data\PDF_File_Data;
use WP_Post;

class PDF_File_Repository {

	private string $meta_key = '_pdf_file';

	public function get( WP_Post $post ): ?PDF_File_Data {
		$path = get_post_meta( $post->ID, $this->meta_key, true );
		if ( '' === $path ) {
			return null;
		}

		$pdf_file = new PDF_File_Data( $post, $path );

		return $pdf_file;
	}

	public function save( PDF_File_Data $pdf_file ): void {
		update_post_meta( $pdf_file->post()->ID, $this->meta_key, $pdf_file->path() );
	}
}
