<?php
/**
 * User: zacharydubois
 * Date: 2015-10-28 08:43
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

/**
 * Application controller.
 *
 * Class app
 * @package Koi
 */
class app {

    /**
     * app constructor.
     */
    public function __construct() {
        require_once KOIDIR . '/inc/koiException.php';
        require_once COMPOSER_PATH . '/autoload.php';
        require_once KOIDIR . '/inc/dataStore.php';
        require_once KOIDIR . '/inc/view.php';
    }

    /**
     * Starts Koi.
     *
     * @return bool
     * @throws koiException
     */
    public function start() {
        if ($this->isInstalled()) {
            $this->run();
        } else {
            $this->install();
        }

        return true;
    }

    private function run() {

    }

    /**
     * Checks if Koi is installed.
     *
     * @return bool
     */
    private function isInstalled() {
        if (file_exists(KOICONF)) {
            return true;
        }

        return false;
    }

    /**
     * Prepares and runs the installer.
     *
     * @return bool
     * @throws koiException
     */
    private function install() {
        require_once KOIDIR . '/inc/installer.php';

        $installer = new installer();


        $didItWork = $installer->run();

        if (is_bool($didItWork)) {
            return $didItWork;
        }

        throw new koiException("Something didn't work! didItWork did not return bool.");
    }
}