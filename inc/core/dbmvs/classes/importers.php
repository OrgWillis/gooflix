<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class DDbmoviesImporters extends DDbmoviesHelpers{


    /**
     * @since 2.2.6
     * @version 1.0
     */
    protected $tmdbkey = '';
    protected $dbmvkey = '';
    protected $apilang = '';
    protected $repeatd = '';



    /**
     * @since 2.2.6
     * @version 1.0
     */
    var $type = '';
    var $data = '';



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct($type = '', $data = array()){
        // Vars
        $this->type = $type;
        $this->data = $data;
        // Application
        $this->App();
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function App(){
        // Properties
        $this->apilang = $this->get_option('language','en-US');
        $this->tmdbkey = $this->get_option('themoviedb',DBMOVIES_TMDBKEY);
        $this->dbmvkey = $this->get_option('dbmovies');
        $this->repeatd = $this->get_option('repeated');
        // Verify
        switch($this->type){
            case 'movie':
            case 'movies':
            $rest = $this->Movies($this->data['id'], $this->data['ed']);
            break;
            case 'tvshows':
            case 'tvshow':
            case 'tv':
            $rest = $this->TVShows($this->data['id'], $this->data['ed']);
            break;
            case 'seasons':
            $rest = $this->Seasons($this->data['id'], $this->data['se'], $this->data['nm'], $this->data['ed']);
            break;
            case 'episodes':
            $rest = $this->Episodes($this->data['id'], $this->data['se'], $this->data['ep'], $this->data['nm'], $this->data['ed']);
            break;
            default:
            $rest = $this->ResponseJson(array('response' => false,'message' => __('Unknown action','mega')));
            break;
        }
        echo $rest;
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Movies($tmdb = '', $edit = ''){
        // Verify String
        if(!empty($tmdb)){
            // Start timer
            $mtime = microtime(TRUE);
            // Composer ID from TMDb or IMDb
            $tmdb = $this->Compose_Title_ID($tmdb);
            // Fix ID Verificator
            $coid = 0;
            $skey = str_replace('tt', '', $tmdb, $coid);
            $skey = ($coid == 1) ? 'ids' : 'idtmdb';
            // Set TMDb ID
            if(isset($tmdb)){
                // Verify nonexistence
                if(!$this->VeryTMDb($skey,$tmdb,'movies') || $this->repeatd == true){
                    // Api Parameters TMDb
                    $tmdb_args = array(
                        'append_to_response'     => 'images,trailers',
                        'include_image_language' => $this->apilang.',null',
                        'language'               => $this->apilang,
                        'api_key'                => $this->tmdbkey
                    );
                    // Remote Data TMDb
                    $json_tmdb = $this->RemoteJson($tmdb_args, DBMOVIES_TMDBAPI.'/movie/'.$tmdb);
                    // Main data required
                    $imdb_id = $this->Disset($json_tmdb,'imdb_id');
                    $trailer = isset($json_tmdb['trailers']['youtube']) ? $json_tmdb['trailers']['youtube'] : false;
                    // Compose YouTube Traiter
                    $youtube = '';
                    if($trailer){
                        foreach($trailer as $key){
                            $youtube .= $key['source'];
                            break;
                        }
                    }
                    // Api Parameters IMDb
                    $imdb_args = array(
                        'key'  => $this->dbmvkey,
                        'imdb' => $imdb_id
                    );
                    // Remote Data IMDb
                    $json_imdb = $this->RemoteJson($imdb_args, DBMOVIES_DBMVAPI);
                    // Compose IMDb Data
                    $imdb_rating  = $this->Disset($json_imdb,'rating');
                    $imdb_rated   = $this->Disset($json_imdb,'rated');
                    $imdb_country = $this->Disset($json_imdb,'country');
                    $imdb_votes   = $this->Disset($json_imdb,'votes');
                    $imdb_votes   = str_replace(',','',$imdb_votes);
                    // Compose TMDb Data
                    $tmdb_id             = $this->Disset($json_tmdb,'id');
                    $tmdb_runtime		 = $this->Disset($json_tmdb,'runtime');
                    $tmdb_tagline		 = $this->Disset($json_tmdb,'tagline');
                    $tmdb_title	         = $this->Disset($json_tmdb,'title');
                    $tmdb_overview       = $this->Disset($json_tmdb,'overview');
                    $tmdb_vote_count     = $this->Disset($json_tmdb,'vote_count');
                    $tmdb_vote_average   = $this->Disset($json_tmdb,'vote_average');
                    $tmdb_release_date   = $this->Disset($json_tmdb,'release_date');
                    $tmdb_original_title = $this->Disset($json_tmdb,'original_title');
                    $tmdb_poster_path    = $this->Disset($json_tmdb,'poster_path');
                    $tmdb_backdrop_path  = $this->Disset($json_tmdb,'backdrop_path');
                    $tmdb_genres         = $this->Disset($json_tmdb,'genres');
                    
                    // Compose Genres
                    $genres = array();
                    if($tmdb_genres){
                        foreach($tmdb_genres as $genre){
                            $genres[] = $this->Disset($genre,'name');
                        }
                    }
                    // API TMDb Credits
                    $json_tmdb_credits = $this->RemoteJson($tmdb_args, DBMOVIES_TMDBAPI.'/movie/'.$tmdb.'/credits');
                    // TMDb Credits Data
                    $tmdb_cast = $this->Disset($json_tmdb_credits,'cast');
                    $tmdb_crew = $this->Disset($json_tmdb_credits,'crew');
                    // Compose Cast
                    $meta_cast = '';
                    if($tmdb_cast){
                        $cast_count = 0;
                        foreach($tmdb_cast as $cast) if($cast_count < 10){
                            // Pre Data
                            $name = $this->Disset($cast,'name');

                            $meta_cast .= $name.', ';
                            // Counter
                            $cast_count++;
                        }
                    }
                    // Compose Director
                    $meta_dire = '';
                    if($tmdb_crew){
                        foreach ($tmdb_crew as $crew){
                            // Pre data
                            $name = $this->Disset($crew,'name');
                            $detp = $this->Disset($crew,'department');

                            if($detp == 'Directing'){
                                $meta_dire .= $name.', ';
                            }
                        }
                    }
                    // Preparing data
                    $post_date = $this->get_option('release') == true ? $tmdb_release_date : false;
                    $data_name = array('name'=>$tmdb_title,'year' => $tmdb_year);
                    $opt_title = $this->get_option('titlemovies','{name}');
                    // Post data
                    $post_data = array(
                        'ID'           => $edit,
                        'post_status'  => $this->get_option('pstatusmovies','publish'),
                        'post_title'   => $this->TextCleaner($this->Tags($opt_title,$data_name)),
                        'post_content' => $tmdb_overview ? $this->TextCleaner($tmdb_overview) : false,
                        'post_author'  => $this->SetUserPost(),
                        'post_date'    => $post_date,
                        'post_type'	   => 'movies'
                    );
                    // Title Defined
                    if(!empty($tmdb_title)){
                        // Insert Post
                        if(!empty($edit)){
                            $post_id = wp_update_post($post_data);
                        }else{
                            $post_id = wp_insert_post($post_data);
                        }
                        // WordPress No error
                        if(!is_wp_error($post_id)){

                            // Insert Generes
                            wp_set_object_terms($post_id, $genres, 'category', false);
                            // Set metada
                            $insert_postmeta = array(
                                'ids'            => $imdb_id,
                                'idtmdb'         => $tmdb_id,
                                'poster'         => $tmdb_poster_path,
                                'backdrop'       => $tmdb_backdrop_path,
                                'youtube_id'     => $youtube,
                                'imdbRating'     => $imdb_rating,
                                'imdbVotes'      => $imdb_votes,
                                'Rated'          => $imdb_rated,
                                'Country'        => $imdb_country,
                                'original_title' => $tmdb_original_title,
                                'release_date'   => $tmdb_release_date,
                                'vote_average'   => $tmdb_vote_average,
                                'vote_count'     => $tmdb_vote_count,
                                'tagline'        => $tmdb_tagline,
                                'runtime'        => $tmdb_runtime,
                                'cast'           => $meta_cast,
                                'dir'            => $meta_dire,
                            );
                            // Add Post Metas
                            foreach($insert_postmeta as $meta => $value){

                                if(!empty($value)) add_post_meta($post_id, $meta, sanitize_text_field($value), false);

                            }

                            ############################################################
                            $response = array(
                                'response'  => true,
                                'type'      => 'Movie',
                                'editlink'  => admin_url('post.php?post='.$post_id.'&action=edit'),
                                'permalink' => get_permalink($post_id),
                                'title'     => get_the_title($post_id),
                                'mtime'     => $this->TimeExe($mtime)
                            );
                            ############################################################
                        } else {
                            $response = array(
                                'response' => false,
                                'message' =>__('Error WordPress','mega')
                            );
                        }
                    } else {
                        $response = array(
                            'response' => false,
                            'message' =>__('The title is not defined','mega')
                        );
                    }
                } else {
                    $response = array(
                        'response' => false,
                        'message' =>__('This title already exists in the database','mega')
                    );
                }
            } else {
                $response = array(
                    'response' => false,
                    'message' =>__('This link is not valid','mega')
                );
            }
        } else {
            $response = array(
                'response' => false,
                'message' =>__('TMDb ID is not defined','mega')
            );
        }
        // Json Response composer
        return apply_filters('dbmovies_import_movies', $this->ResponseJson($response), $tmdb);
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function TVShows($tmdb = '', $edit = ''){
        // Verify String
        if(!empty($tmdb)){
            // Start timer
            $mtime = microtime(TRUE);
            // Compose ID from TMDb
            $tmdb = $this->Compose_Title_ID($tmdb);
            // Set TMDb ID
            if(isset($tmdb)){
                // Verify nonexistence
                if(!$this->VeryTMDb('ids',$tmdb,'tvshows') || $this->repeatd == true){
                    // Dbmvs Parameters
                    $dbmv_args = array(
                        'authkey' => $this->dbmvkey
                    );
                    // Remote Data
                    $json_dbmv = $this->RemoteJson($dbmv_args,DBMOVIES_DBMVAPI);
                    // Api verification
                    if($this->Disset($json_dbmv,'response')){
                        // Api Parameters TMDb
                        $tmdb_args = array(
                            'append_to_response'     => 'images,external_ids,credits,release_dates',
                            'include_image_language' => $this->apilang.',null',
                            'language'               => $this->apilang,
                            'api_key'                => $this->tmdbkey
                        );
                        // Remote Data TMDb
                        $json_tmdb = $this->RemoteJson($tmdb_args, DBMOVIES_TMDBAPI.'/tv/'.$tmdb);
                        // Compose TMDb Data
                        $tmdb_id              = $this->Disset($json_tmdb,'id');
                        $tmdb_name            = $this->Disset($json_tmdb,'name');
                        $tmdb_genres          = $this->Disset($json_tmdb,'genres');
                        $tmdb_networks        = $this->Disset($json_tmdb,'networks');
                        $tmdb_companies       = $this->Disset($json_tmdb,'production_companies');
                        $tmdb_creators        = $this->Disset($json_tmdb,'created_by');
                        $tmdb_runtimes        = $this->Disset($json_tmdb,'episode_run_time');
                        $tmdb_number_episodes = $this->Disset($json_tmdb,'number_of_episodes');
                        $tmdb_number_seasons  = $this->Disset($json_tmdb,'number_of_seasons');
                        $tmdb_first_air_date  = $this->Disset($json_tmdb,'first_air_date');
                        $tmdb_last_air_date   = $this->Disset($json_tmdb,'last_air_date');
                        $tmdb_overview        = $this->Disset($json_tmdb,'overview');
                        $tmdb_original_name   = $this->Disset($json_tmdb,'original_name');
                        $tmdb_vote_average    = $this->Disset($json_tmdb,'vote_average');
                        $tmdb_vote_count      = $this->Disset($json_tmdb,'vote_count');
                        $tmdb_poster_path     = $this->Disset($json_tmdb,'poster_path');
                        $tmdb_backdrop_path   = $this->Disset($json_tmdb,'backdrop_path');
                        $tmdb_imdb_id         = $this->Disset($json_tmdb,'external_ids');
                        $tmdb_episode         = $this->Disset($json_tmdb,'seasons');
                        $tmdb_year            = substr($tmdb_first_air_date, 0, 4);

                        // Compose imdb
                        $meta_imdb_id = $tmdb_imdb_id['imdb_id'];

                        // Compose Episode
                        $meta_episode = '';
                        if($tmdb_episode){
                            foreach($tmdb_episode as $episode){
                                // Pre Data
                                $meta_episode = $this->Disset($episode,'episode_count');
                            }
                        }

                        // Compose Creators
                        $meta_creator = '';
                        if($tmdb_creators){
                            foreach($tmdb_creators as $creator){
                                // Pre Data
                                $name = $this->Disset($creator,'name');

                                $meta_creator .=  $name.', ';
                            }
                        }
                        // Compose Genres
                        $genres = array();
                        if($tmdb_genres){
                            foreach($tmdb_genres as $genre){
                                $genres[] = $this->Disset($genre,'name');
                            }
                        }

                        // Compose Companies
                        $companies = '';
                        if($tmdb_companies){
                            foreach($tmdb_companies as $companie){
                                $companies .= $this->Disset($companie,'name').',';
                            }
                        }
                        // Compose Runtime
                        $runtime = '';
                        if($tmdb_runtimes){
                            foreach($tmdb_runtimes as $time){
                                $runtime .= $time;
                                break;
                            }
                        }
                        // Remote Data TMDb Credits
                        $json_tmdb_credits = $this->RemoteJson($tmdb_args, DBMOVIES_TMDBAPI.'/tv/'.$tmdb.'/credits');
                        // All Cast
                        $tmdb_cast = $this->Disset($json_tmdb_credits,'cast');
                        // Compose Cast

                        $meta_cast = '';
                        if($tmdb_cast){
                            $cast_count = 0;
                            foreach($tmdb_cast as $cast) if($cast_count < 10){
                                // Pre Data
                                $name = $this->Disset($cast,'name');
                                // Set Data
                                $meta_cast .= $name.', ';
                                // Counter
                                $cast_count++;
                            }
                        }
                        // Remote Data TMDb Credits
                        $json_tmdb_videos = $this->RemoteJson($tmdb_args, DBMOVIES_TMDBAPI.'/tv/'.$tmdb.'/videos');
                        // All Videos
                        $tmdb_videos = $this->Disset($json_tmdb_videos,'results');
                        // Compose Video YouTube
                        $youtube = '';
                        if($tmdb_videos){
                            foreach($tmdb_videos as $video){
                                $youtube .= $this->Disset($video,'key');
                                break;
                            }
                        }
                        // Preparing data
                        $post_date = $this->get_option('release') == true ? $tmdb_first_air_date : false;
                        $data_name = array('name'=>$tmdb_name,'year'=>$tmdb_year);
                        $opt_title = $this->get_option('titletvshows','{name}');
                        // Post data
                        $post_data = array(
                            'ID'           => $edit,
                            'post_status'  => $this->get_option('pstatustvshows','publish'),
                            'post_title'   => $this->TextCleaner($this->Tags($opt_title,$data_name)),
                            'post_content' => $tmdb_overview ? $this->TextCleaner($tmdb_overview): false,
                            'post_author'  => $this->SetUserPost(),
                            'post_date'    => $post_date,
                            'post_type'	   => 'tvshows'
                        );
                        // Show Name defined
                        if(!empty($tmdb_name)){
                            // Insert Post
                            if(!empty($edit)){
                                $post_id = wp_update_post($post_data);
                            }else{
                                $post_id = wp_insert_post($post_data);
                            }
                            // WordPress No Error
                            if(!is_wp_error($post_id)){
                                // Insert Generes
                             wp_set_object_terms($post_id, $genres, 'category', false);
                                // Set Data
                             $insert_postmeta = array(
                                'ids'                => $tmdb_id,
                                'youtube_id'         => $youtube,
                                'imdb_id'            => $meta_imdb_id,
                                'episode_run_time'   => $runtime,
                                'episode'            => $meta_episode,
                                'poster'             => $tmdb_poster_path,
                                'backdrop'           => $tmdb_backdrop_path,
                                'first_air_date'     => $tmdb_first_air_date,
                                'last_air_date'      => $tmdb_last_air_date,
                                'number_of_episodes' => $tmdb_number_episodes,
                                'number_of_seasons'  => $tmdb_number_seasons,
                                'original_name'      => $tmdb_original_name,
                                'imdbRating'         => $tmdb_vote_average,
                                'imdbVotes'          => $tmdb_vote_count,
                                'cast'               => $meta_cast,
                                'creator'            => $meta_creator,
                            );
                                // Add Post Metas
                             foreach($insert_postmeta as $meta => $value){

                                if(!empty($value)) add_post_meta($post_id, $meta, sanitize_text_field($value), false);

                            }

                            ############################################################
                            $response = array(
                                'response'  => true,
                                'type'      => 'TVShow',
                                'editlink'  => admin_url('post.php?post='.$post_id.'&action=edit'),
                                'permalink' => get_permalink($post_id),
                                'title'     => get_the_title($post_id),
                                'mtime'     => $this->TimeExe($mtime)
                            );
                            ############################################################

                        } else {
                            $response = array(
                                'response' => false,
                                'message' => __('Error WordPress','mega')
                            );
                        }
                    } else {
                        $response = array(
                            'response' => false,
                            'message' => __('The title is not defined','mega')
                        );
                    }
                } else{
                    $response = array(
                        'response' => false,
                        'message' => $this->Disset($json_dbmv,'message')
                    );
                }
            } else {
                $response = array(
                    'response' => false,
                    'message' => __('This title already exists in the database','mega')
                );
            }
        } else {
            $response = array(
                'response' => false,
                'message' => __('This link is not valid','mega')
            );
        }
    } else {
        $response = array(
            'response' => false,
            'message' => __('TMDb ID is not defined','mega')
        );
    }
        // Json Response composer
    return apply_filters('dbmovies_import_tvshow', $this->ResponseJson($response), $tmdb);
}



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Seasons($tmdb = '', $season = '', $name = '', $edit = ''){
        // Verify all Strings
        if(isset($tmdb) && isset($season) && isset($name)){
            // Start timer
            $mtime = microtime(TRUE);
            // Verify nonexistence
            if(!$this->VeryTMDbSE($tmdb, $season) || $this->repeatd == true){
                // Api Parameters TMDb
                $tmdb_args = array(
                    'append_to_response'     => 'images',
                    'language'               => $this->apilang,
                    'include_image_language' => $this->apilang.',null',
                    'api_key'                => $this->tmdbkey,
                );
                // Remote Data TMDb
                $json_tmdb = $this->RemoteJson($tmdb_args, DBMOVIES_TMDBAPI.'/tv/'.$tmdb.'/season/'.$season);
                if(!$this->Disset($json_tmdb,'status_code')){
                    // Compose TMDb Data TVShow > Season
                    $tmdb_number      = $this->Disset($json_tmdb,'season_number');
                    $tmdb_poster_path = $this->Disset($json_tmdb,'poster_path');
                    // Preparin Data
                    $data_name = array('name' => $name, 'season' => $tmdb_number);
                    $opt_title = $this->get_option('titleseasons',__('{name}: Season {season}','mega'));
                    // POST Data
                    $post_data = array(
                        'ID'           => $edit,
                        'post_status'  => $this->get_option('pstatusseasons','publish'),
                        'post_title'   => $this->TextCleaner($this->Tags($opt_title,$data_name)),
                        'post_author'  => $this->SetUserPost(),
                        'post_content' => false,
                        'post_type'	   => 'seasons',
                    );
                    // Insert Post
                    if(!empty($edit)){
                        $post_id = wp_update_post($post_data);
                    }else{
                        $post_id = wp_insert_post($post_data);
                    }
                    // WordPress No Error
                    if(!is_wp_error($post_id)){
                        // Set Data
                        $insert_postmeta = array(
                            'ids'       => $tmdb,
                            'temporada' => $tmdb_number,
                            'serie'     => $name,
                            'poster'    => $tmdb_poster_path,
                        );
                        // Add Post Metas
                        foreach ($insert_postmeta as $meta => $value) {
                          if(!empty($value)) add_post_meta($post_id, $meta, sanitize_text_field($value), false);
                      }

                        ############################################################
                      $response = array(
                        'response'  => true,
                        'editlink'  => admin_url('post.php?post='.$post_id.'&action=edit'),
                        'permalink' => get_permalink($post_id),
                        'title'     => get_the_title($post_id),
                        'mtime'     => $this->TimeExe($mtime)
                    );
                        ############################################################
                  } else {
                    $response = array(
                        'response' => false,
                        'message' => __('Error WordPress','mega')
                    );
                }
            }else{
                $response = array(
                    'response' => false,
                    'message' => $this->Disset($json_tmdb,'status_message')
                );
            }
        } else {
            $response = array(
                'response' => true,
                'mtime'    => $this->TimeExe($mtime),
                'message'  => __('This season already exists in database','mega')
            );
        }
    } else {
        $response = array(
            'response' => false,
            'message' => __('Complete required data','mega')
        );
    }
        // Json Response composer
    return apply_filters('dbmovies_import_tvshow_seasons', $this->ResponseJson($response), $tmdb.$season);
}



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Episodes($tmdb = '', $season = '', $episode = '', $name = '', $edit = ''){
        // Verify all Strings
        if($tmdb && $season && $episode && $name){
            // Start timer
            $mtime = microtime(TRUE);
            // Verify nonexistence
            if(!$this->VeryTMDbEP($tmdb, $season, $episode) || $this->repeatd == true){
                // Api Parameters TMDb
                $tmdb_args = array(
                    'append_to_response'     => 'images',
                    'language'               => $this->apilang,
                    'include_image_language' => $this->apilang.',null',
                    'api_key'                => $this->tmdbkey,
                );
                // Remote Data TMDb
                $json_tmdb = $this->RemoteJson($tmdb_args, DBMOVIES_TMDBAPI.'/tv/'.$tmdb.'/season/'.$season.'/episode/'.$episode);
                // Verify Status code
                if(!$this->Disset($json_tmdb,'status_code')){
                    // Compose TMDb Data TVShow > Season > Episode
                    $tmdb_name           = $this->Disset($json_tmdb,'name');
                    $tmdb_season_number  = $this->Disset($json_tmdb,'season_number');
                    $tmdb_spisode_number = $this->Disset($json_tmdb,'episode_number');
                    $tmdb_still_path     = $this->Disset($json_tmdb,'still_path');

                    // Preparing Title
                    $data_name = array('name' => $name, 'season' => $tmdb_season_number, 'episode' => $tmdb_spisode_number);
                    $opt_title = $this->get_option('titlepisodes','{name}: {season}x{episode}');
                    // Post data
                    $post_data = array(
                        'ID'            => $edit,
                        'post_status'   => $this->get_option('pstatusepisodes','publish'),
                        'post_author'	=> $this->SetUserPost(),
                        'post_title'	=> $this->TextCleaner($this->Tags($opt_title,$data_name)),
                        'post_content'	=> false,
                        'post_type'		=> 'episodes'
                    );
                    // Insert Post
                    if(!empty($edit)){
                        $post_id = wp_update_post($post_data);
                    }else{
                        $post_id = wp_insert_post($post_data);
                    }
                    // WordPress No Error
                    if(!is_wp_error($post_id)){
                        // Set Data
                        $insert_postmeta = array(
                            'ids'          => $tmdb,
                            'temporada'    => $tmdb_season_number,
                            'episodio'     => $tmdb_spisode_number,
                            'serie'        => $name,
                            'episode_name' => $tmdb_name,
                            'backdrop'     => $tmdb_still_path,
                        );
                        // Add Postmeta
                        foreach($insert_postmeta as $meta => $value){
                            if($meta == 'imagenes'){
                                if(!empty($value)) add_post_meta($post_id, $meta, esc_attr($value), false);
                            }else{
                                if(!empty($value)) add_post_meta($post_id, $meta, sanitize_text_field($value), false);
                            }
                        }
                        // Upload Poster
                        if(!empty($tmdb_upimage)) $this->UploadImage($tmdb_upimage, $post_id, true, false);
                        ############################################################
                        $response = array(
                            'response'  => true,
                            'editlink'  => admin_url('post.php?post='.$post_id.'&action=edit'),
                            'permalink' => get_permalink($post_id),
                            'title'     => get_the_title($post_id),
                            'mtime'     => $this->TimeExe($mtime)
                        );
                        ############################################################
                    } else {
                        $response = array(
                            'response' => false,
                            'message' => __('Error WordPress')
                        );
                    }
                } else {
                    $response = array(
                        'response' => false,
                        'message' => $this->Disset($json_tmdb,'status_message','mega')
                    );
                }
            } else{
                $response = array(
                    'response' => true,
                    'mtime'    => $this->TimeExe($mtime),
                    'message'  => __('This episode already exists in database','mega')
                );
            }
        } else {
            $response = array(
                'response' => false,
                'message' => __('Complete required data','mega')
            );
        }
        // Json Response composer
        return apply_filters('dbmovies_import_tvshow_episodes', $this->ResponseJson($response), $tmdb.$season.$episode);
    }
}
