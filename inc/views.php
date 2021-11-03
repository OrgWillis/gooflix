<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*
*/

# Adiciona a visita do usuario ao contador
function set_post_views($postID,$name) {
    $url    = get_cookie($name);
    if (!$url) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 1;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, $count);
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}

function post_views($post_id) {
    if (!is_single())
        return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
        $title   = (string)$post->post_name;
    }
    set_post_views($post_id,$title);
}

add_action('wp_head', 'post_views');

function get_post_views($postID) {
    $count_key = 'post_views_count';
    $count     = get_post_meta($postID, $count_key, true);
    if (!empty($count)) {
        echo $count;
    }
}

#Save cookies
function add_cookie($key, $value, $time) {
    setcookie( $key, $value, $time + time(), COOKIEPATH, COOKIE_DOMAIN);
}

#Return add_cookies
function get_cookie($value) {
    if ($cookie = isset($_COOKIE[$value])) return $cookie;
}

# Adiciona o cookie de 24h de visita do usuario
function cookieVisited() {
    if (is_singular('movies') || is_singular('tvshows')){
        global $post;
        $title   = $post->post_name;
        $post_id = $post->ID;
        add_cookie("$title","$post_id",3600*24);
    }
}
add_action('template_redirect', 'cookieVisited');