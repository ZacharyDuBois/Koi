<?php
/**
 * User: zacharydubois
 * Date: 2015-11-02 20:50
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class installer {

    private $config;

    function __construct() {
        $this->config = new dataStore(KOICONF);
    }

    function run() {

    }

}