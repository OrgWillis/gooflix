<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*
*/

# Add admin css wp-login.php
if(!function_exists('admin_style')) {

	function admin_style() {

		wp_register_style('admin_css', URI .'/assets/css/admin.style.css', false, VERSION );
		wp_enqueue_style('admin_css', URI .'/assets/css/admin.style.css', false, VERSION );
		wp_enqueue_script('admin_upload', URI.'/assets/js/back-end/upload.js', array('jquery'), VERSION, false );
		wp_enqueue_script('admin_ajax', URI.'/assets/js/back-end/admin.ajax.js', array('jquery'), VERSION, false );
		wp_localize_script('admin_ajax', 'dooAj', array(
			# Importar
			'url'                => admin_url('admin-ajax.php', 'relative'),
			'rem_featu'	         => __('Remove','mega'),
			'add_featu'          => __('Add','mega'),
			'loading'	         => __('Loading...','mega'),
			'reloading'          => __('Reloading..','mega'),
			'exists'	         => __('Domain has already been registered','mega'),
			'updb'		         => __('Updating database..','mega'),
			'completed'          => __('Action completed','mega'),
			'nolink'             => __('The links field is empty','mega'),
			'deletelink'         => __('Do you really want to delete this item?','mega'),
			'confirmdbtool'      => __('Do you really want to delete this register, once completed this action will not recover the data again?','mega'),
			'confirmpublink'     => __('Do you want to publish the links before continuing?','mega'),
		) );
	}

	add_action('admin_enqueue_scripts','admin_style');
}

# Styles 
if(!function_exists('styles')) {
	function styles()  {

		wp_enqueue_style('style-complete', URI .'/assets/css/complete.css' , array(), VERSION );

		if (is_page('aplicativo')) {
			wp_enqueue_style('style-app', URI .'/assets/css/app.css' , array(), VERSION );
		}

		if (is_page('api')) {
			wp_enqueue_style('style-api', URI .'/assets/css/api.css' , array(), VERSION );
		}
	}
	add_action('wp_enqueue_scripts', 'styles');
}

# JavaScript 
if(!function_exists('scripts')){
	function scripts() {

		wp_enqueue_script('scripts-jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', array('jquery'), VERSION, false);
		wp_enqueue_script('scripts-script', URI .'/assets/js/front-end/script.js', array('jquery'), VERSION, false);
		
		wp_localize_script('scripts-script', 'json', array(
			'url'        => rest_url('api/'),
			'ajaxurl'    => admin_url('admin-ajax.php'),
			'status'     => is_true_string('slider'),
			'type'       => get_post_type(),
			'homeurl'    => esc_url(home_url()),
			'verystream' => cs_get_option('linkverystream','https://verystream.com/stream/'),
			'fembed'     => cs_get_option('linkfembed','https://www.fembed.com/f/'),
		) );
		
		if (is_home()) {
			wp_enqueue_script('scripts-home', URI .'/assets/js/front-end/home.js', array('jquery'), VERSION, true);
		}

		if (get_post_type(get_the_ID()) == 'movies') {

			wp_enqueue_script('scripts-movies', URI .'/assets/js/front-end/movie.js', array('jquery'), VERSION, false);
		}

		if (get_post_type(get_the_ID()) == 'tvshows') {

			wp_enqueue_script('scripts-tvshows', URI .'/assets/js/front-end/tvshows.js', array('jquery'), VERSION, false);
		}

	}

	add_action('wp_enqueue_scripts', 'scripts');
}

# Adiciona style ao wp_head
if(!function_exists('add_head_style')){
	function add_head_style($post_id) {

		if (is_single()){
			
			$postmeta = get_meta_assets(get_the_ID());
			$backdrop = doo_isset($postmeta, 'backdrop');

			$style = '';
			$style .= '<style type="text/css">';
			$style .= '#moviePage .background{background-image: url('.$backdrop.');}';
			$style .= '</style>';

			echo $style;
		}
	}

	add_action('wp_head', 'add_head_style');
}

# Adiciona script ao wp_footer
if(!function_exists('add_footer_script') && cs_get_option('ads_mode_user')){
	function add_footer_script($post_id) {

		if (is_single()){

			$posttype = get_meta_assets(get_the_ID());

			echo stripslashes(get_user_meta(doo_isset($postmeta, 'autor'), 'script_field', true)); 
		} 
	}

	add_action('wp_footer', 'add_footer_script');
}

function get_meta_assets($post_id){

	$posttype = get_post_type($post_id);

	switch($posttype) {

		case 'movies':
		$postmeta = postmeta_movies($post_id);
		break;

		case 'tvshows':
		$postmeta = postmeta_tvshows($post_id);
		break;
	}

	return $postmeta;
}

# Retorna o link direto de uma imagem do assets
if(!function_exists('assets_image')){
	function assets_image($image) {
		echo URI. '/assets/img/'. $image;	
	}
}

# Retorna o link direto de uma imagem do assets
if(!function_exists('return_assets_image')){
	function return_assets_image($image) {
		return URI. '/assets/img/'. $image;	
	}
}
