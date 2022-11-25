<?php

namespace Jay\BlogContributors;

defined( 'ABSPATH' ) || exit; // Exit if called directly

/**
 * Frontend handler class.
 *
 * @since JBC_SINCE
 *
 * @package jay/jblog-contributors
 */
class Frontend {

    /**
     * Class constructor.
     *
     * @since JBC_SINCE
     *
     * @return void
     */
    public function __construct() {
        $this->init_classes();
    }

    /**
     * Instantiates necessary classes.
     *
     * @since JBC_SINCE
     *
     * @return void
     */
    private function init_classes() : void {
        new Frontend\PostContent();
    }
}
