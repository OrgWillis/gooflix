<?php 

/*

Template Name: Page Embed

*/

$type = (isset($_GET['type'])) ? $_GET['type'] : null;
$imdb = (isset($_GET['imdb'])) ? $_GET['imdb'] : null;

if ($type != null) { 
	if ($type == 'movies' || $type == 'tvshows') {

		$key  = ($type == 'movies') ? 'ids' : 'imdb_id';

		$args = array(
			'post_type' =>  $type,
			'meta_query' => array(
				array(
					'key'   => $key,
					'value' => $imdb
				)
			),
		);

		$list_query = get_posts($args);

		if (count($list_query)) {

			foreach ($list_query as $post) {
	
				switch(get_post_type()) {

					case 'movies':
					get_template_part('page/parts/movies');
					break;

					case 'tvshows':
					get_template_part('page/parts/tvshows');
					break;
				}

			}
		}else {

			get_template_part('404');
		}
	}else {

		get_template_part('404');
	} 
}else {

	get_template_part('404');
}