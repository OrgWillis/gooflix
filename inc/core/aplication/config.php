<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

add_action( 'rest_api_init', 'register_api_hooks' ); 

// API custom endpoints for WP-REST API 
function register_api_hooks() {
	register_rest_route( 
		'api/', '(?P<type>[a-zA-Z0-9-]+)', 
		array( 
			'methods'  => 'GET',
			'callback' => 'return_post_type',
		) 
	);
}

/**
* 
* @since 1.0
*
* @param $data[what, orderby, order, showposts, page, terms, id] 
* @return array|Object
*/
function return_post_type($data){
	$maintenance = cs_get_option('maintenance'); # Status da Api
	$update      = cs_get_option('update'); 	 # Status da atualizacao
	$version_app = cs_get_option('version_app'); # Versao da api
	$showposts   = ($data['showposts']) ? $data['showposts'] : get_option('number_items_'.$data['type'],'12');
	$app         = new Aplication; # Inicializa o apicativo
	$cache       = new PostCache; # Inicializa o cache
	$cacheName   = '';
	# Filter Remove os elementos do array
	$filter      = array(
		'players',
		'seasons',
		'description',
		'movie_quality',
		'youtube',
		'Rated',
		'Country',
		'original',
		'tagline',
		'vote_average',
		'vote_count',
		'cast',
		'dir',
		'views_count',
		'imdbVotes',
		'idtmdb',
		'autor',
		'tmdb',
		'year_air_date',
	);

	# Verifica se a API esta em manuntecao
	if ($maintenance) {

	 	# Api em Manutencao
		$result = array(
			'status' => 'maintenance',
		);

	# Verifica a versao da api passada 
	} else if($update && $version_app != $data['version']){

		$result = array(
			'status' => 'update',
			'url'    => cs_get_option('update_url')
		);

	} else if ($data['type'] == 'movies' || $data['type'] == 'tvshows') {

		switch ($data['what']) {

			# Retorna um post pelo id do imdb
			case 'data':
			$imdb  = ($data['type'] == 'movies') ? 'ids' : 'imdb_id';

			$args = array(
				'post_type' =>  $data['type'],
				'meta_query' => array(
					array(
						'key'   => $imdb,
						'value' => $data['id']
					)
				),
			);

			$cacheName = $app->cacheName($args); # Adiciona o nome do cache
			$cacheData = $cache->get($cacheName); # Recupera o cache

			if(!$cacheData){

				$cacheData = array(
					'status'      => 'success',
					$data['type'] => $app->getPost($args)
				);

				// Update cache
				$cache->set($cacheName, serialize($cacheData));
				
			}else{

				$cacheData = maybe_unserialize($cacheData);
			}

			$result = $cacheData;

			break;

			# Retorna uma lista com os ultimos posts pela data da ultima atualizacao
			case 'launch':
			$args = array(
				'post_type'      => $data['type'],
				'post_status'    => 'publish',
				'posts_per_page' => $showposts,
				'paged'          => $data['page'],
				'orderby'        => 'modified',
				'order'          => $data['order'],
			);

			# Modificando argumentos casos for filmes
			if ($data['type']  == 'movies') {
				$args['orderby'] = $data['orderby'];
				$args['cat']     = cs_get_option('categoryID', null);
			}

			$cacheName = $app->cacheName($args); # Adiciona o nome do cache
			$cacheData = $cache->get($cacheName); # Recupera o cache

			if(!$cacheData){

				$cacheData = array(
					'status'      => 'success',
					$data['type'] => $app->getPost($args, $filter)
				);

				// Update cache
				$cache->set($cacheName, serialize($cacheData));
				
			}else{

				$cacheData = maybe_unserialize($cacheData);
			}

			$result = $cacheData;

			break;

			# Retorna uma lista com os ultimos posts pela data de postagem
			case 'recent':
			$args = array(
				'post_type'      => $data['type'],
				'post_status'    => 'publish',
				'posts_per_page' => $showposts,
				'paged'          => $data['page'],
				'orderby'        => 'post_date',
				'order'          => $data['order'],
			);

			$cacheName = $app->cacheName($args); # Adiciona o nome do cache
			$cacheData = $cache->get($cacheName); # Recupera o cache

			if(!$cacheData){

				$cacheData = array(
					'status'      => 'success',
					$data['type'] => $app->getPost($args, $filter)
				);

				// Update cache
				$cache->set($cacheName, serialize($cacheData));
				
			}else{

				$cacheData = maybe_unserialize($cacheData);
			}

			$result = $cacheData;

			break;

			# Retorna uma lista com os posts marcado como recomendado
			case 'recommend':
			$args = array(
				'post_type'      => $data['type'],
				'post_status'    => 'publish',
				'posts_per_page' => $showposts,
				'paged'          => $data['page'],
				'orderby'        => 'post_date',
				'order'          => $data['order'],
				'meta_query'  => array (
					array (
						'key'     => 'featured_post',
						'value'   => '1',
						'compare' => 'LIKE'
					)
				)
			);

			$cacheName = $app->cacheName($args); # Adiciona o nome do cache
			$cacheData = $cache->get($cacheName); # Recupera o cache

			if(!$cacheData){

				$cacheData = array(
					'status'      => 'success',
					$data['type'] => $app->getPost($args, $filter)
				);

				// Update cache
				$cache->set($cacheName, serialize($cacheData));
				
			}else{

				$cacheData = maybe_unserialize($cacheData);
			}

			$result = $cacheData;

			break;

			# Retorna uma lista de posts pela categoria
			case 'category':
			$args = array(
				'post_type'      => $data['type'],
				'post_status'    => 'publish',
				'posts_per_page' => $showposts,
				'paged'          => $data['page'],
				'orderby'        => 'post_date',
				'order'          => $data['order'],
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => $data['terms']
					),
				)
			);

			$cacheName = $app->cacheName($args); # Adiciona o nome do cache
			$cacheData = $cache->get($cacheName); # Recupera o cache

			if(!$cacheData){

				$cacheData = array(
					'status'      => 'success',
					$data['type'] => $app->getPost($args, $filter)
				);

				// Update cache
				$cache->set($cacheName, serialize($cacheData));
				
			}else{

				$cacheData = maybe_unserialize($cacheData);
			}

			$result = $cacheData;

			break;

			# Retorna uma lista de posts pela data de postagem, ultima atualizacao, slider e uma lista de categorias
			case 'home':
			$showhome = ($data['type']  == 'movies') ? 3 : $showposts;

			$args = array(
				'post_type' => $data['type'],
				'what'      => 'home'
			);

			# Argumentos Para O Slider Principal
			$argsSlider = array(
				'post_type'      => $data['type'],
				'post_status'    => 'publish',
				'posts_per_page' => $showhome,
				'paged'          => $data['page'],
				'orderby'        => 'post_date',
				'order'          => $data['order'],
				'meta_query'  => array (
					array (
						'key'     => 'featured_post',
						'value'   => '1',
						'compare' => 'LIKE'
					)
				)
			);

			# Argumentos Para O Lancamentos
			$argsLaunch = array(
				'post_type'      => $data['type'],
				'post_status'    => 'publish',
				'posts_per_page' => $showposts,
				'paged'          => $data['page'],
				'orderby'        => 'modified',
				'order'          => $data['order'],
			);
			# Modificando argumentos casos for filmes
			if ($data['type']  == 'movies') {
				$argsLaunch['orderby'] = $data['orderby'];
				$argsLaunch['cat']     = cs_get_option('categoryID', null);
			}
			
			# Agumentos Para O Recentes
			$argsRecent = array(
				'post_type'      => $data['type'],
				'post_status'    => 'publish',
				'posts_per_page' => $showposts,
				'paged'          => $data['page'],
				'orderby'        => 'post_date',
				'order'          => $data['order'],
			);

			$cacheName = $app->cacheName($args); # Adiciona o nome do cache
			$cacheData = $cache->get($cacheName); # Recupera o cache

			if(!$cacheData){

				$cacheData = array(
					'status'   => 'success',
					'category' => list_category_app(),
					'slider'   => $app->getPost($argsSlider, $filter),
					'recent'   => $app->getPost($argsRecent, $filter),
					'launch'   => $app->getPost($argsLaunch, $filter)

				);

				// Update cache
				$cache->set($cacheName, serialize($cacheData));
				
			}else{

				$cacheData = maybe_unserialize($cacheData);
			}

			$result = $cacheData;

			break;

			# Retorna uma lista com os posts mais vistos
			case 'views':
			$args = array(
				'post_type'           => $data['type'],
				'posts_per_page'      => $showposts,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'orderby'             => 'meta_value_num',
				'meta_key'            => 'post_views_count',
				'order'               => 'DESC'
			);

			$cacheName = $app->cacheName($args); # Adiciona o nome do cache
			$cacheData = $cache->get($cacheName); # Recupera o cache

			if(!$cacheData){

				$cacheData = array(
					'status'      => 'success',
					$data['type'] => $app->getPost($args, $filter)
				);

				// Update cache
				$cache->set($cacheName, serialize($cacheData));
				
			}else{

				$cacheData = maybe_unserialize($cacheData);
			}

			$result = $cacheData;

			break;

			# Retorna os epsodios de uma temporada
			case 'epsodes':
			$result =  $app->EpisodesViews($data['tmdb'], $data['season']);
			break;

			# O default retorna uma lista com ultimos post caso o valor what nao seja passado
			default:
			$args = array(
				'post_type'      => $data['type'],
				'post_status'    => 'publish',
				'posts_per_page' => $showposts,
				'paged'          => $data['page'],
				'orderby'        => $data['orderby'],
				'order'          => $data['order'],
			);

			$cacheName = $app->cacheName($args); # Adiciona o nome do cache
			$cacheData = $cache->get($cacheName); # Recupera o cache

			if(!$cacheData){

				$cacheData = array(
					'status'      => 'success',
					$data['type'] => $app->getPost($args, $filter)
				);

				// Update cache
				$cache->set($cacheName, serialize($cacheData));
				
			}else{

				$cacheData = maybe_unserialize($cacheData);
			}

			$result = $cacheData;

			break;
		}
	# Retorna uma lista de post pela pesquisa 
	}elseif ($data['type'] == 'search') {
	
		$args = array(
			'post_type'      => array('movies','tvshows'),
			'post_status'    => 'publish',
			's'              => $data['s'],
			'posts_per_page' => $showposts,
		);

		$result = array(
			'status' => 'success',
			'search' => $app->getSearch($args, $filter)
		);

	} else{

		# Exibe Error
		$result = array(
			'status' => 'error',
			'error'  => 'Não Sabemos o que você quer!'
		);
	}

	return $result; 
}
