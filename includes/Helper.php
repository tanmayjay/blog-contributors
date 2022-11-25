<?php

namespace Jay\BlogContributors;

defined( 'ABSPATH' ) || exit; // Exit if called directly

/**
 * Helper class.
 *
 * @since 1.0.0
 *
 * @package Jay\BlogContributors
 */
class Helper {

    /**
     * Option key for blog contributors list.
     *
     * @since 1.0.0
     *
     * @var string
     */
    const JB_CONTRIBUTORS_OPTION_KEY = '_jblog_contributors';

    /**
     * Retrieves the contributors for a post.
     *
     * @since 1.0.0
     *
     * @param int|string $post_id
     *
     * @return int[]
     */
    public static function get_contributors( $post_id ) : array {
        $contributors = get_post_meta( $post_id, self::JB_CONTRIBUTORS_OPTION_KEY, true );

        if ( empty( $contributors ) ) {
            return array();
        }

        return (array) $contributors;
    }

    /**
     * Updates the contributors for a post.
     *
     * @since 1.0.0
     *
     * @param int|string $post_id
     * @param array      $contributors
     *
     * @return void
     */
    public static function update_contributors( $post_id, $contributors ) : void {
        update_post_meta( $post_id, self::JB_CONTRIBUTORS_OPTION_KEY, $contributors );
    }

    /**
     * Get list of users who can be contributors.
     *
     * @since 1.0.0
     *
     * @return \WP_User[]|array
     */
    public static function get_assignable_users() : array {
        $users = get_users(
            array(
                'orderby'  => 'user_nicename',
                'order'    => 'ASC',
                'role__in' => array(
                    'administrator',
                    'editor',
                    'author',
                    'contributor',
                ),
            )
        );

        if ( empty( $users ) ) {
            return array();
        }

        return $users;
    }

    /**
     * Returns script version and minified syntax.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public static function get_asset_data() : array {
        if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
            $version = time();
            $min     = '';
        } else {
            $version = JB_CONTRIBUTORS_VERSION;
            $min     = '.min';
        }

        return array(
            $version,
            $min,
        );
    }
}
