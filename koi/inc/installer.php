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
        $config;

    public function __construct() {
        $this->config = new dataStore(KOICONF);
    }

    public function form() {
        $view = new view('install', 'raw', array(
            'host' => filter_input(INPUT_SERVER, 'HTTP_HOST'),
            'installDir' => KOIDIR,
            'config' => KOICONF,
            'pageTitle' => "Install Koi",
        ));
        echo $view->render();

        return true;
    }

    public function post() {
        $post = filter_input(INPUT_SERVER, 'POST');
        
    }

}