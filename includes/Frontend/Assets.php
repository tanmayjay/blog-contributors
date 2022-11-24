<?php

namespace Jay\BlogContributors\Frontend;

defined( 'ABSPATH' ) || exit; // Exit if called directly

use Jay\BlogContributors\Helper;

/**
 * Assets handler class.
 *
 * @since JBC_SINCE
 *
 * @package jay/jblog-contributors
 */
class Assets {

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
        add_action( 'init', array( $this, 'register_scripts' ) );
    }

    /**
     * Registers scripts and styles.
     *
     * @since JBC_SINCE
     *
     * @return void
     */
    public function register_scripts() : void {
        list( $version, $min ) = Helper::get_asset_data();

        wp_register_style(
            'jb-contributers-frontend',
            JB_CONTRIBUTORS_ASSETS . "/css/frontend{$min}.css",
            array(),
            $version
        );
        wp_register_style(
            'jb-contributers-select2',
            JB_CONTRIBUTORS_LIB . '/select2/select2.min.css',
            array(),
            $version
        );
        wp_register_script(
            'jb-contributers-select2',
            JB_CONTRIBUTORS_LIB . '/select2/select2.full.min.js',
            array( 'jquery' ),
            $version,
            true
        );
    }
}
