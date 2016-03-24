<?php
/**
 * User: zacharydubois
 * Date: 2015-11-25 20:08
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


use Base32\Base32;

class utility {
    public static function hashPass($pass) {
        return password_hash($pass, PASSWORD_BCRYPT, array('cost' => 25));
    }

    public static function verifyPass($pass, $hash) {
        if (is_string($pass) && is_string($hash)) {
            return password_verify($pass, $hash);
        }

        throw new koiException("verifyPass params are wrong type.");
    }

    public static function genTOTPSecret() {
        $allowed = array_merge(range('A', 'Z'), range(2, 7));
        $secret = '';

        for ($x = 0; $x < 16; $x++) {
            $secret .= $allowed[rand(0, 31)];
        }

        return Base32::encode($secret);
    }

    public static function genSessionID() {
        $let = range('A', 'Z');
        $sessionIDRaw = '';

        for ($x = 0; $x < 10; $x++) {
            $sessionIDRaw .= $let[rand(0, 26)];
        };

        $sessionID = sha1($sessionIDRaw . time());

        return $sessionID;
    }
}