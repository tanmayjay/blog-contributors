<?php

namespace Jay\BlogContributors\Tests;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Jay\BlogContributors\Frontend\PostContent;

/**
 * Post content test case.
 *
 * @since 1.0.0
 *
 * @package Jay\BlogContributors\Tests
 */
class TestPostContent extends TestCase {

	/**
	 * Holds the instance of post content class.
	 *
	 * @since 1.0.0
	 *
	 * @var PostContent
	 */
	private $post_content_instance;

	/**
	 * Sets up the fixture, for example, open a network connection.
	 *
	 * This method is called before each test.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function set_up() {
		$this->post_content_instance = new PostContent();
	}

	/**
	 * Tests if post content filter is registered.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_post_content_filter_registered() {
		$has_filter = has_filter( 'the_content', array( $this->post_content_instance, 'show_contributors_list' ) );

		// If registered, the value will be the priority of the hook.
		$this->assertSame( 10, $has_filter );
	}
}
