<?php
/**
 * User: zacharydubois
 * Date: 2015-11-11 16:21
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class theme {
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

    public function getThemeInfo(string $theme) {
        if (!isset($theme) || !is_string($theme)) {
            throw new koiException("getThemeInfo() did not receive valid theme.");
        }

        if (!$this->isTheme($theme)) {
            throw new koiException($theme . "is not a theme.");
        }

        $data = new dataStore(KOITPL . '/' . $theme . 'theme.json');

        return $data;
    }

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
