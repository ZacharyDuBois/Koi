<?php
/**
 * User: zacharydubois
 * Date: 2015-11-11 17:41
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class validate {
    public static function username($username) {
        $patern = '^[[:alnum:]]{3,25}$';
        if (preg_match($patern, $username)) {
            return true;
        }

        return false;
    }
}