<?php
/**
 * User: zacharydubois
 * Date: 2015-10-28 08:43
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class app {
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

        } else {
            $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
            header('Location: ' . $host . '/');
        }
    }
}