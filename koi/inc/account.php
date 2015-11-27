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
        if (is_string($user)) {
            if (in_array($user, $this->getUsersList())) {
                return true;
            }

            return false;
        }

        throw new koiException("isUser user is not of string type.");
    }

    public function getMeta($user, $meta = null) {
        if ($this->isUser($user)) {
            if ($meta === null) {
                return $this->userData[$user];
            }

            if ($meta !== null && isset($this->userData[$user][$meta])) {
                return $this->userData[$user][$meta];
            }

            return false;
        }

        throw new koiException("Cannot getUserInfo on non-existing user.");
    }

    public function setMeta($user, $meta, $value, $new = false) {
        if (is_string($meta) && ($this->isUser($user) || $new === true)) {
            if ($meta === 'email' && is_string($value)) {
                if (validate::email($value)) {
                    $this->userNew[$user]['email'] = $value;

                    return true;
                }

                return false;
            }

            if ($meta === 'name' && is_string($value)) {
                if (validate::name($value)) {
                    $this->userNew[$user]['name'] = $value;

                    return true;
                }

                return false;
            }

            if ($meta === 'admin' && is_bool($value)) {
                $this->userNew[$user]['admin'] = $value;

                return true;
            }

            if ($meta === 'password' && is_string($value)) {
                if (validate::password($value)) {
                    $this->userNew[$user]['password'] = utility::hashPass($value);

                    return true;
                }

                return false;
            }

            if ($meta === 'totp' && is_bool($value)) {
                if ($value === true) {
                    $this->userNew[$user]['totp'] = utility::genTOTPSecret();

                    return true;
                } elseif ($value === false) {
                    $this->userNew[$user]['totp'] = false;

                    return true;
                }

                return false;
            }
        }

        throw new koiException("setMeta user doesn't exist, meta doesn't exist or params are wrong type.");
    }

    public function changePass($user, $old, $new) {
        if (is_string($old) && is_string($new) && $this->isUser($user)) {
            if (utility::verifyPass($old, $this->getMeta($user, 'password'))) {
                $this->setMeta($user, 'password', $new);

                return true;
            }

            return false;
        }

        throw new koiException("changePass user doesn't exist or params are wrong type.");
    }

    private function getTOTPObject($user) {
        if (is_string($user) && $this->isUser($user)) {
            if ($this->getMeta($user, 'totp') !== false) {
                $totp = new TOTP();
                $totp->setLabel($user)
                    ->setDigest(6)
                    ->setDigest('sha1')
                    ->setInterval(30)
                    ->setSecret($this->getMeta($user, 'totp'));

                return $totp;
            }

            return false;
        }

        throw new koiException("getTOTPObject user does not exist or wrong param type.");
    }

    public function getTOTPQRCode($user) {
        if ($this->isUser($user)) {
            if ($this->getMeta($user, 'totp') !== false) {

                $totp = $this->getTOTPObject($user);
                $uri = $totp->getProvisioningUri();
                $qrCode = 'http://chart.apis.google.com/chart?cht=qr&chs=250x250&chl=' . urlencode($uri);

                return $qrCode;
            }

            return false;
        }

        throw new koiException("getTOTPQRCode user does not exist or wrong param type.");
    }

    public function getTOTPCurrent($user) {
        if ($this->isUser($user)) {
            if ($this->getMeta($user, 'totp') !== false) {
                $totp = $this->getTOTPObject($user);

                return $totp->now();
            }

            return false;
        }

        throw new koiException("getTOTPCurrent user does not exist or wrong param type.");
    }

    public function verifyTOTP($user, $code) {
        if (is_int($code) && $this->isUser($user)) {
            if ($this->getMeta($user, 'totp') !== false) {
                $totp = $this->getTOTPObject($user);

                return $totp->verify($code);
            }

            return false;
        }

        throw new koiException("verifyTOTP user does not exist or wrong param types.");
    }

    public function create($user, array $params) {
        if (is_string($user) && is_array($params)) {
            if (validate::username($user)) {
                $this->userNew[$user] = array();

                $this->setMeta($user, 'name', $params['name'], true);
                $this->setMeta($user, 'email', $params['email'], true);
                $this->setMeta($user, 'admin', $params['admin'], true);
                $this->setMeta($user, 'password', $params['password'], true);

                return true;
            }

            return false;
        }

        throw new koiException("create received wrong param type.");
    }

    public function delete($user) {
        if ($this->isUser($user)) {
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