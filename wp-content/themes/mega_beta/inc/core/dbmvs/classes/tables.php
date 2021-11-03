<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class DDbmoviesTables extends DDbmoviesHelpers{


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){

        // Actions Content
        add_action('manage_movies_posts_custom_column', array(&$this,'action_movies'), 10, 2);
        add_action('manage_tvshows_posts_custom_column', array(&$this,'action_tvshows'), 10, 2);
        add_action('manage_seasons_posts_custom_column', array(&$this,'action_seasons'), 10, 2);
        add_action('manage_episodes_posts_custom_column', array(&$this,'action_episodes'), 10, 2);
        add_action('manage_tvshows_posts_custom_column', array(&$this,'filter_thumbs'), 5, 2);
        add_action('manage_movies_posts_custom_column', array(&$this,'filter_thumbs'), 5, 2);
        add_action('manage_seasons_posts_custom_column', array(&$this,'filter_thumbs'), 5, 2);
        // Filters Header
        add_filter('manage_movies_posts_columns', array(&$this,'filter_movies'));
        add_filter('manage_tvshows_posts_columns', array(&$this,'filter_tvshows'));
        add_filter('manage_seasons_posts_columns', array(&$this,'filter_seasons'));
        add_filter('manage_episodes_posts_columns', array(&$this,'filter_episodes'));  
        add_filter('manage_tvshows_posts_columns', array(&$this, 'columns_thumbs'));
        add_filter('manage_movies_posts_columns', array(&$this, 'columns_thumbs'));
        add_filter('manage_seasons_posts_columns', array(&$this, 'columns_thumbs'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function action_movies($column_name, $post_id){
        $ids = get_post_meta($post_id,'ids',true);
        $rpt = get_post_meta($post_id,'numreport',true);
        $viw = get_post_meta($post_id,'post_views_count',true);
        $fea = get_post_meta($post_id,'featured_post',true);

        // Composes
        $ids = $ids ? $ids : '&mdash;';
        $viw = $viw ? $viw : '0';

        switch($column_name){
            case 'imdbid':
            echo '<code>'.$ids.'</code>';
            break;
            case 'report':
            if($rpt){
                echo '<span class="dt_report_video">'.$rpt.'</span> <a href="'.get_admin_url(get_current_blog_id(),'admin-ajax.php?action=delete_notice_report&id='.$post_id).'">'.__('Solved','mega').'</a>';
            } else {
                echo '&mdash;';
            }
            break;

            case 'views':
            echo $viw;
            break;

            case 'featur':
            $hideA = ( 1 == $fea ) ? 'style="display:none"' : '';
            $hideB = ( 1 != $fea ) ? 'style="display:none"' : '';
            echo '<a id="feature-add-'.$post_id.'" class="button add-to-featured button-primary" data-postid="'.$post_id.'" data-nonce="'.wp_create_nonce('featured-'.$post_id).'"  '.$hideA.'>'. __('Add','mega'). '</a>';
            echo '<a id="feature-del-'.$post_id.'" class="button del-of-featured" data-postid="'.$post_id.'" data-nonce="'.wp_create_nonce('featured-'.$post_id).'" '.$hideB.'>'. __('Remove','mega'). '</a>';
            break;
            case 'post_status':
            DDbmoviesTables::columns_posts_status();
            break;
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function filter_movies($defaults){
        $defaults['imdbid']      = __('IMDb ID','mega');
        $defaults['report']      = __('Reports','mega');
        $defaults['views']       = __('Views','mega');
        $defaults['featur']      = __('Recommend', 'mega');
        $defaults['post_status'] = __('Posts Status','mega');
        return $defaults;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function action_tvshows($column_name, $post_id){
        $ids  = get_post_meta($post_id,'ids',true);
        $imdb = get_post_meta($post_id,'imdb_id',true);
        $ses  = get_post_meta($post_id,'number_of_seasons',true);
        $viw  = get_post_meta($post_id,'post_views_count',true);
        $fea  = get_post_meta($post_id,'featured_post',true);
        $ctr  = get_post_meta($post_id,'clgnrt',true);

        // composes
        $ids = $ids ? $ids : '&mdash;';
        $viw = $viw ? $viw : '0';
        $ses = $ses ? $ses : '0';
        $ctr = ($ctr == 1) ? 'ready' : 'none';

        switch($column_name){
            case 'idtmdb':
            if($ctr != 'ready'){
                echo '<a href="#" id="dbgesbtn_'.$post_id.'" class="button dbmvsarchiveseep" data-type="seasons" data-parent="'.$post_id.'" data-tmdb="'.$ids.'">'.__('Get seasons','mega').'</a>';
                echo '<span id="gnrtse_'.$post_id.'"></span>';
            }else{
                echo '<code class="'.$ctr.'">'.$imdb.'</code>';
            }
            break;

            case 'season':
            echo $ses;
            break;

            case 'views':
            echo $viw;
            break;

            case 'featur':
            $hideA = ( 1 == $fea ) ? 'style="display:none"' : false;
            $hideB = ( 1 != $fea ) ? 'style="display:none"' : false;
            echo '<a id="feature-add-'.$post_id.'" class="button add-to-featured button-primary" data-postid="'.$post_id.'" data-nonce="'.wp_create_nonce('featured-'.$post_id).'"  '.$hideA.'>'. __('Add','mega'). '</a>';
            echo '<a id="feature-del-'.$post_id.'" class="button del-of-featured" data-postid="'.$post_id.'" data-nonce="'.wp_create_nonce('featured-'.$post_id).'" '.$hideB.'>'. __('Remove','mega'). '</a>';
            break;
            case 'post_status':
            DDbmoviesTables::columns_posts_status();
            break;
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function filter_tvshows($defaults){
        $defaults['idtmdb']      = __('IMDb ID','mega');
        $defaults['season']      = __('Seasons','mega');
        $defaults['views']       = __('Views','mega');
        $defaults['featur']      = __('Recommend', 'mega');;
        $defaults['post_thumbs'] = __('Imagem','mega');
        $defaults['post_status'] = __('Posts Status','mega');
        return $defaults;
    }

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function action_seasons($column_name, $post_id){
        $ids = get_post_meta($post_id,'ids',true);
        $ctr = get_post_meta($post_id,'clgnrt',true);
        $tvs = get_post_meta($post_id,'serie',true);
        $sea = get_post_meta($post_id,'temporada',true);
        // composes
        $ids = $ids ? $ids : '&mdash;';
        $ctr = ($ctr == 1) ? 'ready' : 'none';

        switch($column_name){
            case 'tvshow':
            if($tvs){
                echo '<strong>'.$tvs.'</strong>';
            }else{
                echo '&mdash;';
            }
            break;

            case 'tmdbid':
            if($ctr != 'ready'){
                echo '<a href="#" id="dbgesbtn_'.$post_id.'" class="button dbmvsarchiveseep" data-type="episodes" data-parent="'.$post_id.'" data-tmdb="'.$ids.'" data-season="'.$sea.'">'.__('Get episodes','mega').'</a>';
                echo '<span id="gnrtse_'.$post_id.'"></span>';
            } else {
                echo '<code class="'.$ctr.'">'.$ids.'</code>';
            }
            break;
        }
    }

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function filter_seasons($defaults){
        $defaults['tmdbid'] = __('TMDb ID','mega');
        $defaults['tvshow'] = __('TV Show','mega');
        return $defaults;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function action_episodes($column_name, $post_id){
        $ids = get_post_meta($post_id,'ids',true);
        $rpt = get_post_meta($post_id,'numreport',true);
        $nam = get_post_meta($post_id,'episode_name',true);
        $tvs = get_post_meta($post_id,'serie',true);

        // composes
        $nam = $nam ? $nam : '&mdash;';
        $ids = $ids ? $ids : '&mdash;';

        switch($column_name){
            case 'episde':
            echo $nam.'<br>';
            echo '<small><strong>'.$tvs.'</strong></small>';
            break;

            case 'tmdbid':
            echo '<code>'.$ids.'</code>';
            break;
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function filter_episodes($defaults){
        $defaults['episde'] = __('Episode','mega');
        $defaults['tmdbid'] = __('TMDb ID','mega');
        return $defaults;
    }

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function filter_thumbs($column_name, $post_id){

        $meta = get_post_meta($post_id,'poster', true);
        
        if ($meta) {
            $meta ='https://image.tmdb.org/t/p/w300'. $meta;
        }else{
            $meta = URI . '/assets/img/no/no_poster.png';
        }

        if($column_name === 'post_thumbs'){
            echo '<img src="'.$meta.'" width="100">';
        }
    }

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function columns_thumbs($defaults) {

        $new  = array();
        $tags = $defaults['post_thumbs'];
        unset($defaults['post_thumbs']); 

        foreach($defaults as $key=>$value) {
            if($key=='title') { 

                $new['post_thumbs'] = $tags; 

            }
            $new[$key] = $value;

        }

        return $new;
    }
    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function columns_posts_status() {

        global $post;

        if($post->post_status == "draft"){

            echo '<code class="code code-'. $post->post_status.'"">'.__('Draft','mega'). '</code>';

        }elseif ($post->post_status == "private") {

            echo '<code class="code code-'. $post->post_status.'"">'.__('Private','mega'). '</code>';

        }elseif ($post->post_status == "publish") {

            echo '<code class="code code-'. $post->post_status.'"">'.__('Published','mega'). '</code>';

        }elseif ($post->post_status == "pending") {

            echo '<code class="code code-'. $post->post_status.'"">'.__('Pending','mega'). '</code>';

        }elseif ($post->post_status == "requests") {

            echo '<code class="code code-'. $post->post_status.'"">'.__('Requests','mega'). '</code>';

        }elseif ($post->post_status == "future") {

            echo '<code class="code code-'. $post->post_status.'"">'.__('Future','mega'). '</code>';

        }

    }
}
new DDbmoviesTables;
