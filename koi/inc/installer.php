<?php
/**
 * User: zacharydubois
 * Date: 2015-11-02 20:50
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

/**
 * Koi installation controller.
 *
 * Class installer
 * @package Koi
 */
class installer {

    private
        $config;

    /**
     * installer constructor.
     */
    public function __construct() {
        $this->config = new dataStore(KOICONF);
    }

    public function run() {
        $uri = filter_input(INPUT_SERVER, 'PATH_INFO');

        switch ($uri) {
            case '/install/post':
                $work = $this->post();
                break;
            case '/install':
                $work = $this->form();
                break;
            default:
                $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
                header('Location: ' . $host . '/install');
                $work = false;
                break;
        }

        return $work;
    }

    /**
     * Creates the installation form.
     *
     * @return bool
     */
    private function form() {
        $view = new view('install', 'raw', array(
            'host' => filter_input(INPUT_SERVER, 'HTTP_HOST'),
            'installDir' => KOIDIR,
            'config' => KOICONF,
            'pageTitle' => "Install Koi",
        ));
        echo $view->render();

        return true;
    }

    /**
     * Validates the inbound post payload.
     */
    private function post() {
        $post = filter_input(INPUT_SERVER, 'POST');
    }

}