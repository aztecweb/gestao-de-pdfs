<?php

declare(strict_types=1);

namespace Aztec\Post_Type;

use Aztec\Filesystem\Filesystem;
use Aztec\Filesystem\Uploader;
use Aztec\Repository\PDF_File_Repository;
use Exception;
use WP_Post;

class PDF_Manager_Save_Post_Controller {

	private PDF_Manager_Post_Type $post_type;
	private WP_Post $post;

	public function __construct( PDF_Manager_Post_Type $post_type, int $post_id ) {
		$this->post_type = $post_type;
		$this->post      = $this->get_post( $post_id );

		$this->save_post();
	}

	private function get_post( int $post_id ): WP_Post {
		$post = get_post( $post_id );
		if ( ! $post instanceof WP_Post ) {
			/* translators: the post id */
			throw new Exception( esc_html( sprintf( __( 'Cannot retrieve post %d.', 'aztec' ), $post_id ) ) );
		}

		return $post;
	}

	public function save_post(): void {
		$screen = new PDF_Manager_Screen( $this->post_type );

		$action = $screen->action( $this->post );
		if ( PDF_Manager_Screen::SAVE_ACTION !== $action ) {
			return;
		}

		if ( ! check_admin_referer( 'update-post_' . $this->post->ID ) ) {
			throw new Exception( 'Invalid action.' );
		}

		if ( ! isset( $_FILES['_issue_pdf']['name'], $_FILES['_issue_pdf']['tmp_name'] ) ) {
			throw new Exception( 'Invalid action.' );
		}

		$name         = sanitize_text_field( wp_unslash( $_FILES['_issue_pdf']['name'] ) );
		$tmp_name     = sanitize_text_field( wp_unslash( $_FILES['_issue_pdf']['tmp_name'] ) );
		$file_content = ( new Filesystem() )->get_contents( $tmp_name );
		$pdf_file     = ( new Uploader( $this->post ) )->upload( $name, $file_content );

		( new PDF_File_Repository() )->save( $pdf_file );
	}
}
