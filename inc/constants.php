<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

define('URI', get_template_directory_uri());

define('DIR', get_template_directory());

define('VERSION', '1.0');

define('VERSION_DB', '2.0');

define('THEME', 'Mega');

define('TIME','M. d, Y');

define('THEME_NAME', get_bloginfo('name'));

define('LANG', get_bloginfo('language'));

define('URL', esc_url(home_url()));

// Translations
load_theme_textdomain('mega', DIR . '/lang/');

// Ativa o editor classico
add_filter('use_block_editor_for_post', '__return_false');