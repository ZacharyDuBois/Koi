<?php
/**
 * User: zacharydubois
 * Date: 2015-11-05 09:54
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;

/**
 * View controller.
 *
 * Class view
 * @package Koi
 */
class view {
    private
        $view,
        $theme,
        $payload,
        $tpl,
        $mustache;

    /**
     * view constructor.
     *
     * @param string $view
     * @param string $theme
     * @param array $payload
     * @throws koiException
     */
    public function __construct(string $view, string $theme, array $payload) {
        require_once KOIDIR . '/inc/theme.php';
        $themeFunc = new theme();

        if (!is_string($view) || !is_string($theme) || !is_array($payload)) {
            throw new koiException("Wrong variable type for view.");
        }

        $themeInfo = $themeFunc->getThemeInfo($theme);

        $this->view = $view;
        $this->theme = $theme;
        $this->payload = $payload;
        $this->tpl = KOITPL . '/' . $theme . '/' . $view . $themeInfo['extension'];

        $this->mustache = new \Mustache_Engine(array(
            'loader'          => new \Mustache_Loader_FilesystemLoader(KOITPL . '/' . $theme),
            'partials_loader' => new \Mustache_Loader_FilesystemLoader(KOITPL . '/' . $theme . '/' . $themeInfo['partials'])
        ));

    }

    /**
     * Renders the mustache files.
     *
     * @return bool
     */
    public function render() {
        echo $this->mustache->render($this->tpl, $this->payload);

        return true;
    }
}