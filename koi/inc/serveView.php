<?php
/**
 * User: zacharydubois
 * Date: 2015-11-05 09:54
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

namespace Koi;


class serveView {
    function __construct($view, $theme, $payload) {
        \Twig_Autoloader::register();
    }
}