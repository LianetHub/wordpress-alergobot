<?php
/**
 * Flexible content section
 *
 * @package alergobot
 */

$file = str_replace('_', '-', get_row_layout());
get_template_part('template-parts/home/' . $file);
