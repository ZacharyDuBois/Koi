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
        }

        return false;
    }
}