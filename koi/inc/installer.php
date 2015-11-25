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
                // If post didn't validate, send to error.
                if (is_array($work)) {
                    $this->returnErr($work);
                }
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
        $errors = filter_input_array(INPUT_GET);
        $view = new view('install', 'raw', array(
            'host'       => filter_input(INPUT_SERVER, 'HTTP_HOST'),
            'installDir' => KOIDIR,
            'config'     => KOICONF,
            'pageTitle'  => "Install Koi",
            'errors'     => $errors
        ));

        $view->render();

        return true;
    }

    /**
     * Take inbound post and validate it.
     *
     * @return array|bool
     */
    private function post() {
        $post = filter_input(INPUT_SERVER, 'POST');

        $err = array();

        // Check each post item.
        foreach ($post as $k => $v) {
            switch ($k) {
                case 'host':
                    $check = validate::host($v);
                    break;
                case 'contentDir':
                    $check = validate::dir($v);
                    break;
                case 'username':
                    $check = validate::username($v);
                    break;
                case 'email':
                    $check = validate::email($v);
                    break;
                case 'password':
                    $check = validate::password($v);
                    break;
                default:
                    $check = false;
                    break;
            }

            // If it doesn't validate, add to the error array.
            if ($check) {
                $err[$k] = false;
            }
        }

        // If $err isn't empty, something didn't validate. Return errors.
        if (!empty($err)) {
            return $err;
        }

        return true;
    }

    /**
     * Redirects to install page w/ errors.
     *
     * @param array $errors
     * @return bool
     */
    private function returnErr(array $errors) {
        $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $query = http_build_query($errors);
        header('Location: ' . $host . '/install?' . $query);

        return true;
    }

}
