<?php
/**
 * User: zacharydubois
 * Date: 2015-11-25 23:59
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class auth {
    private
        $account,
        $sessionFile,
        $sessionData,
        $sessionNew,
        $ip;

    public function __construct() {
        $this->account = new account();
        $this->sessionFile = new dataStore(KOISESS);
        $this->sessionData = $this->sessionFile->read();
        $this->sessionNew = $this->sessionData;
        $this->ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);

        return true;
    }

    public function login($user, $pass) {
        if (is_string($user) && is_string($pass)) {
            if ($this->account->isUser($user) && utility::verifyPass($pass, $this->account->getPassHash($user))) {

            }

            return false;
        }

        throw new koiException("login sent incorrect param types.")
    }

    private function createSession($user) {
        if (is_string($user) && $this->account->isUser($user)) {
            $sessionID = utility::genSessionID();

            if ($this->createKoiSession($user, $sessionID) && $this->createPHPSession($user, $sessionID)) {
                return true;
            }

            throw new koiException("createSession Failed to create session.");
        }

        throw new koiException("createSession user does not exist.");
    }

    private function createKoiSession($user, $totp, $sessionID) {
        if (is_string($user) && $this->account->isUser($user)) {
            $lifetime = (time() + SessionLifetime);
            $session = array(
                'username' => $user,
                'ip'       => $this->ip,
                'totp'     => false,
                'time'     => array(
                    'created' => time(),
                    'expired' => $lifetime
                )
            );

            $this->sessionNew[$sessionID] = $session;

            setcookie('koSession', $sessionID, $lifetime, '/', KOIHOST);

            return true;
        }

        throw new koiException("createKoiSession user does not exist or sent wrong param type.");
    }

    private function createPHPSession($user, $sessionID) {
        if (is_string($user) && $this->account->isUser($user)) {
            session_start();
            $_SESSION['id'] = $sessionID;
            $_SESSION['ip'] = $this->ip;

            return true;
        }

        throw new koiException("createPHPSession user does not exist or sent wrong param type.");


    }

    public function logout() {

    }
}