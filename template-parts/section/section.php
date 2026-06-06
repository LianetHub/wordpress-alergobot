<?php
/**
 * Flexible content section (markup from inc/markup/home)
 *
 * @package alergobot
 */

$layout = get_row_layout();
$file   = str_replace('_', '-', $layout);
alergobot_render_home_section($file);
