<?php 
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

# Add Post featured
if(!function_exists('add_featured')){
	function add_featured(){
		$postid	 = doo_isset($_REQUEST,'postid');
		$nonce	 = doo_isset($_REQUEST,'nonce');
		$newdate = date("Y-m-d H:i:s");
		if($postid AND wp_verify_nonce( $nonce,'featured-'.$postid)) {
			update_post_meta($postid, 'featured_post','1');
			$post = array(
				'ID'                => $postid,
				'post_modified'     => $newdate,
				'post_modified_gmt' => $newdate
			);
			wp_update_post($post);
		}
		die();
	}
	add_action('wp_ajax_add_featured', 'add_featured');
	add_action('wp_ajax_nopriv_add_featured', 'add_featured');
}

# Delete Post featured
if(!function_exists('remove_featured')){
	function remove_featured(){
		$postid	= doo_isset($_REQUEST,'postid');
		$nonce	= doo_isset($_REQUEST,'nonce');
		if($postid AND wp_verify_nonce($nonce, 'featured-'.$postid)) {
			delete_post_meta( $postid, 'featured_post');
		}
		die();
	}
	add_action('wp_ajax_remove_featured', 'remove_featured');
	add_action('wp_ajax_nopriv_remove_featured', 'remove_featured');
}