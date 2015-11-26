<?php
/**
 * User: zacharydubois
 * Date: 2015-11-25 16:56
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

/**
 * Koi configuration manager.
 *
 * Class config
 * @package Koi
 */
class config {
    private
        $configFile,
        $configData,
        $configNew;

    public function __construct() {
        $this->configFile = new dataStore(KOICONF);
        $this->configData = $this->configFile->read();
        $this->configNew = $this->configData;

        return true;
    }

    public function getHost() {
        return $this->configData['host'];
    }

    public function setHost($host) {
        if (validate::host($host)) {
            $this->configNew['host'] = $host;

            return true;
        }

        return false;
    }

    public function getContentDir() {
        return $this->configData['contentDir'];
    }

    public function setContentDir($dir) {
        if (validate::dir($dir) && is_dir($dir)) {
            $this->configNew['contentDir'] = $dir;

            return true;
        }

        return false;
    }

    public function getTitle() {
        return $this->configData['title'];
    }

    public function setTitle($title) {
        if (validate::title($title)) {
            $this->configNew['title'] = $title;

            return true;
        }

        return false;
    }

    public function getDescription() {
        return $this->configData['description'];
    }

    public function setDescription($desc) {
        if (validate::description($desc)) {
            $this->configNew['description'] = $desc;

            return true;
        }

        return false;
    }

    public function getCDNDomain() {
        return $this->configData['domains']['cdn'];
    }

    public function setCDNDomain($domain) {
        if (validate::host($domain)) {
            $this->configNew['domains']['cdn'] = $domain;

            return true;
        }

        return false;
    }

    public function getPasteDomain() {
        return $this->configData['domains']['paste'];
    }

    public function setPasteDomain($domain) {
        if (validate::host($domain)) {
            $this->configNew['domains']['paste'] = $domain;

            return true;
        }

        return false;
    }

    public function getTempDomain() {
        return $this->configData['domains']['temp'];
    }

    public function setTempDomain($domain) {
        if (validate::host($domain)) {
            $this->configNew['domains']['temp'] = $domain;

            return true;
        }

        return false;
    }

    public function getIndexDomain() {
        return $this->configData['domains']['index'];
    }

    public function setIndexDomain($domain) {
        if (validate::host($domain)) {
            $this->configNew['domains']['index'] = $domain;

            return true;
        }

        return false;
    }

    public function save() {
        if ($this->configFile->write($this->configNew)) {
            return true;
        }

        return false;
    }
}