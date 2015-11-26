<?php
/**
 * User: zacharydubois
 * Date: 2015-11-24 23:11
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

use OTPHP\TOTP;

/**
 * Account manager.
 *
 * Class account
 * @package Koi
 */
class account {
    private
        $userFile,
        $userData,
        $userNew;

    public function __construct() {
        $this->userFile = new dataStore(KOIUSERS);
        $this->userData = $this->userFile->read();
        $this->userNew = $this->userData;

        return true;
    }

    public function getUsersList() {
        $users = array();

        foreach ($users as $k => $v) {
            $users[] = $k;
        };

        return $users;
    }

    public function isUser($user) {
        if (in_array($user, $this->getUsersList())) {
            return true;
        }

        return false;
    }

    public function getUserInfo($user) {
        if ($this->isUser($user)) {
            return $this->userData[$user];
        }

        throw new koiException("Cannot getUserInfo on non-existing user.");
    }

    public function isAdmin($user) {
        return $this->getUserInfo($user)['admin'];
    }

    public function setAdminStatus($user, $admin, $new = false) {
        if (is_string($user) && is_bool($admin) && ($this->isUser($user) || $new === true)) {
            $this->userNew[$user]['admin'] = $admin;

            return true;
        }

        throw new koiException("setAdminStatus user doesn't exist or params are wrong type.");
    }

    public function getName($user) {
        return $this->getUserInfo($user)['name'];
    }

    public function setName($user, $name, $new = false) {
        if (is_string($user) && is_string($name) && ($this->isUser($user) || $new === true)) {
            if (validate::name($name)) {
                $this->userNew[$user]['name'] = $name;

                return true;
            }

            return false;
        }

        throw new koiException("setName user doesn't exist or params are wrong type.");
    }

    public function getEmail($user) {
        return $this->getUserInfo($user)['email'];
    }

    public function setEmail($user, $email, $new = false) {
        if (is_string($user) && is_string($email) && ($this->isUser($user) || $new === true)) {
            if (validate::email($email)) {
                $this->userNew[$user]['email'] = $email;

                return true;
            }

            return false;
        }

        throw new koiException("setEmail user doesn't exist or params are wrong type.");
    }

    public function getPassHash($user) {
        return $this->getUserInfo($user)['password'];
    }

    public function setPass($user, $pass, $new = false) {
        if (is_string($user) && is_string($pass) && ($this->isUser($user) || $new === true)) {
            if (validate::password($pass)) {
                $this->userNew[$user]['password'] = utility::hashPass($pass);

                return true;
            }

            return false;
        }

        throw new koiException("setPass user doesn't exist or params are wrong type.");
    }

    public function changePass($user, $old, $new) {
        if (is_string($user) && is_string($old) && is_string($new) && $this->isUser($user)) {
            if (utility::verifyPass($old, $this->getPassHash($user)) && validate::password($new)) {
                $this->setPass($user, $new);

                return true;
            }

            return false;
        }

        throw new koiException("changePass user doesn't exist or params are wrong type.");
    }

    public function getTOTP($user) {
        return $this->getUserInfo($user)['totp'];
    }


    public function setTOTPSecret($user, $turnOff = false) {
        if ($this->isUser($user)) {
            if ($turnOff === false) {
                $this->userNew[$user]['totp'] = utility::genTOTPSecret();

                return true;
            }

            $this->userNew[$user]['totp'] = false;

            return true;
        }

        throw new koiException("getTOTPSecret user does not exist.");
    }

    private function getTOTPObject($user) {
        if (is_string($user) && $this->isUser($user)) {
            if ($this->getTOTP($user) !== false) {
                $totp = new TOTP();
                $totp->setLabel($user)
                    ->setDigest(6)
                    ->setDigest('sha1')
                    ->setInterval(30)
                    ->setSecret($this->getTOTP($user));

                return $totp;
            }

            return false;
        }

        throw new koiException("getTOTPObject user does not exist or wrong param type.");
    }

    public function getTOTPQRCode($user) {
        if (is_string($user) && $this->isUser($user)) {
            if ($this->getTOTP($user) !== false) {

                $totp = $this->getTOTPObject($user);
                $uri = $totp->getProvisioningUri();
                $qr = "http://chart.apis.google.com/chart?cht=qr&chs=250x250&chl=" . urlencode($uri);

                return $qr;
            }

            return false;
        }

        throw new koiException("getTOTPQRCode user does not exist or wrong param type.");
    }

    public function getTOTPCurrent($user) {
        if (is_string($user) && $this->isUser($user)) {
            if ($this->getTOTP($user) !== false) {
                $totp = $this->getTOTPObject($user);

                return $totp->now();
            }

            return false;
        }

        throw new koiException("getTOTPCurrent user does not exist or wrong param type.");
    }

    public function verifyTOTP($user, $code) {
        if (is_string($user) && is_int($code) && $this->isUser($user)) {
            if ($this->getTOTP($user) !== false) {
                $totp = $this->getTOTPObject($user);

                return $totp->verify($code);
            }

            return false;
        }

        throw new koiException("verifyTOTP user does not exist or wrong param types.");
    }

    public function create($user, $name, $email, $pass, $admin) {
        if (is_string($user) && is_string($name) && is_string($email) && is_string($pass) && is_bool($admin)) {
            if (validate::username($user)) {
                $this->userNew[$user] = array();

                $this->setName($user, $name, true);
                $this->setEmail($user, $email, true);
                $this->setPass($user, $pass, true);
                $this->setAdminStatus($user, $admin, true);

                return true;
            }

            return false;
        }

        throw new koiException("create received wrong param type.");
    }

    public function delete($user) {
        if (is_string($user) && $this->isUser($user)) {
            unset ($this->userNew[$user]);

            return true;
        }

        throw new koiException("delete user doesn't exist or wrong param type.");
    }

    public function save() {
        if ($this->userFile->write($this->userNew)) {
            return true;
        }

        return false;
    }
}