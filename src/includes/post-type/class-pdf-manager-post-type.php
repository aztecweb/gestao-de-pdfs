<?php

declare(strict_types=1);

namespace Aztec\Post_Type;

class PDF_Manager_Post_Type {

	public function __construct() {
		register_post_type(
			$this->slug(),
			array(
				'supports' => array( 'title' ),
				'labels'   => array(
					'name'               => _x( 'PDFs', 'post type general name', 'aztec' ),
					'singular_name'      => _x( 'PDF', 'post type singular name', 'aztec' ),
					'menu_name'          => _x( 'PDFs', 'admin menu', 'aztec' ),
					'add_new'            => _x( 'Add New', 'pdf', 'aztec' ),
					'add_new_item'       => __( 'Add New PDF', 'aztec' ),
					'edit'               => __( 'Edit', 'aztec' ),
					'edit_item'          => __( 'Edit PDF', 'aztec' ),
					'new_item'           => __( 'New PDF', 'aztec' ),
					'view'               => __( 'View PDF', 'aztec' ),
					'view_item'          => __( 'View PDF', 'aztec' ),
					'search_items'       => __( 'Search PDFs', 'aztec' ),
					'not_found'          => __( 'No PDFs found', 'aztec' ),
					'not_found_in_trash' => __( 'No PDFs found in Trash', 'aztec' ),
					'parent'             => __( 'Parent PDF', 'aztec' ),
				),
				'public'  => false,
				'show_ui' => true,
			)
		);
	}

	public function slug(): string {
		return 'pdf';
	}
}
