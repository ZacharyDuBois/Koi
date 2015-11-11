<?php
/**
 * User: zacharydubois
 * Date: 2015-10-28 10:25
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class dataStore {
    private $path;

    public function __construct($path) {
        $this->path = $path;

        if (!file_exists($this->path) && !$this->canWrite()) {
            return false;
        }

        return true;
    }

    private function canWrite() {
        if (is_writeable(dirname($this->path))) {
            if (is_writeable($this->path)) {
                return true;
            }
        }

        return false;
    }

    private function canRead() {
        if (is_readable(dirname($this->path))) {
            if (is_readable($this->path)) {
                return true;
            }
        }

        return false;
    }

    public function read() {
        if ($this->canRead()) {
            return json_decode(file_get_contents($this->path), true);
        }

        throw new koiException('Cannot read ' . $this->path);
    }

    public function write($payload) {
        if ($this->canRead() && $this->canWrite()) {
            if (file_put_contents($this->path, json_encode($payload, JSON_PRETTY_PRINT))) {
                return true;
            } else {
                throw new koiException('Failed to write to ' . $this->path);
            }
        }

        return false;
    }
}