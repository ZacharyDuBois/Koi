<?php
/**
 * User: zacharydubois
 * Date: 2015-11-24 23:11
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

/**
 * Account manager.
 *
 * Class account
 * @package Koi
 */
class account {
    public static function hashPassword($pass) {
        return password_hash($pass, PASSWORD_BCRYPT, array('cost' => 25));
    }
}