<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class MetaPlayer{
	// Attributes
	public $postmeta;

    /**
     * @since 1.0
     * @version 1.0
     */
    public function __construct(){

        // Main postmeta
      $this->postmeta = 'repeatable_fields';

        // Actions
      add_action('save_post', array($this,'save'));
      add_action('admin_init', array($this,'add_metabox'), 1);

        // Ajax Actions
      add_action('wp_ajax_player_ajax', array($this,'ajax'));
      add_action('wp_ajax_nopriv_player_ajax', array($this,'ajax'));
    }

    /**
     * @since 1.0
     * @version 1.0
     */
    public function languages(){
      return array(
        __('---------', 'mega') => null,
        __('Dublado', 'mega')   => 'dub',
        __('Legendado', 'mega') => 'leg',
      );
    }

    /**
     * @since 1.0
     * @version 1.0
     */
    public function type_player(){
      return array(
        __('---------', 'mega')   => null,
        __('Fembed', 'mega')      => 'fembed',
        __('DropBox', 'mega')     => 'dropbox',
        __('Very Stream', 'mega') => 'verystream',
        __('Openload', 'mega')    => 'openload',
        __('Thevid', 'mega')      => 'thevid',
        __('MP4', 'mega')         => 'mp4',
        __('Iframe', 'mega')      => 'iframe',
      );
    }
    /**
     * @since 1.0
     * @version 1.0
     */
    public function add_metabox(){
      add_meta_box('repeatable-fields', __('Video Player', 'mega'), array($this,'view_metabox'), 'movies', 'normal', 'default');
      add_meta_box('repeatable-fields', __('Video Player', 'mega'), array($this,'view_metabox'), 'episodes', 'normal', 'default');
    }

    /**
     * @since 1.0
     * @version 1.0
     */
    public function view_metabox(){
      global $post;
      $postmneta = get_post_meta($post->ID, $this->postmeta, true);
      wp_nonce_field('player_editor_nonce', 'player_editor_nonce');
      require get_parent_theme_file_path('/inc/parts/player_editor.php');
    }

    /**
     * @since 1.0
     * @version 1.0
     */
    public function save($post_id){
      if(!isset($_POST['player_editor_nonce']) || !wp_verify_nonce($_POST['player_editor_nonce'], 'player_editor_nonce')) return;
      if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
      if(!current_user_can('edit_post',$post_id)) return;

		// Meta data
      $antiguo = get_post_meta($post_id, $this->postmeta, true);
      $nuevo   = array();
      $options = $this->type_player();
      $names   = doo_isset($_POST,'name');
      $selects = doo_isset($_POST,'select');
      $idiomas = doo_isset($_POST,'idioma');
      $urls    = doo_isset($_POST,'url');
      $count   = count($urls);

		// Serialized data
      for($i = 0; $i < $count; $i++){
       if ($urls[$i] != ''):
        $nuevo[$i]['url'] = stripslashes(strip_tags($urls[$i]));
        if(in_array($selects[$i], $options)) $nuevo[$i]['select'] = $selects[$i];
        else $nuevo[$i]['select'] = '';
        if(in_array($idiomas[$i], $idiomas)) $nuevo[$i]['idioma'] = $idiomas[$i];
        else $nuevo[$i]['idioma'] = '';

      endif;
    }
    if(!empty($nuevo) && $nuevo != $antiguo) update_post_meta($post_id, $this->postmeta, $nuevo);
    elseif (empty($nuevo) && $antiguo) delete_post_meta($post_id, $this->postmeta, $antiguo);
  }
    /**
     * @since 1.0
     * @version 1.0
     */
    public function __destruct(){
      return false;
    }
  }

  new MetaPlayer;
