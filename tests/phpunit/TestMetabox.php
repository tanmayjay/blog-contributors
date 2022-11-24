<?php

namespace Jay\BlogContributors\Tests;

use Jay\BlogContributors\Tests\Helper;
use Jay\BlogContributors\Admin\Metabox;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Jay\BlogContributors\Helper as JbcHelper;

/**
 * Metabox test case.
 *
 * @since 1.0.0
 *
 * @package Jay\BlogContributors\Tests
 */
class TestMetabox extends TestCase {

	/**
	 * Holds the instance of metabox class.
	 *
	 * @since 1.0.0
	 *
	 * @var Metabox
	 */
	private $metabox_instance;

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
		$this->metabox_instance = new Metabox();
	}

	/**
	 * Tests if add metabox action is registered.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_add_metabox_action_registered() {
		$has_action = has_action( 'add_meta_boxes_post', array( $this->metabox_instance, 'add_post_metaboxes' ) );

		// If registered, the value will be the priority of the hook.
		$this->assertSame( 10, $has_action );
	}

	/**
	 * Test if post metabox is added.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_post_metabox_is_added() {
		$this->metabox_instance->add_post_metaboxes( null );

		global $wp_meta_boxes;

		$this->assertTrue( isset( $wp_meta_boxes['post']['side']['high']['jblog_contributors_checklist'] ) );
	}

	/**
	 * Tests if save post action is registered.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_save_post_action_registered() {
		$has_action = has_action( 'save_post_post', array( $this->metabox_instance, 'save_contributors' ) );

		// If registered, the value will be the priority of the hook.
		$this->assertSame( 10, $has_action );
	}

	/**
	 * Tests if contributors are saved.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_save_contributors() {
		$post_id = Helper::create_post();
		if ( ! $post_id ) {
			return;
		}

		$contributors = array( 1 );

		$_POST = array();
		$_POST['jblog_contributors'] = $contributors;
		$_POST['jblog_contributors_checklist_nonce'] = wp_create_nonce( 'jblog-contributors-checklist-nonce' );

		add_filter( 'map_meta_cap', array( $this, 'ignore_user_cap' ) );
		$this->metabox_instance->save_contributors( $post_id );
		remove_filter( 'map_meta_cap', array( $this, 'ignore_user_cap' ) );

		$saved_contributors = JbcHelper::get_contributors( $post_id );

		$this->assertEquals( $contributors, $saved_contributors );
	}

	/**
	 * Tests if save contributors failed without nonce.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_save_contributors_failed_without_nonce() {
		$post_id = Helper::create_post();
		if ( ! $post_id ) {
			return;
		}

		delete_post_meta( $post_id, JbcHelper::JB_CONTRIBUTORS_OPTION_KEY );

		$contributors = array( 1 );

		$_POST = array();
		$_POST['jblog_contributors'] = $contributors;

		add_filter( 'map_meta_cap', array( $this, 'ignore_user_cap' ) );
		$this->metabox_instance->save_contributors( $post_id );
		remove_filter( 'map_meta_cap', array( $this, 'ignore_user_cap' ) );

		$saved_contributors = JbcHelper::get_contributors( $post_id );

		$this->assertEmpty( $saved_contributors );
	}

	/**
	 * Bypasses user capability check.
	 *
	 * @since 1.0.0
	 *
	 * @param array $caps
	 *
	 * @return array
	 */
	public function ignore_user_cap( $caps ) {
		return array();
	}
}
