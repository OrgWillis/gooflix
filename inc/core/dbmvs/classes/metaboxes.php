<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class DDbmoviesMetaboxes extends DDbmoviesHelpers{

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
    	add_action('add_meta_boxes',array(&$this,'metaboxes'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function metaboxes(){
    	add_meta_box('metabox',__('Movie Info','mega'),array(&$this,'meta_movies'),'movies','normal','high');
    	add_meta_box('metabox',__('TVShow Info','mega'),array(&$this,'meta_tvshows'),'tvshows','normal','high');
    	add_meta_box('metabox',__('Season Info','mega'),array(&$this,'meta_seasons'),'seasons','normal','high');
    	add_meta_box('metabox',__('Episode Info','mega'),array(&$this,'meta_episodes'),'episodes','normal','high');
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function meta_movies(){
        // Nonce security
    	wp_nonce_field('_movie_nonce', 'movie_nonce');
		// Metabox options
    	$options = array(
    		array(
    			'id'            => 'ids',
    			'id2'		    => null,
    			'id3'		    => null,
    			'type'          => 'generator',
    			'style'         => 'style="background: #f7f7f7"',
    			'class'         => 'regular-text',
    			'placeholder'   => 'tt2911666',
    			'label'         => __('Generate data','mega'),
    			'desc'          => __('Generate data from <strong>imdb.com</strong>','mega'),
    			'fdesc'         => __('E.g. http://www.imdb.com/title/<strong>tt2911666</strong>/','mega'),
    			'requireupdate' => true
    		),
    		array(
    			'id'     => 'movie_quality',
    			'type'   => 'checkbox',
    			'label'  => __('Movie quality','mega'),
    			'clabel' => __('Is this movie in cinéma quality?','mega')
    		),
    		array(
    			'type'    => 'heading',
    			'colspan' => 2,
    			'text'    => __('Images and trailer','mega')
    		),
    		array(
    			'id'    => 'poster',
    			'type'  => 'upload',
    			'label' => __('Poster','mega'),
    			'desc'  => __('Add url image','mega'),
    			'aid'   => 'up_images_poster',
    			'ajax'  => false
    		),
    		array(
    			'id'      => 'backdrop',
    			'type'    => 'upload',
    			'label'   => __('Main Backdrop','mega'),
    			'desc'    => __('Add url image','mega'),
    			'aid'     => 'up_images_backdrop',
    			'prelink' => 'https://image.tmdb.org/t/p/w500',
    			'ajax'    => false
    		),
    		array(
    			'id'    => 'youtube_id',
    			'type'  => 'text',
    			'class' => 'small-text',
    			'label' => __('Video trailer','mega'),
    			'desc'  => __('Add id Youtube video','mega'),
    			'fdesc' => '[id_video_youtube]',
    			'double' => null,
    		),
    		array(
    			'type'    => 'heading',
    			'colspan' => 2,
    			'text'    => __('IMDb.com data','mega')
    		),
    		array(
    			'double' => true,
    			'id'     => 'imdbRating',
    			'id2'    => 'imdbVotes',
    			'type'   => 'text',
    			'label'  => __('Rating IMDb','mega'),
    			'desc'   => __('Average / votes','mega')
    		),
    		array(
    			'id'    => 'Rated',
    			'type'  => 'text',
    			'class' => 'small-text',
    			'double' => null,
    			'fdesc'	=> null,
    			'label' => __('Rated','mega')
    		),
    		array(
    			'id'     => 'Country',
    			'type'   => 'text',
    			'class'  => 'small-text',
    			'fdesc'	 => null,
    			'desc'	 => null,
    			'double' => null,
    			'label'  => __('Country','mega')
    		),
    		array(
    			'type'    => 'heading',
    			'colspan' => 2,
    			'text'    => __('Themoviedb.org data','mega')
    		),
    		array(
    			'id'     => 'idtmdb',
    			'type'   => 'text',
    			'class'  => 'small-text',
    			'fdesc'	 => null,
    			'desc'	 => null,
    			'double' => null,
    			'class'  => null,
    			'label'  => __('ID TMDb','mega')
    		),
    		array(
    			'id'     => 'original_title',
    			'type'   => 'text',
    			'class'  => 'small-text',
    			'fdesc'	 => null,
    			'double' => null,
    			'class'  => null,
    			'desc'   => null,
    			'label'  => __('Original title','mega')
    		),
    		array(
    			'id'     => 'tagline',
    			'type'   => 'text',
    			'class'  => 'small-text',
    			'fdesc'	 => null,
    			'double' => null,
    			'desc'   => null,
    			'label'  => __('Tag line','mega')
    		),
    		array(
    			'id'    => 'release_date',
    			'type'  => 'date',
    			'label' => __('Release Date','mega')
    		),
    		array(
    			'double' => true,
    			'id'     => 'vote_average',
    			'id2'    => 'vote_count',
    			'type'   => 'text',
    			'label'  => __('Rating TMDb'),
    			'desc'   => __('Average / votes','mega')
    		),
    		array(
    			'id'    => 'runtime',
    			'type'  => 'text',
    			'class' => 'small-text',
    			'label' => __('Runtime','mega')
    		),
    		array(
    			'id' => 'cast',
    			'type' => 'textarea',
    			'rows' => 5,
    			'upload' => false,
    			'label' => __('Cast','mega')
    		),
    		array(
    			'id'    => 'dir',
    			'type'  => 'text',
    			'label' => __('Director','mega')
    		)
    	);
$this->ViewMeta($options);
}


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function meta_tvshows(){
        // Nonce security
    	wp_nonce_field('_tvshows_nonce', 'tvshows_nonce');
		// Metabox options
    	$options = array(
    		array(
    			'id'            => 'ids',
    			'type'          => 'generator',
    			'style'         => 'style="background: #f7f7f7"',
    			'class'         => 'regular-text',
    			'placeholder'   => '1402',
    			'label'         => __('Generate data','mega'),
    			'desc'          => __('Generate data from <strong>themoviedb.org</strong>','mega'),
    			'fdesc'         => __('E.g. https://www.themoviedb.org/tv/<strong>1402</strong>-the-walking-dead','mega'),
    			'requireupdate' => true
    		),
    		array(
    			'id'     => 'clgnrt',
    			'type'   => 'checkbox',
    			'label'  => __('Seasons control','mega'),
    			'clabel' => __('I have generated seasons or I will manually','mega')
    		),
    		array(
    			'id'     => 'featured_post',
    			'type'   => 'checkbox',
    			'label'  => __('Featured Title','mega'),
    			'clabel' => __('Do you want to mark this title as a featured item?','mega')
    		),
    		array(
    			'type'    => 'heading',
    			'colspan' => 2,
    			'text'    => __('Images and trailer','mega')
    		),
    		array(
    			'id'    => 'poster',
    			'type'  => 'upload',
    			'label' => __('Poster','mega'),
    			'desc'  => __('Add url image','mega'),
    			'aid'   => 'up_images_poster',
    			'ajax'  => false
    		),
    		array(
    			'id'      => 'backdrop',
    			'type'    => 'upload',
    			'label'   => __('Main Backdrop','mega'),
    			'desc'    => __('Add url image','mega'),
    			'aid'     => 'up_images_backdrop',
    			'prelink' => 'https://image.tmdb.org/t/p/w500',
    			'ajax'    => false
    		),
    		array(
    			'id'    => 'youtube_id',
    			'type'  => 'text',
    			'class' => 'small-text',
    			'label' => __('Video trailer','mega'),
    			'desc'  => __('Add id Youtube video','mega'),
    			'fdesc' => '[id_video_youtube]'
    		),
    		array(
    			'type'    => 'heading',
    			'colspan' => 2,
    			'text'    => __('More data','mega')
    		),
    		array(

    			'id'    => 'imdb_id',
    			'type'  => 'text',
    			'class' => 'small-text',
    			'label' => __('ID IMDb','mega'),
    		),
    		array(
    			'id'    => 'original_name',
    			'type'  => 'text',
    			'class' => 'small-text',
    			'label' => __('Original Name','mega')
    		),
    		array(
    			'id'    => 'first_air_date',
    			'type'  => 'date',
    			'label' => __('Firt air date','mega')
    		),
    		array(
    			'id'    => 'last_air_date',
    			'type'  => 'date',
    			'label' => __('Last air date','mega')
    		),
    		array(
    			'double' => true,
    			'id'     => 'number_of_seasons',
    			'id2'    => 'number_of_episodes',
    			'type'   => 'text',
    			'label'  => __('Content total posted','mega'),
    			'desc'   => __('Seasons / Episodes','mega')
    		),
    		array(
    			'double' => true,
    			'id'     => 'imdbRating',
    			'id2'    => 'imdbVotes',
    			'type'   => 'text',
    			'label'  => __('Rating TMDb','mega'),
    			'desc'   => __('Average / votes','mega')
    		),
    		array(
    			'id'    => 'episode_run_time',
    			'type'  => 'text',
    			'class' => 'small-text',
    			'label' => __('Episode runtime','mega')
    		),
            array(
                'id'    => 'episode',
                'type'  => 'text',
                'class' => 'small-text',
                'label' => __('Last Episode','mega')
            ),
            array(
               'id'    => 'cast',
               'type'  => 'textarea',
               'rows'  => 5,
               'label' => __('Cast','mega')
           ),
            array(
               'id'    => 'creator',
               'type'  => 'text',
               'label' => __('Creator','mega')
           )
        );
    	$this->ViewMeta($options);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function meta_seasons(){
        // Nonce security
    	wp_nonce_field('_seasons_nonce', 'seasons_nonce');
	    // Metabox options
    	$options = array(
    		array(
    			'id'           => 'ids',
    			'id2'          => 'temporada',
    			'type'         => 'generator',
    			'style'        => 'style="background: #f7f7f7"',
    			'class'        => 'extra-small-text',
    			'placeholder'  => '1402',
    			'placeholder2' => '1',
    			'label'        => __('Generate data','mega'),
    			'desc'         => __('Generate data from <strong>themoviedb.org</strong>','mega'),
    			'fdesc'        => __('E.g. https://www.themoviedb.org/tv/<strong>1402</strong>-the-walking-dead/season/<strong>1</strong>/','mega'),
    			'requireupdate' => true
    		),
    		array(
    			'id'     => 'clgnrt',
    			'type'   => 'checkbox',
    			'label'  => __('Episodes control','mega'),
    			'clabel' => __('I generated episodes or add manually','mega')
    		),
    		array(
    			'id'    => 'serie',
    			'type'  => 'text',
    			'class' => 'regular-text',
    			'label' => __('Serie name','mega')
    		),
    		array(
    			'id'    => 'poster',
    			'type'  => 'upload',
    			'label' => __('Poster','mega'),
    			'desc'  => __('Add url image','mega'),
    			'aid'   => 'up_images_poster',
    			'ajax'  => false
    		),
    	);
    	$this->ViewMeta($options);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function meta_episodes(){
        // Nonce security
    	wp_nonce_field('_episodios_nonce','episodios_nonce');
	    // Metabox options
    	$options = array(
    		array(
    			'id'           => 'ids',
    			'id2'          => 'temporada',
    			'id3'          => 'episodio',
    			'type'         => 'generator',
    			'style'        => 'style="background: #f7f7f7"',
    			'class'        => 'extra-small-text',
    			'placeholder'  => '1402',
    			'placeholder2' => '1',
    			'placeholder3' => '2',
    			'label'        => __('Generate data','mega'),
    			'desc'         => __('Generate data from <strong>themoviedb.org</strong>','mega'),
    			'fdesc'        => __('E.g. https://www.themoviedb.org/tv/<strong>1402</strong>-the-walking-dead/season/<strong>1</strong>/episode/<strong>2</strong>','mega'),
    			'requireupdate' => true
    		),
    		array(
    			'id'    => 'episode_name',
    			'type'  => 'text',
    			'class' => 'regular-text',
    			'label' => __('Episode title','mega')
    		),
    		array(
    			'id'    => 'serie',
    			'type'  => 'text',
    			'class' => 'regular-text',
    			'label' => __('Serie name','mega')
    		),
    		array(
    			'id'      => 'backdrop',
    			'type'    => 'upload',
    			'label'   => __('Main Backdrop','mega'),
    			'desc'    => __('Add url image','mega'),
    			'aid'     => 'up_images_backdrop',
    			'prelink' => 'https://image.tmdb.org/t/p/w500',
    			'ajax'    => false
    		),
    	);
    	$this->ViewMeta($options);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function ViewMeta($options){
    	echo '<div id="loading_api"></div>';
    	echo '<div id="api_table"><table class="options-table-responsive dt-options-table"><tbody>';
    	new Doofields($options);
    	echo '</tbody></table></div>';
    }
}

new DDbmoviesMetaboxes;
