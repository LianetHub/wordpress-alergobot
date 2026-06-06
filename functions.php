<?php

/**
 * Alergobot theme functions
 *
 * @package alergobot
 */

define('ALERGOBOT_VERSION', '1.0.0');
define('ALERGOBOT_DIR', get_template_directory());
define('ALERGOBOT_URI', get_template_directory_uri());
define('ALERGOBOT_ASSETS_URI', ALERGOBOT_URI . '/assets');

$alergobot_inc = ALERGOBOT_DIR . '/inc/';

require_once $alergobot_inc . 'template-tags.php';
require_once $alergobot_inc . 'template-functions.php';
require_once $alergobot_inc . 'setup.php';
require_once $alergobot_inc . 'enqueue.php';
require_once $alergobot_inc . 'acf.php';
require_once $alergobot_inc . 'cpt.php';
require_once $alergobot_inc . 'ajax.php';
require_once $alergobot_inc . 'cf7.php';
