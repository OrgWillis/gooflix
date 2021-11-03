<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

function search_join($join) {
	global $wpdb;

	if (!is_admin() && isset($GLOBALS['wp']->query_vars['s'])) {    
		$join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	}

	return $join;
}
//add_filter('posts_join', 'search_join');

function search_where($where) {
	global $pagenow, $wpdb;
	if (!is_admin() && isset($GLOBALS['wp']->query_vars['s'])) {
		$where = preg_replace(
			"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
	}
	return $where;
}

//add_filter('posts_where', 'search_where');

function search_distinct($where) {
	global $wpdb;
	if (!is_admin() && isset($GLOBALS['wp']->query_vars['s'])) {
		return "DISTINCT";
	}
	return $where;
}
//add_filter('posts_distinct', 'search_distinct');
