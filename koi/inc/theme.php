<?php
/**
 * User: zacharydubois
 * Date: 2015-11-11 16:21
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

/**
 * Theme controller.
 *
 * Class theme
 * @package Koi
 */
class theme {
    /**
     * Lists all the themes that are available and valid.
     *
     * @return array
     * @throws koiException
     */
    public function listThemes() {
        $itemList = scandir(KOITPL, array('..', '.'));
        $themes = array();
        foreach ($itemList as $item) {
            if (is_dir(KOITPL . '/' . $item)) {
                if ($this->isTheme($item)) {
                    $themes[] = $this->getThemeInfo($item);
                }
            }
        }

        return $themes;
    }

    /**
     * Gets information on a specific theme.
     *
     * @param string $theme
     * @return array
     * @throws koiException
     */
    public function getThemeInfo(string $theme) {
        if (!isset($theme) || !is_string($theme)) {
            throw new koiException("getThemeInfo() did not receive valid theme.");
        }

        if (!$this->isTheme($theme)) {
            throw new koiException($theme . "is not a theme.");
        }

        $dataStore = new dataStore(KOITPL . '/' . $theme . 'theme.json');

        $data = $dataStore->read();

        return $data;
    }

    /**
     * Checks if something is a valid theme.
     *
     * @param string $theme
     * @return bool
     * @throws koiException
     */
    public function isTheme(string $theme) {
        if (!isset($theme) || !is_string($theme)) {
            throw new koiException('isTheme() did not receive valid theme.');
        }

        if (file_exists(KOITPL . '/' . $theme) && file_exists(KOITPL . '/' . $theme . '/theme.json')) {
            return true;
        }

        return false;
    }
}
