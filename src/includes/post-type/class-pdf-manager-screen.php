<?php

declare(strict_types=1);

namespace Aztec\Post_Type;

use Exception;
use WP_Post;
use WP_Screen;

class PDF_Manager_Screen {

	const SKIP_ACTION = 1;
	const EDIT_ACTION = 2;
	const SAVE_ACTION = 3;

	private WP_Screen $screen;

	private PDF_Manager_Post_Type $post_type;

	public function __construct( PDF_Manager_Post_Type $post_type ) {
		$this->screen    = $this->get_screen();
		$this->post_type = $post_type;
	}

	private function get_screen(): WP_Screen {
		$screen = get_current_screen();
		if ( null === $screen ) {
			throw new Exception( 'Screen data cannot be loaded at this point in the request.' );
		}

		return $screen;
	}

	public function action( ?WP_Post $post = null ): int {
		if ( $this->post_type->slug() !== $this->screen->post_type ) {
			return self::SKIP_ACTION;
		}

		if ( ! isset( $_POST['_wpnonce'] ) ) {
			return self::EDIT_ACTION;
		}

		if ( null === $post ) {
			throw new Exception( 'Invalid action.' );
		}

		if ( check_admin_referer( 'update-post_' . $post->ID ) ) {
			return self::SAVE_ACTION;
		}

		throw new Exception( 'Invalid action.' );
	}
}
