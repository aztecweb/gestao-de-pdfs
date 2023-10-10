<?php

declare(strict_types=1);

namespace Aztec\Data;

use WP_Post;

class PDF_File_Data {

	private WP_Post $post;

	private string $path;

	public function __construct( WP_Post $post, string $path ) {
		$this->post = $post;
		$this->path = $path;
	}

	public function post(): WP_Post {
		return $this->post;
	}

	public function path(): string {
		return $this->path;
	}

	public function url(): string {
		$upload_dir = wp_upload_dir();
		$base_url   = $upload_dir['baseurl'];
		$file_url   = $base_url . '/' . $this->path;

		return $file_url;
	}

	public function absolute_path(): string {
		$upload_dir = wp_upload_dir();
		$base_dir   = $upload_dir['basedir'];
		$file_path  = $base_dir . '/' . $this->path;

		return $file_path;
	}
}
