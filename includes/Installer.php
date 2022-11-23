<?php

namespace Jay\BlogContributors;

defined( 'ABSPATH' ) || exit; // Exit if called directly

/**
 * Plugin installer.
 *
 * @since 1.0.0
 *
 * @package jay/jblog-contributors
 */
class Installer {

    /**
     * Executes necessary setup for installing.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function run() : void {
        self::add_version_info();
    }

    /**
     * Adds version inforrmation.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function add_version_info() : void {
        update_option( 'jblog_contributors_version', JB_CONTRIBUTORS_VERSION );
    }
}
