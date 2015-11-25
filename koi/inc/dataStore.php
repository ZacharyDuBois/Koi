<?php
/**
 * User: zacharydubois
 * Date: 2015-10-28 10:25
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


/**
 * Data storage functions for configs and other data
 *
 * Class dataStore
 * @package Koi
 */
class dataStore {
    private $path;

    /**
     * dataStore constructor.
     * @param string $path
     * @throws koiException
     */
    public function __construct($path) {
        $this->path = $path;

        if (!file_exists($this->path) && !$this->canWrite()) {
            throw new koiException("Could not create " . $path . " for writing.");
        }
    }

    /**
     * File write check.
     *
     * @return bool
     */
    private function canWrite() {
        if (is_writeable(dirname($this->path))) {
            if (is_writeable($this->path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * File read check.
     *
     * @return bool
     */
    private function canRead() {
        if (is_readable(dirname($this->path))) {
            if (is_readable($this->path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Reads dataStore file.
     *
     * @return array
     * @throws koiException
     */
    public function read() {
        if ($this->canRead()) {
            return json_decode(file_get_contents($this->path), true);
        }

        throw new koiException('Cannot read ' . $this->path);
    }

    /**
     * Writes dataStore file.
     *
     * @param array $payload
     * @return bool
     * @throws koiException
     */
    public function write(array $payload) {
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