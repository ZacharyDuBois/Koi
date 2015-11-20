<?php
/**
 * User: zacharydubois
 * Date: 2015-11-11 17:41
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class validate {
    public static function username(string $username) {
        $pattern = '^[[:alnum:]]{3,25}$';
        return preg_match($pattern, $username);
    }

    public static function email(string $email) {
        return filter_var(FILTER_VALIDATE_EMAIL, $email);
    }

    public static function password(string $pass) {
        $valid = true;
        $req = array(
            '[A-Za-z]',
            '[0-9]',
            '\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\[|\]|\\|\/|\,|\.|\?|\'|\;|\:|\{|\}|\-|\_|\=|\+|\`|\~'
        );

        if (!(strlen(trim($pass)) >= 12) and !(strlen(trim($pass)) <= 100)) {
            $valid = false;
        }

        foreach ($req as $v) {
            if (preg_match($req, $v)) {
                $valid = false;
            }
        }

        return $valid;
    }
}