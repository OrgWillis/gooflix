<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

function TextTags($option ='', $data =''){
    $option = str_replace('{title}', $data, $option);
    return apply_filters('TextTags',$option, $data);
}

if (defined('XMLRPC_REQUEST')) {
    add_action('init', 'allow_cors_xml_rpc');
}

function allow_cors_xml_rpc(){
    header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Headers: Content-Type'); 
    return true;
}

# Codestar Framework
if(!function_exists('cs_framework_init') && !class_exists('CSFramework')) {
    get_template_part('inc/core/themes/codestar/cs-framework');
}

# Theme Setup
function theme_setup() {

    // Theme supports
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');

    // Menus
    $menus = array(
        // Main
        'header'  => __('Menu header','mega'),
        'footer'  => __('Menu footer','mega'),
    );
    // Register all Menus
    register_nav_menus($menus);

}
add_action('after_setup_theme', 'theme_setup');

# mofificando a Query Principal
function QueryFilter($query) {

    if ($query->is_search || $query->is_tax) {

        $tipo = array('tvshows','movies');

        $query->set('post_type', $tipo);

        $query->set('post_status', 'publish');

    }

    if (is_category()) {

        $tipo = array('movies');
        $query->set('post_type', $tipo );
    }
    return $query;
}

add_filter('posts_search', 'posts_search_example_type', 10, 2);

function posts_search_example_type($search, $query) {
    global $wpdb;

    if (isset($GLOBALS['wp']->query_vars['s'])) {
        $sql    = "
        or exists (
        select * from {$wpdb->postmeta} where post_id={$wpdb->posts}.ID
        and meta_key in ('original_name')
        and meta_value like %s
        )
        ";
        $like   = '%' . $wpdb->esc_like($query->query['s']) . '%';
        $search = preg_replace("#\({$wpdb->posts}.post_title LIKE [^)]+\)\K#",
            $wpdb->prepare($sql, $like), $search);
    }

    return $search;
}

if (!is_admin())add_filter('pre_get_posts', 'QueryFilter');

# Get Category
function list_category(){
    $args = array(
        'hide_empty'         => 0,
        'orderby'            => 'name',
        'order'              => 'ASC',
        'show_count'         => 0,
        'use_desc_for_title' => 0,
        'title_li'           => 0,
        'style'              => 'none',
        'echo'               => 0,
    );

    $categories = wp_list_categories($args);
    if ($categories) {
        printf( '<div class="cats itemSliderC owl-carousel">%s</div>', $categories);
    }
}

# Get return lista de Category 
function list_category_app(){
    $list_category = array();
    $args =  array(
        'orderby' => 'name',
        'order'   => 'ASC'
    );

    $category = get_categories($args);

    foreach ($category as $key) {
        $list_category[] = array(
            'name' => $key->name,
            'slug' => $key->slug
        );
    }
    return $list_category;
}

# Active class
function ActiveClass($type) {

    if (get_post_type() == $type)echo 'active';
}

# Date composer
function doo_date_compose($date = false , $echo = true){

    if(class_exists('DateTime')){
        $class = new DateTime($date);
        if($echo){
         echo $class->format(TIME);
     }else{
       return $class->format(TIME);
   }
}else{

    if ($echo) {
        echo $date; 
    }else{
      return $date;  
  }
}
}

# is true
function doo_is_true($option = false, $key = false){
    $option = cs_get_option($option);
    if(!empty($option) && in_array($key, $option)){
        return true;
    } else {
        return false;
    }
}

# is true
function is_true_string($option = false){
    $option = cs_get_option($option);
    if(!empty($option)){
        return 'true';
    } else {
        return 'false';
    }
}

# Echo translated text
function _d($text){
	echo translate($text,'mtms');
}


# Return Translated Text
function __d($text) {
	return translate($text,'mtms');
}

# is set
function doo_isset($data, $meta){
	return isset($data[$meta]) ? $data[$meta] : false;
}

#compose Page link
function formatData($date){

    $date = new DateTime($date);

    return $date->format('Y');
}

# Trailer / iframe
function trailer_iframe($id,$autoplay = '0') {
    if (!empty($id)) {
        if($autoplay != '0'){
            $autoplay = doo_is_true('playauto','ytb');
        }
        $val = str_replace(array("[","]",),array('<i'.'frame' .' class="rptss" src="https://www.youtube.com/embed/','?autoplay='.$autoplay.'&autohide=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></if'.'rame>',),$id);
        return $val;
    }
}

# Return Directory Image
function image($url){
	echo URI . $url;
}

