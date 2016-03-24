<?php
/**
 * User: zacharydubois
 * Date: 2015-11-02 20:50
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;
/**
 * TODO: Fix the crap out of this. Build the app, then the installer.
 */

/**
 * Koi installation controller.
 *
 * Class installer
 * @package Koi
 */
class installer {

    /**
     * Runs the installer.
     *
     * @return bool
     */
    public function run() {
        $uri = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH);

        switch ($uri) {
            case '/install/post':
                $work = $this->post();
                // If post didn't validate, send to error.
                if (is_array($work)) {
                    $this->returnErr($work);
                } else {
                    $this->save();
                }
                break;
            case '/install':
                $work = $this->form();
                break;
            default:
                $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
                header('Location: http://' . $host . '/install');
                $work = false;
                break;
        }

        if (is_array($work)) {
            $work = false;
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
        require_once __DIR__ . '/validate.php';

        $post = filter_input_array(INPUT_POST);

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
            if (!$check) {
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

    private function save() {
        $post = filter_input(INPUT_SERVER, 'POST');

        // Write config.
        $configFile = new dataStore(KOICONF);
        $config = array(
            'title'       => 'Koi',
            'host'        => $post['host'],
            'contentDir'  => $post['contentDir'],
            'description' => 'A new Koi installation.'
        );

        if (!$configFile->write($config)) {
            throw new koiException("Failed to create config.json");
        }

        // Setup content dirs.
        $dirs = array(
            'tempFile',
            'tempFileMeta',
            'file',
            'fileMeta',
            'configs'
        );

        foreach ($dirs as $dir) {
            if (!mkdir($post['contentDir'] . '/' . $dir)) {
                throw new koiException("Failed to make dir " . $dir . " in " . $post['contentDir']);
            }
        }

        // Create user
        require_once __DIR__ . '/account.php';
        $userFileLocation = $post['contentDir'] . '/configs/users.json';
        $userFile = new dataStore($userFileLocation);
        $user = array(
            $post['username'] => array(
                'name'     => 'Koi User',
                'password' => account::hashPassword($post['password']),
                'email'    => $post['email'],
                'admin'    => true
            )
        );

        if (!$userFile->write($user)) {
            throw new koiException("Failed to write user.json");
        }

    }
}
