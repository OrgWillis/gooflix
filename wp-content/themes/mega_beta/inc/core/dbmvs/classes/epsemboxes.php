<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class DDbmoviesEPSEMboxes extends DDbmoviesHelpers{



    /**
     * @since 1.0
     * @version 1.0
     */
    public function __construct(){
       add_action('add_meta_boxes', array(&$this,'Register'));
   }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function Register(){
        add_meta_box('dbmovies_metabox_tvshows', __('Seasons','mega'), array(&$this,'TVShows'), 'tvshows', 'normal', 'high');
        add_meta_box('dbmovies_metabox_seasons', __('Episodes','mega'), array(&$this,'Seasons'), 'seasons', 'normal', 'high');
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function TVShows(){
        global $post;
        $tmdb = get_post_meta( $post->ID, 'ids', true);
        $gnrt = get_post_meta( $post->ID, 'clgnrt', true);
        $seas = $this->GetSeasons($tmdb);
        $sbtn = ($gnrt) ? __('Generate new seasons') : __('Generate Seasons','mega');
        require_once(DBMOVIES_DIR.'/tpl/seasons_generator.php');
        if($seas){
            $this->SeasonsView($seas, $tmdb);
        } else {
            echo '<div class="dbmovies-no-content"><p>'.__('There is not yet content to show','mega').'</p></div>';
        }

    }


    /**
     * @since 1.0
     * @version 1.0
     */
    Public function Seasons(){
        global $post;
        $tmdb = get_post_meta( $post->ID, 'ids', true);
        $seas = get_post_meta( $post->ID, 'temporada', true);
        $gnrt = get_post_meta( $post->ID, 'clgnrt', true);
        $epsd = $this->GetEpisodes($tmdb,$seas);
        $sbtn = ($gnrt) ? __('Generate new episodes','mega') : __('Generate Episodes','mega');
        require_once(DBMOVIES_DIR.'/tpl/episodes_generator.php');
        if($epsd){
            $this->EpisodesViews($epsd,$tmdb,$seas);
        } else {
            echo '<div class="dbmovies-no-content"><p>'.__('There is not yet content to show','mega').'</p></div>';
        }

    }


    /**
     * @since 1.0
     * @version 1.0
     */
    private function GetSeasons($tmdb = ''){
        // Define Seasons
        $seasons = array();
        // Start Query
        $query = self::GetAllSeasons($tmdb);
        if($query){
            foreach($query as $postid){
                $seasons[] = array(
                    'id'        => $postid,
                    'tmdb'      => $tmdb,
                    'temporada' => get_post_meta($postid, 'temporada', true),
                    'title'     => get_the_title($postid),
                    'edit'      => admin_url('post.php?post='.$postid.'&action=edit'),
                    'delete'    => get_delete_post_link($postid),
                );
            }
        }
        return apply_filters('dbmovies_get_all_seasons', $seasons, $tmdb);
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    private function GetEpisodes($tmdb = '', $season = ''){
        // Define Episodes
        $episodes = array();
        // Start Query
        $query = self::GetAllEpisodes($tmdb,$season);
        // Verify Query
        if($query){
            foreach($query as $postid){
                $episodes[] = array(
                    'id'           => $postid,
                    'tmdb'         => $tmdb,
                    'temporada'    => $season,
                    'episode'      => get_post_meta($postid, 'episodio', true),
                    'poster'       => get_post_meta($postid, 'backdrop', true),
                    'episode_name' => get_post_meta($postid, 'episode_name', true),
                    'title'        => get_the_title($postid),
                    'edit'         => admin_url('post.php?post='.$postid.'&action=edit'),
                    'delete'       => get_delete_post_link($postid),
                );
            }
        }
        return apply_filters('dbmovies_get_all_episodes', $episodes, $tmdb.$season);
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    private function SeasonsView($query = array(), $tmdb = ''){
        if(is_array($query)){

            $html_out ="<div class='panel'>";
            foreach($query as $key => $val){

                // Compose Data
                $id        = $this->Disset($val,'id');
                $tmdb      = $this->Disset($val,'tmdb');
                $temporada = $this->Disset($val,'temporada');
                $title     = $this->Disset($val,'title');
                $edit      = $this->Disset($val,'edit');
                $delete    = $this->Disset($val,'delete');

                //query episode
                $query_episodes = $this->GetEpisodes($tmdb,$temporada);

                // html
                $html_out .='<article class="tvshow_gerent_season se-c">';
                $html_out .="<h1 class='row_title s-acitve se-t'>{$temporada}</h1>";
                $html_out .="<p class='row'>";
                if(!get_post_meta($id,'clgnrt',true)){
                    $html_out .="<a href='$edit&generate_episodes=all' target='_blank' class='btn'>".__('Get episodes', 'mega')."</a>";
                }
                $html_out .="<a href='{$edit}' target='_blank' class='btn btn_blue'>".__('Edit', 'mega')."</a>";
                $html_out .="<a href='{$delete}' target='_blank' class='btn btn_red'>".__('Delete', 'mega').'</a></p>';

                if($query_episodes && is_array($query_episodes)){
                    $html_out .="<div class='episodes-desactive'>";
                    foreach($query_episodes as $episode => $vall){
                        // Compose Data
                        $id        = $this->Disset($vall,'id');
                        $tmdb      = $this->Disset($vall,'tmdb');
                        $temporada = $this->Disset($vall,'temporada');
                        $episode   = $this->Disset($vall,'episode');
                        $poster    = $this->Disset($vall,'poster');
                        $title     = $this->Disset($vall,'episode_name');
                        $edit      = $this->Disset($vall,'edit');
                        $delete    = $this->Disset($vall,'delete');
                         // html
                        $html_out .="<article class='tvshow_gerent_season episode'>";
                        $html_out .="<div class='imagen'><img src='".$this->ComposeTMDbImage($poster,'episodes')."'></div>";
                        $html_out .="<p class='row-episode'>";

                        $html_out .="<span class='num'>{$temporada} - {$episode}</span>";

                        $html_out .="<span class='title'>{$title}</span>";

                        $html_out .="<a href='{$edit}' target='_blank' class='btn btn_blue'>".__('Edit', 'mega')."</a>";
                        $html_out .="<a href='{$delete}' target='_blank' class='btn btn_red'>".__('Delete', 'mega').'</a></p>';

                        $html_out .='</article>';
                    }
                    $html_out .="</div>";
                } else{
                    $html_out .= "<div class='dbmovies-no-content no-cont'><p>".__('There are still no episodes this season','mega')."</p><div>";
                }


                $html_out .='</article>';
            }
            $html_out .= "</div>";
            // Filter views
            echo apply_filters('panel_seasons', $html_out, $tmdb);
        }
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    private function EpisodesViews($query = array(), $tmdb = '', $season = ''){
        if(is_array($query)){
            $html_out = "<div class='dbmovies_seasons_list episodes' id='tmdb-$tmdb-$season'>";
            $html_out .="<div class='panel'>";
            foreach($query as $episode => $vall){
                        // Compose Data
                $id        = $this->Disset($vall,'id');
                $tmdb      = $this->Disset($vall,'tmdb');
                $temporada = $this->Disset($vall,'temporada');
                $episode   = $this->Disset($vall,'episode');
                $poster    = $this->Disset($vall,'poster');
                $title     = $this->Disset($vall,'episode_name');
                $edit      = $this->Disset($vall,'edit');
                $delete    = $this->Disset($vall,'delete');
                         // html
                $html_out .="<article class='tvshow_gerent_season episode'>";
                $html_out .="<div class='imagen'><img src='".$this->ComposeTMDbImage($poster,'episodes')."'></div>";
                $html_out .="<p class='row-episode' style='background: #F8F9FB;'>";

                $html_out .="<span class='num'>{$temporada} - {$episode}</span>";

                $html_out .="<span class='title'>{$title}</span>";

                $html_out .="<a href='{$edit}' target='_blank' class='btn btn_blue'>".__('Edit', 'mega')."</a>";
                $html_out .="<a href='{$delete}' target='_blank' class='btn btn_red'>".__('Delete', 'mega').'</a></p>';

                $html_out .='</article>';
            }
            $html_out .="</div></div>";
            // Filter views
            echo apply_filters('dbmovies_get_html_episodes', $html_out, $tmdb.$season);
        }
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    private function ComposeTMDbImage($path = '', $type = ''){
        $path_assts = DBMOVIES_URI.'/assets/';
        $path_local = ($type == 'seasons') ? 'no_img_sea.png' : 'no_img_epi.png';
        if(!empty($path)){
            if(!filter_var($path, FILTER_VALIDATE_URL)){
                return 'https://image.tmdb.org/t/p/w92'.$path;
            } else {
                return $path;
            }
        } else {
            return $path_assts.$path_local;
        }
    }
}

new DDbmoviesEPSEMboxes;