# Return share facebook
function sharefacebook($url){

    echo 'https://www.facebook.com/sharer/sharer.php?u=' . $url;
}

# Return share twitter
function sharetwitter($url){

    echo 'https://twitter.com/home?status=' . $url;
}

# Return share whatsapp
function sharewhatsapp($url){

    echo 'https://api.whatsapp.com/send?text=' . $url;
}

# Return share imdb
function shareimdb($id){

    echo 'https://www.imdb.com/title/' . $id;
}

# Altera a messagem exibida quando atualiza a temporada ou Episodio
function updated_messages( $messages ) {
    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );

    $messages['seasons'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => __( 'Season Updated', 'mega' ),
    );

    $messages['episodes'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => __( 'Updated Episode', 'mega' ),
    );

    if ( $post_type_object->publicly_queryable ) {
        $view_link = '';
        $messages['seasons'][1] .= $view_link;
        $messages['episodes'][1] .= $view_link;

    }

    return $messages;
}

add_filter( 'post_updated_messages', 'updated_messages' );

# Remover Opções desnecessarias
function remove_row_actions( $actions ){

    if( get_post_type() === 'seasons' || get_post_type() === 'episodes'){
        unset( $actions['view'] ); // ver
        unset( $actions['inline hide-if-no-js'] ); // edicao rapida
    }
    return $actions;
}
add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );


# Remove o Botao de visualizar post
function remove_preview_button() {

    if( !is_admin() )
        return;
    if( get_post_type() === 'seasons' || get_post_type() === 'episodes'){

        $style = '';
        $style .= '<style type="text/css">';
        $style .= '#edit-slug-box, #minor-publishing-actions, #visibility, .num-revisions, .curtime';
        $style .= '{display: none; }';
        $style .= '</style>';

        echo $style;
    }
}

add_action( 'admin_head', 'remove_preview_button' );

# WordPress Dashboard
if(!function_exists('dashboard_count_types')){
    function dashboard_count_types() {
        $args = array(
            'public'   => true,
            '_builtin' => false
        );
        $output     = 'object';
        $operator   = 'and';
        $post_types = get_post_types( $args, $output, $operator );
        foreach ( $post_types as $post_type ) {
            $num_posts = wp_count_posts( $post_type->name );
            $num       = number_format_i18n( $num_posts->publish );
            $text      = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
            if ( current_user_can('edit_posts') ) {
                $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
                echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
            }
        }
    }
    add_action('dashboard_glance_items', 'dashboard_count_types');
}

# Formatar o Player 
function formatPlayer($post_id){

    $player       = get_post_meta($post_id, 'repeatable_fields', true);
    $typeArrayDub = false;
    $typeArrayLeg = false;

    if ($player) {

        foreach ($player as $field) {

            $title = ($field['idioma'] == 'dub') ? 'Dublado' : 'Legendado';

            if ($field['idioma'] == 'dub') {

                $typeArrayDub[] = array(

                    'title' => "{$title}",
                    'url'   => $field['url'],
                    'type'  => $field['select']
                ); 

            }elseif ($field['idioma'] == 'leg'){

                $typeArrayLeg[] = array(

                    'title' => "{$title}",
                    'url'   => $field['url'],
                    'type'  => $field['select']
                );
            }
        }

        $palyerArray  = array(
            'dub' => $typeArrayDub,
            'leg' => $typeArrayLeg,
        );

    }else{

        $palyerArray = false;
    }
    return $palyerArray;
}

# Formatar o Player 
function getPlayerArray($player){

    $status_serve  = cs_get_option('serve_default'); # verifica se servidor padrao foi ativado
    $type_serve    = cs_get_option('link_default','verystream'); # verifica qual servidor padrao foi escolhido
    $status_remove = cs_get_option('serve_remove'); # verifica se is pra remover o algum servidor
    $remove_type   = multiexplode(array(',',', '), cs_get_option('type_remove','dropbox')); # verifica quais servidores iram ser removidos
    $palyerArray = array();

    if ($player) {
        foreach ($player as $item => $value) {
            if (is_array($value)){
                foreach ($value as $key => $val) {
                # se o status for falso todos o player ficam a mostra
                    if (!$status_serve && !$status_remove) { 

                        $palyerArray[] = array(

                            'title' => $val['title'],
                            'url'   => $val['url'],
                            'type'  => $val['type']
                        );

                    } elseif ($status_serve && $val['type'] == $type_serve) {

                        $palyerArray[] = array(

                            'title' => $val['title'],
                            'url'   => $val['url'],
                            'type'  => $val['type']
                        );

                    } elseif ($status_remove && !in_array($val['type'], $remove_type)) { 

                        $palyerArray[] = array(

                            'title' => $val['title'],
                            'url'   => $val['url'],
                            'type'  => $val['type']
                        );
                    }
                }
            }
        }

    }else{

        return false;
    }

    return $palyerArray;
}

