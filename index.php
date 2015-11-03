<?php
/**
 * User: zacharydubois
 * Date: 2015-10-28 09:58
 * Project: Koi
 * License: MIT, Zachary DuBois 2015 (See LICENSE.md)
 */

//////////////////////
//  Defines         //
//////////////////////

define('COMPOSER_PATH', __DIR__ . '/vendor');
define('KOIDIR', __DIR__ . '/koi');


//////////////////////
//  Startup         //
//////////////////////

require_once COMPOSER_PATH . '/autoload.php';
require_once KOIDIR . '/inc/app.php';
require_once KOIDIR . '/inc/koiException.php';

use Koi\app;
use Koi\koiException;

$koi = new app();


//////////////////////
//  Start           //
//////////////////////

try {

    $koi->start();

} catch (koiException $e) {

    echo $e->getMessage();

}
