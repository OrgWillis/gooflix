<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*
*/

/**
 * @since 2.1.4
 * @version 1.0
 */
function meta_isset($data, $meta){
    return (isset($data[$meta][0])) ? $data[$meta][0] : false;
}


/**
 * @since 2.1.8
 * @version 1.1
 */
function postmeta_movies($post_id){
    global $post;
    // All post meta
    $cache     = new PostCache;
    $cacheName = $post_id . '_postmeta_' . get_current_blog_id();
    $pdata     = $cache->get($cacheName);
    // Verify cache
    if(!$pdata){
        // In database
        $post_meta = get_post_meta($post_id);
        // compose data
        $pdata = array(
            'title'          => get_the_title($post_id),
            'autor'          => "$post->post_author",
            'description'    => get_post_field('post_content', $post_id),
            'permalink'      => get_the_permalink($post_id),
            'category'       => return_term_list($post_id, 'category'),
            'imdb'           => meta_isset($post_meta,'ids'),
            'movie_quality'  => meta_isset($post_meta,'movie_quality'),
            'poster'         => return_get_poster($post_id, 'poster', 'w300'),
            'backdrop'       => return_get_poster($post_id, 'backdrop', 'original'),
            'youtube'        => meta_isset($post_meta,'youtube_id'),
            'imdbRating'     => meta_isset($post_meta,'imdbRating'),
            'imdbVotes'      => meta_isset($post_meta,'imdbVotes'),
            'Rated'          => meta_isset($post_meta,'Rated'),
            'Country'        => meta_isset($post_meta,'Country'),
            'idtmdb'         => meta_isset($post_meta,'idtmdb'),
            'original'       => meta_isset($post_meta,'original_title'),
            'tagline'        => meta_isset($post_meta,'tagline'),
            'year'           => formatData(meta_isset($post_meta,'release_date')),
            'vote_average'   => meta_isset($post_meta,'vote_average'),
            'vote_count'     => meta_isset($post_meta,'vote_count'),
            'runtime'        => runtime(meta_isset($post_meta,'runtime')),
            'cast'           => meta_isset($post_meta,'cast'),
            'dir'            => meta_isset($post_meta,'dir'),
            'views_count'    => meta_isset($post_meta,'post_views_count'),
            'players'        => formatPlayer($post_id)
        );
        // Update cache
        $cache->set($cacheName, serialize($pdata));
    }else{
        $pdata = maybe_unserialize($pdata);
    }
    // The return
    return apply_filters('postmeta_movies', $pdata, $post_id);
}



/**
 * @since 2.1.4
 * @version 1.0
 */
function postmeta_tvshows($post_id){
    global $post;
    // All post meta
    $cache     = new PostCache;
    $cacheName = $post_id . '_postmeta_' . get_current_blog_id();
    $pdata     = $cache->get($cacheName);
    // Verify cache
    if(!$pdata){
        // In database
        $post_meta = get_post_meta($post_id);
        // compose data
        $pdata = array(
            'title'              => get_the_title($post_id),
            'autor'              => "$post->post_author",
            'description'        => get_post_field('post_content', $post_id),
            'permalink'          => get_the_permalink($post_id),
            'category'           => return_term_list($post_id, 'category'),
            'tmdb'               => meta_isset($post_meta,'ids'),
            'imdb'               => meta_isset($post_meta,'imdb_id'),
            'poster'             => return_get_poster($post_id, 'poster', 'w300'),
            'backdrop'           => return_get_poster($post_id, 'backdrop', 'original'),
            'youtube'            => meta_isset($post_meta,'youtube_id'),
            'original'           => meta_isset($post_meta,'original_name'),
            'year'               => formatData(meta_isset($post_meta,'first_air_date')),
            'year_air_date'      => formatData(meta_isset($post_meta,'last_air_date')),
            'imdbRating'         => meta_isset($post_meta,'imdbRating'),
            'imdbVotes'          => meta_isset($post_meta,'imdbVotes'),
            'number_of_seasons'  => meta_isset($post_meta,'number_of_seasons'),
            'number_of_episodes' => meta_isset($post_meta,'number_of_episodes'),
            'cast'               => meta_isset($post_meta,'cast'),
            'dir'                => meta_isset($post_meta,'creator'),
            'runtime'            => meta_isset($post_meta,'episode_run_time'),
            'episode'            => meta_isset($post_meta,'episode'),
            'views_count'        => meta_isset($post_meta,'post_views_count'),
            'seasons'            => SeasonsViewEpsode(meta_isset($post_meta,'ids'))
        );
        // Update cache
        $cache->set($cacheName, serialize($pdata));
    }else{
        $pdata = maybe_unserialize($pdata);
    }
    // The return
    return apply_filters('postmeta_tvshows', $pdata, $post_id);
}

/**
* @since 1.0
* @version 1.0
 */

function SeasonsViewEpsode($tmdb = ''){

    $query_seasons = DDbmoviesHelpers::GetAllSeasons($tmdb); # Pega Todos as temporadas
    $result        = array(); # Limpa a Variavel

    if($query_seasons && is_array($query_seasons)){

        foreach($query_seasons as $seasons){
            // Compose Data
            $temporada =  get_post_meta($seasons, 'temporada', true);

            //query episode
            $query_episodes = DDbmoviesHelpers::GetAllEpisodes($tmdb,$temporada); # Pega Todos os ep da temporada

            if($query_episodes && is_array($query_episodes)){

                $episodes      = array(); # Limpa a Variavel

                foreach($query_episodes as $episode){
                    // Compose Data
                    $ep      = get_post_meta($episode,'episodio', true);
                    $player  = formatPlayer($episode);

                    $episodes[] = array(
                        'id'     => "{$episode}",
                        'ep'     => "{$ep}",
                        'player' => $player

                    );

                }            
            }

            $result[] = array(

                'seasons'  => "{$temporada}",
                'id'       => "{$seasons}",
                'episodes' => $episodes

            );

        }
    }

    return $result;
}