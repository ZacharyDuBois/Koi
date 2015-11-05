<?php
/**
 * User: zacharydubois
 * Date: 2015-10-28 08:43
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class app {
    public function __construct() {
        require_once KOIDIR . '/inc/koiException.php';
        require_once COMPOSER_PATH . '/autoload.php';
        require_once KOIDIR . '/inc/dataStore.php';
    }

    public function start() {
        if ($this->isInstalled()) {
            $this->run();
        } else {
            $this->install();
        }
        return true;
    }

    private function isInstalled() {
        if (file_exists(KOIDIR . '/data')) {
            return true;
        }

        return false;
    }

    private function run() {

    }

    private function install() {
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');

        if ($uri === '/' || $uri === '') {
            require_once KOIDIR . '/inc/installer.php';

            $installer = new installer();
            $didItWork = $installer->run();
        } else {
            $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
            header('Location: ' . $host . '/');
        }

        if (is_bool($didItWork)) {
            return $didItWork;
        }

        throw new koiException("Something didn't work!");
    }
}