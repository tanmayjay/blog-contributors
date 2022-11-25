<?php

/**
 * Plugin Name: Blog Contributors
 * Description: A plugin to manage multiple contributors for a single post.
 * Plugin URI: https://github.com/tanmayjay/blog-contributors
 * Author: Tanmay Jay
 * Author URI: https://jktanmay.com
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: jblog-contributors
 * Domain Path: /languages/
 * Requires at least: 5.8
 * Requires PHP: 7.2
 *
 * Copyright (c) 2022 Tanmay Kirtania (email: jktanmay@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

defined( 'ABSPATH' ) || exit; // Exit if called directly

/**
 * Main class
 *
 * @package jay/blog-contributors
 */
final class JblogContributors {

    /**
     * Plugin version.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $version = '1.0.0';

    /**
     * Minimum PHP version for the plugin.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $minimum_php = '7.2';

    /**
     * The class instance.
     *
     * @since 1.0.0
     *
     * @var self
     */
    private static $instance = null;

    /**
     * Instantiates the class.
     *
     * @since 1.0.0
     *
     * @return self
     */
    public static function init() : self {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * CLass constructor.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function __construct() {
        $this->includes();
        $this->constants();
        $this->init_plugin();
    }

    /**
     * Includes necessary files.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function includes() : void {
        require_once __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Defines all the necessary constants.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function constants() : void {
        define( 'JB_CONTRIBUTORS_VERSION', $this->version );
        define( 'JB_CONTRIBUTORS_FILE', __FILE__ );
        define( 'JB_CONTRIBUTORS_DIR', dirname( JB_CONTRIBUTORS_FILE ) );
        define( 'JB_CONTRIBUTORS_TEMPLATES', JB_CONTRIBUTORS_DIR . '/templates' );
        define( 'JB_CONTRIBUTORS_INC', JB_CONTRIBUTORS_DIR . '/includes' );
        define( 'JB_CONTRIBUTORS_LIB', plugins_url( 'lib', JB_CONTRIBUTORS_FILE ) );
        define( 'JB_CONTRIBUTORS_ASSETS', plugins_url( 'assets', JB_CONTRIBUTORS_FILE ) );
    }

    /**
     * Initiates the functionalities of the plugin.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function init_plugin() : void {
        $this->init_hooks();
        $this->init_classes();

        do_action( 'jb_contributors_loaded' );
    }

    /**
     * Instanciates the classes.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function init_classes() : void {
        new Jay\BlogContributors\Frontend();
        new Jay\BlogContributors\Admin();
    }

    /**
     * Initiates the hooks.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function init_hooks() : void {
        register_activation_hook( JB_CONTRIBUTORS_FILE, [ $this, 'activate' ] );
    }

    /**
     * Executes activation requirements.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function activate() : void {
        if ( ! $this->has_minimum_php_version() ) {
            exit;
        }

        Jay\BlogContributors\Installer::run();
    }

    /**
     * Check if the PHP version is supported.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function has_minimum_php_version() : bool {
        return version_compare( PHP_VERSION, $this->minimum_php, '>=' );
    }
}


/**
 * Returns the instance of the main class.
 *
 * @since 1.0.0
 *
 * @return JblogContributors
 */
function jblog_contributors() : JblogContributors {
    return JblogContributors::init();
}

// Kick-off the plugin
jblog_contributors();
