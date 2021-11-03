<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class DDbmoviesAdminPage extends DDbmoviesHelpers{

    /**
     * @since 1.0
     * @version 1.0
     */
    public function __construct(){
        add_action('admin_menu',array(&$this,'DbmvMenu'));
        add_action('after_setup_theme',array(&$this,'Setup'));
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function Setup(){
        // Dbmovies Options
        $settings = get_option(DBMOVIES_OPTIONS);
        $imdbdata = get_option(DBMOVIES_OPTIMDB);

        // Set Settings default
        if(!$settings){
            $data = array(
                'dbmovies'          => '',
                'themoviedb'        => DBMOVIES_TMDBKEY,
                'language'          => 'pt-BR',
                'upload'            => 0,
                'genres'            => 1,
                'release'           => 1,
                'autoscroll'        => 1,
                'repeated'          => 0,
                'safemode'          => 0,
                'autoscrollresults' => '200',
                'delaytime'         => '1000',
                'titlemovies'       => '{name}',
                'titletvshows'      => '{name}',
                'titleseasons'      => __('{name}: Season {season}','mega'),
                'titlepisodes'      => '{name}: {season}x{episode}',
                'request-email'     => '',
                'requestsunk'       => 0,
                'reqauto-adm'       => 1,
                'reqauto-edi'       => 1,
                'reqauto-aut'       => 1,
                'reqauto-con'       => 1,
                'reqauto-sub'       => 1,
                'reqauto-unk'       => 0,
                'phptimelimit'      => '300',
                'phpmemorylimit'    => '256',
                'orderseasons'      => 'ASC',
                'orderepisodes'     => 'ASC',
                'pstatusmovies'     => 'publish',
                'pstatustvshows'    => 'publish',
                'pstatusseasons'    => 'publish',
                'pstatusepisodes'   => 'publish',
                'gutenberg-movies'  => 1,
                'gutenberg-tvshows' => 1,
                'gutenberg-seasons' => 1,
                'gutenberg-episode' => 1,
                'gutenberg-links'   => 1,
            );
            // Update Option
            update_option(DBMOVIES_OPTIONS, $data);
        }

        // Set IMDb Data
        if(!$imdbdata){
            $data = array(
                'time' => time(),
                'page' => '1'
            );
            // Update Option
            update_option(DBMOVIES_OPTIMDB, $data);
        }
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function DbmvMenu(){
        add_menu_page( __('Dbmovies','mega'), __('Dbmovies','mega'), 'manage_options', 'dbmvs', array(&$this,'DbmvApp'), 'dashicons-upload');
        add_submenu_page('dbmvs', __('Dbmovies - Settings','mega'), __('Settings','mega').$this->PendingNotice(), 'manage_options', 'dbmvs-settings',array(&$this,'DbmvSettings'));
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function DbmvApp(){
        require_once(DBMOVIES_DIR.'/tpl/admin_app.php');
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function DbmvSettings(){
        require_once(DBMOVIES_DIR.'/tpl/admin_settings.php');
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function PendingNotice(){
        if(empty($this->get_option('dbmovies')) || empty($this->get_option('themoviedb'))){
            return "<span class='awaiting-mod' style='margin-left:10px'><span class='pending-count'>1</span></span>";
        }
    }

}

new DDbmoviesAdminPage;
