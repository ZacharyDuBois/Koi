<?php
/**
 * User: zacharydubois
 * Date: 2015-11-11 17:41
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

/**
 * Input validation
 *
 * Class validate
 * @package Koi
 */
class validate {
    /**
     * Username validation.
     *
     * @param string $username
     * @return int
     */
    public static function username($username) {
        $pattern = '/^[[:alnum:]]{3,25}$/';

        return preg_match($pattern, $username);
    }

    /**
     * Email validation.
     *
     * @param string $email
     * @return mixed
     */
    public static function email($email) {
        return filter_var(FILTER_VALIDATE_EMAIL, $email);
    }

    /**
     * Password validation.
     *
     * @param string $pass
     * @return bool
     */
    public static function password($pass) {
        $pass = trim($pass);
        $pattern = '/[A-Za-z0-9~!@#$%^&*()_+`={}|:";\'<>?,.\-\[\]\\\/]{12,100}$/';

        return preg_match($pattern, $pass);
    }

    /**
     * Host validation.
     *
     * @param string $host
     * @return bool
     */
    public static function host($host) {
        $pattern = '/^[A-Za-z0-9.\-_]+$/';

        return preg_match($pattern, $host);
    }

    /**
     * Directory validation.
     *
     * @param string $dir
     * @return bool
     */
    public static function dir($dir) {
        $pattern = '/^[A-Za-z0-9\/]+\/$/';

        return preg_match($pattern, $dir);
    }

    public static function title($title) {
        $pattern = '/^.{1,25}$/';

        return preg_match($pattern, $title);
    }

    public static function description($desc) {
        $pattern = '/^.+$/';

        return preg_match($pattern, $desc);
    }

    public static function name($name) {
        $pattern = '/^.{1,25}$/';

        return preg_match($pattern, $name);
    }
}