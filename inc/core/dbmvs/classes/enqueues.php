<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class DDbmoviesEnqueues extends DDbmoviesHelpers{

    /**
     * @since 1.0
     * @version 1.0
     */
    public function __construct(){
        add_action('admin_enqueue_scripts', array(&$this,'Enqueues'));
    }


    /**
     * @since 1.0
     * @version 3.0
     */
    public function Enqueues(){
        $parameters = array(
            'dapikey' => $this->get_option('dbmovies'),
            'tapikey' => $this->get_option('themoviedb',DBMOVIES_TMDBKEY),
            'apilang' => $this->get_option('language','en-US'),
            'extimer' => $this->get_option('delaytime','500'),
            'rscroll' => $this->get_option('autoscrollresults','200'),
            'inscrll' => $this->get_option('autoscroll'),
            'safemod' => $this->get_option('safemode'),
            'csectin' => $this->Disset($_GET,'section'),
            'gerepis' => $this->Disset($_GET,'generate_episodes'),
            'ajaxurl' => admin_url('admin-ajax.php','relative'),
            'dapiurl' => esc_url(DBMOVIES_DBMVAPI),
            'tapiurl' => esc_url(DBMOVIES_TMDBAPI),
            'prsseng' => __('Processing..','mega'),
            'dbmverr' => __('Our services are out of line, please try again later','mega'),
            'tmdberr' => __('The title does not exist or resources are not available at this time','mega'),
            'misskey' => __('You have not added an API key for Dbmovies','mega'),
            'loading' => __('Loading..','mega'),
            'loadmor' => __('Load More','mega'),
            'import'  => __('Import','mega'),
            'save'    => __('Save','mega'),
            'savech'  => __('Save Changes','mega'),
            'saving'  => __('Saving..','mega'),
            'uerror'  => __('Unknown error','mega'),
            'nerror'  => __('Connection error','mega'),
            'aerror'  => __('Api key invalid or blocked','mega'),
            'nocrdt'  => __('There are not enough credits to continue','mega'),
            'complt'  => __('Process Completed','mega'),
            'welcom'  => __('Service started','mega')
        );

        // All Scripts
        wp_enqueue_style('front-style', DBMOVIES_URI.'/assets/front.style.css', array(), DBMOVIES_VERSION);
        wp_enqueue_script('front-scripts', DBMOVIES_URI.'/assets/front.scripts.js', array('jquery'), DBMOVIES_VERSION);

        wp_enqueue_style('dbmovies-app', DBMOVIES_URI.'/assets/dbmovies.min.css', array(), DBMOVIES_VERSION);
        wp_enqueue_script('dbmovies-app', DBMOVIES_URI.'/assets/dbmovies.min.js', array('jquery'), DBMOVIES_VERSION);
        wp_localize_script('dbmovies-app', 'dbmovies', $parameters);
    }

}


new DDbmoviesEnqueues;
