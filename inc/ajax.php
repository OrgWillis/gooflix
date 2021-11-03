<?php 
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*
*/

# Retorna os madais
function getModal(){

	$what   = (isset($_GET['what'])) ? $_GET['what'] : null;

	switch ($what) {
		case 'youtube':
			get_template_part('inc/modal/youtube');
		break;
		case 'iframe':
			get_template_part('inc/modal/iframe');
		break;
		case 'modal':
			get_template_part('inc/modal/modal');
		break;
	}

	wp_die();
}

add_action('wp_ajax_modal', 'getModal');
add_action('wp_ajax_nopriv_modal', 'getModal');