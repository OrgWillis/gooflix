<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

if(!class_exists('DDbmovies')){
    class DDbmovies{

        /**
         * @since 1.0
         * @version 1.0
         */
        public function __construct(){
            $this->Init();
        }


        /**
         * @since 1.0
         * @version 1.0
         */
        public function Init(){

            // Defined Constants
            define('DBMOVIES_VERSION','1.0');
            define('DBMOVIES_OPTIONS','_dbmovies_settings');
            define('DBMOVIES_OPTIMDB','_dbmovies_imdbdata');
            define('DBMOVIES_DBMVCDN','https://cdn.dbmvs.com');
            define('DBMOVIES_DBMVAPI','https://api.dbmvs.com');
            define('DBMOVIES_TMDBAPI','https://api.themoviedb.org/3');
            define('DBMOVIES_TMDBKEY','05902896074695709d7763505bb88b4d');

            // Locale Path
            $local = $this->Locale_path();

            define('DBMOVIES_DIR', $local['dir']);
            define('DBMOVIES_URI', $local['uri']);
            define('DBMOVIES_BAS', $local['bas']);

            // Actions
            add_action('load-edit.php', array(&$this,'AdminFilters'));
            add_action('post.php', array(&$this,'SeasonEpisodeGen'));

            // Application files
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/helpers.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/enqueues.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/importers.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/filters.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/client.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/ajax.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/adminpage.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/epsemboxes.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/metaboxes.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/saveposts.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/postypes.php');
            require get_parent_theme_file_path('/inc/core/dbmvs/classes/tables.php');
    
            // Application Functions
            require get_parent_theme_file_path('/inc/core/dbmvs/functions.php');
        }

        /**
         * @since 1.0
         * @version 1.0
         */
        private function Locale_path(){
            $dirname        = wp_normalize_path( dirname( __FILE__ ) );
            $plugin_dir     = wp_normalize_path( WP_PLUGIN_DIR );
            $located_plugin = ( preg_match( '#'. preg_replace( '/[^A-Za-z]/', '', $plugin_dir ) .'#', preg_replace( '/[^A-Za-z]/', '', $dirname ) ) ) ? true : false;
            $directory      = ( $located_plugin ) ? $plugin_dir : get_template_directory();
            $directory_uri  = ( $located_plugin ) ? WP_PLUGIN_URL : get_template_directory_uri();
            $basename       = str_replace( wp_normalize_path( $directory ), '', $dirname );
            $dir            = $directory.$basename;
            $uri            = $directory_uri.$basename;
            $all_path = array(
                'bas' => wp_normalize_path($basename),
                'dir' => wp_normalize_path($dir),
                'uri' => $uri
            );
            return apply_filters('dbmvs_get_path_locate',$all_path);
        }


        /**
         * @since 1.0
         * @version 1.0
         */
        public function AdminFilters(){
            $screen = get_current_screen();
            switch($screen->id) {
                case 'edit-movies':
                    add_action('in_admin_footer', function(){
                        require_once(DBMOVIES_DIR.'/tpl/import_movies.php');
                    });
                    break;

                case 'edit-tvshows':
                    add_action('in_admin_footer', function(){
                        require_once(DBMOVIES_DIR.'/tpl/import_tvshows.php');
                        require_once(DBMOVIES_DIR.'/tpl/import_seaepis.php');
                    });
                    break;

                case 'edit-seasons':
                    add_action('in_admin_footer', function(){
                        require_once(DBMOVIES_DIR.'/tpl/import_seaepis.php');
                    });
            }
        }
    }
    new DDbmovies;
}
