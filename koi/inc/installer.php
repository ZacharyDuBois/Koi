<?php
/**
 * User: zacharydubois
 * Date: 2015-11-02 20:50
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class installer {

    private
        $config,
        $view;

    public function __construct() {
        $this->config = new dataStore(KOICONF);
        $this->view = new view('install', 'materialize', array(
            'host' => filter_input(INPUT_SERVER, 'HTTP_HOST'),
            'installDir' => KOIDIR,
            'config' => KOICONF,
        ));
    }

    public function run() {

    }

}