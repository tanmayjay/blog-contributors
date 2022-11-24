<?php

namespace Jay\BlogContributors\Tests;

/**
 * Helper class for tests.
 *
 * @since 1.0.0
 *
 * @package Jay\BlogContributors\Tests
 */
class Helper {

    /**
	 * Creates test post.
	 *
	 * @since 1.0.0
	 *
	 * @return int|false
	 */
	public static function create_post() {
		$post = get_page_by_path( 'test-post', OBJECT, 'post' );
		if ( $post ) {
			return $post->ID;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => 'Test Post',
				'post_content' => 'This is a test post',
				'post_status'  => 'publish',
			)
		);

		if ( empty( $post_id ) || is_wp_error( $post_id ) ) {
			return false;
		}

		return $post_id;
	}
}
