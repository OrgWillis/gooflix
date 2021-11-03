<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class DDbmoviesAjax extends DDbmoviesHelpers{


    /**
     * @since 1.0
     * @version 1.0
     */
    public function __construct(){
        add_action('wp_ajax_dbmovies_genereditor', array(&$this,'genereditor'));
        add_action('wp_ajax_dbmovies_updatedimdb', array(&$this,'updatedimdb'));
        add_action('wp_ajax_dbmovies_savesetting', array(&$this,'savesettings'));
        add_action('wp_ajax_dbmovies_insert_tmdb', array(&$this,'tmdbinsert'));
        add_action('wp_ajax_dbmovies_generate_se', array(&$this,'tmdbseasons'));
        add_action('wp_ajax_dbmovies_generate_ep', array(&$this,'tmdbepisodes'));
        add_action('wp_ajax_dbmovies_generate_te', array(&$this,'tmdbseasepis'));
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function tmdbseasepis(){
        if(!empty($_POST)){
            $type = $this->Disset($_POST,'type');
            $tmdb = $this->Disset($_POST,'tmdb');
            $name = $this->Disset($_POST,'name');
            $seas = $this->Disset($_POST,'seas');
            $item = $this->Disset($_POST,'item');
            $totl = $this->Disset($_POST,'totl');
            $post = $this->Disset($_POST,'pare');
            $meta = get_post_meta( $post,'clgnrt',true);
            if(!$meta){
                update_post_meta($post, 'clgnrt', '1');
            }
            switch($type){
                case 'seasons':
                new DDbmoviesImporters('seasons', array('id' => $tmdb, 'se' => $item, 'nm' => $name, 'ed' => false));
                break;

                case 'episodes':
                new DDbmoviesImporters('episodes', array('id' => $tmdb, 'se' => $seas, 'ep' => $item, 'nm' => $name, 'ed' => false));
                break;
            }
        }
        wp_die();
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function genereditor(){
        $type = $this->Disset($_POST,'typept');
        $post = $this->Disset($_POST,'idpost');
        $tmdb = $this->Disset($_POST,'tmdbid');
        $seas = $this->Disset($_POST,'season');
        $epis = $this->Disset($_POST,'episde');
        $name = $this->Disset($_POST,'tvname');
        switch($type){
            case 'movies':
            case 'tvshows':
                new DDbmoviesImporters($type, array('id' => $tmdb, 'ed' => $post));
                break;

            case 'seasons':
                new DDbmoviesImporters('seasons', array('id' => $tmdb, 'se' => $seas, 'nm' => $name, 'ed' => $post));
                break;

            case 'episodes':
                new DDbmoviesImporters('episodes', array('id' => $tmdb, 'se' => $seas, 'ep' => $epis, 'nm' => $name, 'ed' => $post));
                break;

            default:
                echo $this->ResponseJson(array('response' => false,'message' => __('Complete required data')));
                break;
        }
        wp_die();
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function updatedimdb(){
        // POST Data
        $post = $this->Disset($_POST,'id');
        $imdb = $this->Disset($_POST,'imdb');
        if($post && $imdb){
            // Api Rest
            $rest = self::UpdateIMDb($imdb,$post);
            // HTML
            if($this->Disset($rest,'imdb')){
                echo '<strong>'.$this->Disset($rest,'rating').'</strong> '.doo_format_number($this->Disset($rest,'votes')).' '. __('votes');
            } else {
                echo $this->Disset($rest,'message');
            }
        }
        wp_die();
    }


    /**
     * @since 1.0
     * @version 3.0
     */
    public function savesettings(){
        // POST Data
        $nonce = $this->Disset($_POST,'cnonce');
        $stngs = $this->Disset($_POST,'dbmvsettings');
        $relod = false;
        // Verifications
        if(is_array($stngs) && wp_verify_nonce($nonce,'dbmovies-save-settings')){
            if($this->Disset($stngs,'dbmovies') !== $this->get_option('dbmovies')){
                delete_transient('dbmovies_activator');
                $relod = true;
            }
            if($this->Disset($stngs,'themoviedb') !== $this->get_option('themoviedb')){
                delete_transient('themoviedb_activator');
                $relod = true;
            }
            $update = update_option(DBMOVIES_OPTIONS,$stngs);
            if($update){
                $response = array(
                    'response' => true,
                    'message' => __('Settings saved'),
                    'reload' => $relod
                );
            }else{
                $response = array(
                    'response' => true,
                    'message' => __('No changes to save'),
                    'reload' => $relod
                );
            }
        } else {
            $response = array(
                'response' => false,
                'message' => __('Validation is not completed'),
                'reload' => $relod
            );
        }
        header('Content-type: application/json');
        echo $this->ResponseJson($response);
        // Kill action
        wp_die();
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function tmdbinsert(){
        // Header
        header('Content-type: application/json');
        // Post Data
        $type = $this->Disset($_REQUEST,'ptype');
        $tmdb = $this->Disset($_REQUEST,'ptmdb');
        // Nonce condiction
        if($type && $tmdb){
            new DDbmoviesImporters($type, array('id' => $tmdb, 'ed' => false));
        }else{
            echo $this->ResponseJson(array('response' => false,'message' => __('Complete required data')));
        }
        // Kill action
        wp_die();
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function tmdbseasons(){
        // Header
        header('Content-type: application/json');
        // Post Data
        $tmdb = $this->Disset($_REQUEST,'tmdb');
        $tmse = $this->Disset($_REQUEST,'tmse');
        $tnam = $this->Disset($_REQUEST,'name');
        $post = $this->Disset($_REQUEST,'post');
        $meta = get_post_meta( $post,'clgnrt',true);
        if(!$meta){
            update_post_meta( $post, 'clgnrt', '1');
        }
        // Verify
        if($tmdb && $tmse && $tnam){
            $season_data = array(
                'id' => $tmdb,
                'se' => $tmse,
                'nm' => $tnam,
                'ed' => false,
            );
            new DDbmoviesImporters('seasons',$season_data);
        } else {
            echo $this->ResponseJson(array('response' => false,'message' => __('Complete required data')));
        }
        // Kill action
        wp_die();
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function tmdbepisodes(){
        // Header
        header('Content-type: application/json');
        // Post Data
        $tmdb = $this->Disset($_REQUEST,'tmdb');
        $tmse = $this->Disset($_REQUEST,'tmse');
        $tmep = $this->Disset($_REQUEST,'tmep');
        $tnam = $this->Disset($_REQUEST,'name');
        $post = $this->Disset($_REQUEST,'post');
        $meta = get_post_meta( $post,'clgnrt',true);
        if(!$meta){
            update_post_meta( $post, 'clgnrt', '1');
        }
        // Verify
        if($tmdb && $tmse && $tmep && $tnam){
            $episode_data = array(
                'id' => $tmdb,
                'se' => $tmse,
                'ep' => $tmep,
                'nm' => $tnam,
                'ed' => false,
            );
            new DDbmoviesImporters('episodes',$episode_data);
        }else{
            echo $this->ResponseJson(array('response' => false,'message' => __('Complete required data')));
        }
        // Kill action
        wp_die();
    }

}

new DDbmoviesAjax;
