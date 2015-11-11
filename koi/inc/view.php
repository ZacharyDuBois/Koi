<?php
/**
 * User: zacharydubois
 * Date: 2015-11-05 09:54
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

class view {
    private
        $view,
        $theme,
        $payload,
        $mustache;

    public function __construct($view, $theme, $payload) {
        require_once KOIDIR . '/inc/theme.php';

        if (!is_string($view) || !is_string($theme) || !is_array($payload)) {
            throw new koiException("Wrong variable type for serveView.");
        }

        if (!file_exists(KOIDIR . '/templates/' . $theme)) {
            throw new koiException("Theme " . $theme . "does not exist in " . KOIDIR . "/templates/");
        }

        if (!file_exists(KOIDIR . '/templates/' . $theme . '/' . $view . '.html')) {
            throw new koiException("View " . $view . "not found in " . KOIDIR . "/templates/" . $theme);
        }

        $this->view = $view;
        $this->theme = $theme;
        $this->payload = $payload;
        $this->mustache = new \Mustache_Engine();
    }

    public function render() {

    }


}