<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/


class DDbmoviesPosTypes extends DDbmoviesHelpers{


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
    	add_action('init', array(&$this,'movies'), 0);
    	add_action('init', array(&$this,'tvshows'), 0);
    	add_action('init', array(&$this,'seasons'), 0);
    	add_action('init', array(&$this,'episodes'), 0);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function movies(){

    	$labels = array(
    		'name'           => __('Movies','mega'),
    		'singular_name'  => __('Movie','mega'),
    		'menu_name'      => __('Movies','mega'),
    		'name_admin_bar' => __('Movies','mega'),
    		'all_items'      => __('Movies','mega')
    	);

    	$rewrite = array(
    		'slug'       => get_option('movies_slug', 'movies'),
    		'with_front' => true,
    		'pages'      => true,
    		'feeds'      => true
    	);

    	$type_args = array(
    		'labels'              => $labels,
    		'rewrite'             => $rewrite,
    		'label'               => __('Movies','mega'),
    		'description'         => __('Movies manage','mega'),
    		'supports'            => array('title', 'editor','author'),
    		'taxonomies'          => array('category'),
    		'hierarchical'        => false,
    		'public'              => true,
    		'show_ui'             => true,
    		'show_in_menu'        => true,
    		'show_in_rest'        => false,
    		'menu_position'       => 5,
    		'menu_icon'           => 'dashicons-editor-video',
    		'show_in_admin_bar'   => true,
    		'show_in_nav_menus'   => false,
    		'can_export'          => true,
    		'has_archive'         => true,
    		'exclude_from_search' => false,
    		'publicly_queryable'  => true,
    		'capability_type'     => 'post'
    	);
    	register_post_type('movies', $type_args);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function tvshows(){

    	$labels = array(
    		'name'           => __('TV Shows','mega'),
    		'singular_name'  => __('TV Shows','mega'),
    		'menu_name'      => __('TV Shows','mega'),
    		'name_admin_bar' => __('TV Shows','mega'),
    		'all_items'      => __('TV Shows','mega')
    	);

    	$rewrite = array(
    		'slug'       => get_option('tvshows_slug','tvshows'),
    		'with_front' => true,
    		'pages'      => true,
    		'feeds'      => true
    	);

    	$type_args = array(
    		'labels'              => $labels,
    		'rewrite'             => $rewrite,
    		'label'               => __('TV Show','mega'),
    		'description'         => __('TV series manage','mega'),
    		'supports'            => array('title', 'editor','author'),
    		'taxonomies'          => array('category'),
    		'hierarchical'        => false,
    		'public'              => true,
    		'show_ui'             => true,
    		'show_in_rest'        => false,
    		'show_in_menu'        => true,
    		'menu_position'       => 5,
    		'menu_icon'           => 'dashicons-welcome-view-site',
    		'show_in_admin_bar'   => true,
    		'show_in_nav_menus'   => false,
    		'can_export'          => true,
    		'has_archive'         => true,
    		'exclude_from_search' => false,
    		'publicly_queryable'  => true,
    		'capability_type'     => 'post'
    	);
    	register_post_type('tvshows', $type_args);
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function seasons(){

    	$labels = array(
    		'name'           => __('Seasons','mega'),
    		'singular_name'  => __('Seasons','mega'),
    		'menu_name'      => __('Seasons','mega'),
    		'name_admin_bar' => __('Seasons','mega'),
    		'all_items'      => __('Seasons','mega')
    	);

    	$type_args = array(
    		'labels'              => $labels,
    		'rewrite'             => false,
    		'label'               => __('Seasons','mega'),
    		'description'         => __('Seasons manage','mega'),
    		'supports'            => array('title'),
    		'taxonomies'          => array(),
    		'hierarchical'        => false,
    		'public'              => false,
    		'show_ui'             => true,
    		'show_in_rest'        => false,
    		'show_in_menu'        => true,
    		'menu_position'       => 5,
    		'show_in_menu'        => 'edit.php?post_type=tvshows',
    		'menu_position'       => 20,
    		'show_in_nav_menus'   => false,
    		'can_export'          => true,
    		'has_archive'         => false,
    		'exclude_from_search' => true,
    		'publicly_queryable'  => false,
    		'capability_type'     => 'post',
    	);
    	register_post_type('seasons', $type_args);
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function episodes(){

    	$labels = array(
    		'name'           => __('Episodes','mega'),
    		'singular_name'  => __('Episodes','mega'),
    		'menu_name'      => __('Episodes','mega'),
    		'name_admin_bar' => __('Episodes','mega'),
    		'all_items'      => __('Episodes','mega')
    	);

    	$type_args = array(
    		'labels'              => $labels,
    		'rewrite'             => false,
    		'label'               => __('Episodes','mega'),
    		'description'         => __('Episodes manage','mega'),
    		'supports'            => array('title'),
    		'taxonomies'          => array(),
    		'hierarchical'        => false,
    		'public'              => true,
    		'show_ui'             => true,
    		'show_in_rest'        => false,
    		'show_in_menu'        => true,
    		'menu_position'       => 5,
    		'show_in_menu'        => 'edit.php?post_type=tvshows',
    		'menu_position'       => 20,
    		'show_in_nav_menus'   => false,
    		'can_export'          => true,
    		'has_archive'         => false,
    		'exclude_from_search' => true,
    		'publicly_queryable'  => false,
    		'capability_type'     => 'post',
    	);
    	register_post_type('episodes', $type_args);
    }
}

new DDbmoviesPosTypes;
