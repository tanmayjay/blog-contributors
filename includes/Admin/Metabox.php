<?php

namespace Jay\BlogContributors\Admin;

use Jay\BlogContributors\Helper;

defined( 'ABSPATH' ) || exit; // Exit if called directly

/**
 * Metaboc handler class.
 *
 * @since JBC_SINCE
 *
 * @package jay/jblog-contributors
 */
class Metabox {

    /**
     * Class constructor.
     *
     * @since JBC_SINCE
     *
     * @return void
     */
    public function __construct() {
        add_action( 'add_meta_boxes_post', array( $this, 'add_post_metaboxes' ) );
        add_action( 'save_post_post', array( $this, 'save_contributors' ) );
    }

    /**
     * Adds required metaboxes.
     *
     * @since JBC_SINCE
     *
     * @param \WP_Post $post
     *
     * @return void
     */
    public function add_post_metaboxes( $post ) : void { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
        add_meta_box(
            'jblog_contributors_checklist',
            __( 'Contributors', 'jblog-contributors' ),
            array( $this, 'render_contributors_checklist' ),
            'post',
            'side',
            'high'
        );
    }

    /**
     * Renders checklist for contributors.
     *
     * @since JBC_SINCE
     *
     * @return void
     */
    public function render_contributors_checklist( $post ) : void {
        $users        = Helper::get_assignable_users();
        $contributors = Helper::get_contributors( $post->ID );

        wp_enqueue_script( 'jb-contributers-admin' );
        wp_enqueue_style( 'jb-contributers-select2' );

        ob_start();
        require_once JB_CONTRIBUTORS_TEMPLATES . '/admin/contributors-checklist.php';
        ob_end_flush();
    }

    /**
     * Saves contributors selected from the metabox.
     *
     * @since JBC_SINCE
     *
     * @param int $post_id
     *
     * @return void
     */
    public function save_contributors( $post_id ) : void {
        if ( empty( $_POST['jblog_contributors'] ) ) {
            return;
        }

        if (
            ! isset( $_POST['jblog_contributors_checklist_nonce'] ) ||
            ! wp_verify_nonce( sanitize_key( $_POST['jblog_contributors_checklist_nonce'] ), 'jblog-contributors-checklist-nonce' )
        ) {
            return;
        }

        if ( ! current_user_can( 'edit_posts' ) ) {
            return;
        }

        $contributors = array_map( 'absint', (array) wp_unslash( $_POST['jblog_contributors'] ) );

        Helper::update_contributors( $post_id, $contributors );
    }
}