function  HtmlPlayer($query){

    $player = getPlayerArray($query);

    if ($player) {
        foreach ($player as $item => $value) {?>
            <div class="playerBtn <?php echo $value['type']; ?>" onclick="getPlayer('<?php echo $value['url']; ?>', '<?php echo $value['type']; ?>')">
                <?php echo $value['title']; ?>
            </div>
        <?php }
    }
}

# Glossary
function multiexplode($delimiters, $string){
    $ready  = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

# Add TV Post
function change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0]                 = __( 'TV Online', 'mega' );
    $submenu['edit.php'][5][0]  = __( 'TV channels', 'mega' );
    $submenu['edit.php'][10][0] = __( 'Add new TV channel', 'mega' );
}

function change_post_object() {
    global $wp_post_types;
    $labels                     = &$wp_post_types['post']->labels;
    $labels->name               = __( 'TV Online', 'mega' );
    $labels->singular_name      = __( 'TV Online', 'mega' );
    $labels->add_new            = __( 'Add new TV channel', 'mega' );
    $labels->add_new_item       = __( 'Add new TV channel', 'mega' );
    $labels->edit_item          = __( 'Edit channel', 'mega' );
    $labels->new_item           = __( 'TV Online', 'mega' );
    $labels->view_item          = __( 'view channel', 'mega' );
    $labels->search_items       = __( 'Search channels', 'mega' );
    $labels->not_found          = __( 'No TV Channel Found', 'mega' );
    $labels->not_found_in_trash = __( 'No Channel Found in Trash', 'mega' );
    $labels->all_items          = __( 'All TV channels', 'mega' );
    $labels->menu_name          = __( 'TV Online', 'mega' );
    $labels->name_admin_bar     = __( 'TV Online', 'mega' );
}
add_action( 'admin_menu', 'change_post_label' );
add_action( 'init', 'change_post_object' );

# Remove tags support from posts
function myprefix_unregister_tags() {
    unregister_taxonomy_for_object_type('post_tag', 'post');
    unregister_taxonomy_for_object_type('category', 'post');
    remove_post_type_support( 'post', 'editor');
}
add_action('init', 'myprefix_unregister_tags');

# Compose Image
function compose_image_option($key = false){
    if($logo = cs_get_option($key)){
        $image = wp_get_attachment_image_src($logo,'full');
        return doo_isset($image,0);
    }
}

# compose Page link
function compose_pagelink($key = false){
    if($page = cs_get_option($key)){
        return get_permalink($page);
    }
}

# Compose Ad Desktop or Mobile
function compose_ad($id){
    $add = get_option($id);
    $adm = get_option($id.'_mobile');
    if(wp_is_mobile() && $adm){
        return stripslashes($adm);
    }else{
        return stripslashes($add);
    }
}

# Main required ( Important )
require get_parent_theme_file_path('/inc/core/dbmvs/init.php');
require get_parent_theme_file_path('/inc/core/aplication/class.php');
require get_parent_theme_file_path('/inc/core/aplication/config.php');

# Main requires
require get_parent_theme_file_path('/inc/metafields.php');
require get_parent_theme_file_path('/inc/constants.php');
require get_parent_theme_file_path('/inc/assets.php');
require get_parent_theme_file_path('/inc/cache.php');
require get_parent_theme_file_path('/inc/metadata.php');
require get_parent_theme_file_path('/inc/metaplayer.php');
require get_parent_theme_file_path('/inc/admin-ajax.php');
require get_parent_theme_file_path('/inc/views.php');
require get_parent_theme_file_path('/inc/minify.php');
require get_parent_theme_file_path('/inc/seo.php');

# Main required ( ajax )
require get_parent_theme_file_path('/inc/ajax.php');

# Main required ( plugins )
require get_parent_theme_file_path('/inc/plugins/custom-menu/custom_walker.php');
require get_parent_theme_file_path('/inc/plugins/pagination.php');
require get_parent_theme_file_path('/inc/plugins/user.php');

# Main required ( includes )
require get_parent_theme_file_path('/inc/includes/slugs.php');

# Google Drive
require get_parent_theme_file_path('/inc/gdrive/class.gdrive.php');