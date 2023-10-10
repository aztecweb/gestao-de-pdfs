<?php

declare(strict_types=1);

namespace Aztec\Post_Type;

use Aztec\Repository\PDF_File_Repository;
use Exception;
use WP_Post;

class PDF_Manager_Meta_Box {

	private PDF_Manager_Post_Type $post_type;

	public function __construct( PDF_Manager_Post_Type $post_type ) {
		$this->post_type = $post_type;

		add_meta_box(
			'pdf',
			__( 'File', 'aztec' ),
			array( $this, 'meta_box_content' ),
			$this->post_type->slug()
		);

		add_action( 'current_screen', array( $this, 'maybe_add_form_enctype_to_allow_upload' ) );
	}

	public function meta_box_content( WP_Post $post ): void {
		$file_url = '';
		$pdf_file = ( new PDF_File_Repository() )->get( $post );

		if ( null !== $pdf_file ) {
			$file_url = $pdf_file->url();
		}

		$args = array(
			'file_url' => $file_url,
		);

		load_template( __DIR__ . '/../resources/view/pdf-manager-post-edit-meta-box.php', false, $args );
	}

	public function maybe_add_form_enctype_to_allow_upload(): void {
		try {
			$screen = new PDF_Manager_Screen( $this->post_type );

			$action = $screen->action();
			if ( PDF_Manager_Screen::EDIT_ACTION !== $action ) {
				return;
			}

			add_action( 'post_edit_form_tag', array( $this, 'add_form_enctype_to_allow_upload' ) );

		// phpcs:disable Generic.CodeAnalysis.EmptyStatement.DetectedCatch
		} catch ( Exception $e ) {
			// Ignorar caso ação é inválida.
		}
	}

	public function add_form_enctype_to_allow_upload(): void {
		echo 'enctype="multipart/form-data"';
	}
}
