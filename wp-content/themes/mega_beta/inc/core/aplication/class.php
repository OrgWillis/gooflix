<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*
*/

class Aplication{

	public function getPost($args = array(), $filter = null){

		global $post;
		$postFilter = ''; # Variavel auxiliar
		$lisPost    = array();
		$list_query = new WP_Query($args);

		if ($list_query->have_posts()) {

			while ($list_query->have_posts()) { 
				$list_query->the_post();

				$id   = get_the_id();
				$type = get_post_type();

				switch($type) {

					case 'movies':
					$postFilter = postmeta_movies($id);
					break;

					case 'tvshows':
					$postFilter = postmeta_tvshows($id);
					break;
				}

				if (is_array($filter)) {

					$postFilter  = array_diff_key($postFilter, array_flip($filter));
					$postArray[] = $postFilter;

				}else{

					$postArray[] = $postFilter;
				}

				$postFilter = ''; # zera a variavel auxiliar
			}

			$result = $postArray;

		}else {

			$result = array(
				'status' => 'error',
				'error'  => "Opa Não Temos Mais $type Disponível"
			);
		}

		return  $result;
	}

	public function getSearch($args, $filter = null){
		global $post;
		$postFilter = ''; # Variavel auxiliar
		$lisPost    = array();
		$list_query = new WP_Query($args);

		if ($list_query->have_posts()) {

			while ($list_query->have_posts()) { 
				$list_query->the_post();

				$id   = get_the_id();
				$type = get_post_type();

				switch($type) {

					case 'movies':
					$postFilter = postmeta_movies($id);
					break;

					case 'tvshows':
					$postFilter = postmeta_tvshows($id);
					break;
				}

				$original = $postFilter['original'];

				if (is_array($filter)) {

					$postFilter = array_diff_key($postFilter, array_flip($filter));
					$postFilter   = $postFilter;

				}else{

					$postFilter = $postFilter;
				}

				$lisPost[] = array(
					'type' => "{$type}",
					'data' => $postFilter
				);

				$postFilter = ''; # zera a variavel de auxiliar
				if (strtolower(get_the_title()) == strtolower($args['s']) || strtolower($args['s']) == strtolower($original)) {
					break;
				}
			}

			$result = $lisPost;

		}else {

			$result = array(
				'status' => 'error'
			);
		}

		return  $result;
	}

	public function EpisodesViews($tmdb, $season){

		//query episode
        $query_episodes = DDbmoviesHelpers::GetAllEpisodes($tmdb,$season); # Pega Todos os ep da temporada

        if($query_episodes && is_array($query_episodes)){

                $episodes      = array(); # Limpa a Variavel

                foreach($query_episodes as $episode){
                    // Compose Data
                	$ep      = get_post_meta($episode,'episodio', true);
                	$player  = formatPlayer($episode);
                	$player  = getPlayerArray($player);

                	$episodes[] = array(
                		'id'     => $episode,
                		'ep'     => $ep,
                		'player' => $player
                	);
                } 

                $result = array(
                	'status'   => 'success',
                	'seasons'  => $season,
                	'episodes' => $episodes
                ); 

            }else{

            	$result = array(
            		'status'   => 'error',
            		'seasons'  => 'Nada Disponível!'
            	);
            }

            return $result;
        }

        public function cacheName(Array $array){
        	$return = '';
        	array_walk_recursive($array, function($a) use (&$return) { $return = $return . "$a-"; });
        	return $return . get_current_blog_id();
        }
    }
