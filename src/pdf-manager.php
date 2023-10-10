<?php

/**
 * Plugin Name:     PDF Manager
 * Plugin URI:      https://github.com/aztecweb/gestao-de-pdfs
 * Description:     Project intended for testing by developers..
 * Author:          Aztec Online Solutions
 * Author URI:      https://aztecweb.net
 * Text Domain:     aztec
 * Domain Path:     /languages
 * Version:         0.1.0
 */

declare(strict_types=1);

use Aztec\Post_Type\PDF_Manager_Meta_Box;
use Aztec\Post_Type\PDF_Manager_Post_Type;
use Aztec\Post_Type\PDF_Manager_Save_Post_Controller;

require_once 'autoload.php';

add_action(
	'init',
	function () {
		$post_type = new PDF_Manager_Post_Type();

		add_action(
			'admin_init',
			function () use ( $post_type ) {
				new PDF_Manager_Meta_Box( $post_type );
			}
		);

		add_action(
			'save_post',
			function ( int $post_id ) use ( $post_type ) {
				new PDF_Manager_Save_Post_Controller( $post_type, $post_id );
			}
		);
	}
);
