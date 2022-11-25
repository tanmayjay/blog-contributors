<?php

namespace Jay\BlogContributors\Frontend;

defined( 'ABSPATH' ) || exit; // Exit if called directly

use Jay\BlogContributors\Helper;

/**
 * Post content handler class.
 *
 * @since JBC_SINCE
 *
 * @package jay/jblog-contributors
 */
class PostContent {

    /**
     * Class constructor.
     *
     * @since JBC_SINCE
     *
     * @return void
     */
    public function __construct() {
        $this->hooks();
    }

    /**
     * Registers all hooks.
     *
     * @since JBC_SINCE
     *
     * @return void
     */
    private function hooks() : void {
        add_filter( 'the_content', array( $this, 'show_contributors_list' ) );
    }

    /**
     * Filters post content to show contributors' list.
     *
     * @since JBC_SINCE
     *
     * @param string $content
     *
     * @return string
     */
    public function show_contributors_list( string $content ) : string {
        global $post;

        if ( 'post' !== $post->post_type ) {
            return $content;
        }

        $contributors = Helper::get_contributors( $post->ID );

        if ( empty( $contributors ) ) {
            return $content;
        }

        ob_start();
        require_once JB_CONTRIBUTORS_TEMPLATES . '/contributors-list.php';
        $content .= ob_get_clean();

        return $content;
    }
}
