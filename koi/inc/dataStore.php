<?php
/**
 * User: zacharydubois
 * Date: 2015-10-28 10:25
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


/**
 * Data storage functions for configs and other data.
 *
 * The dataStore format includes a meta section containing various information such as:
 * - Last write.
 * - Koi version during last write.
 *
 * Then a second section where the payload to be saved (data) is stored. When using the read function, just the payload is sent. Meta is not.
 *
 * Class dataStore
 * @package Koi
 */
class dataStore {
    private
        $path;

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
            $data = json_decode(file_get_contents($this->path), true);

            return $data['payload'];
        }

        throw new koiException('Cannot read ' . $this->path);
    }

    public function readMeta() {
        if ($this->canRead()) {
            $data = json_encode(file_get_contents($this->path), true);

            return $data['meta'];
        }

        return false;
    }

    private function setMeta() {
        $meta = array(
            'version'   => KOIVER,
            'lastWrite' => time()
        );

        return $meta;
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
            $data = array(
                'meta'    => $this->setMeta(),
                'payload' => $payload
            );

            if (file_put_contents($this->path, json_encode($data, JSON_PRETTY_PRINT))) {
                return true;
            } else {
                throw new koiException('Failed to write to ' . $this->path);
            }
        }

        return false;
    }
}