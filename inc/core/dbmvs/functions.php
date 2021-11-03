<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/


/**
 * @since 1.0
 * @version 1.0
 */
function return_get_poster($post_id = '', $post_meta = 'poster', $size = 'w185'){

    $image_meta = get_post_meta($post_id, $post_meta,true);

    if($image_meta && $image_meta != 'null'){

        if(substr($image_meta, 0, 1) == '/'){

            $poster = 'https://image.tmdb.org/t/p/'.$size.$image_meta;

        }elseif(filter_var($image_meta, FILTER_VALIDATE_URL) && getimagesize($image_meta)){

            $poster = $image_meta;
        }

    }else{

       $poster   = URI .'/assets/img/no/no_poster.png'; 
   }

   return esc_url($poster);
}

/**
 * @since 1.0
 * @version 1.0
 */
function runtime($minutes){
    $time  = floor($minutes/60);
    $rest  = $minutes%60;
    return $time.'h, '. $rest . 'min';
}

 /**
 * @since 1.0
 * @version 1.0
 */

 function return_term_list($post, $term = '') {

    $terms = get_modified_term_list($post, $term, '', ', ');

    $terms = strip_tags($terms);

    return $terms;

}

 /**
 * @since 1.0
 * @version 1.0
 */

 function get_modified_term_list( $id = 0, $taxonomy, $before = '', $sep = '', $after = '', $exclude = array() ) {

    $terms = get_the_terms( $id, $taxonomy );

    if ( is_wp_error( $terms ) ) return $terms;

    if ( empty( $terms ) )  return false;

    foreach ( $terms as $term ) {

        if(!in_array($term->slug,$exclude)) {

            $link = get_term_link( $term, $taxonomy );

            if ( is_wp_error( $link ) ) return $link;

            $term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . '</a>';

        }
    }

    if( !isset( $term_links ) ) return false;

    return $before . join( $sep, $term_links ) . $after;
}

  /**
 * @since 1.0
 * @version 1.0
 */
  function dbmovies_get_backdrop($post_id = '', $size = 'w500'){
    $image_meta = get_post_meta($post_id,'dt_backdrop',true);
    $backdrop = DOO_URI.'/assets/img/no/dt_backdrop.png';
    if($image_meta && $image_meta != 'null'){
        if(substr($image_meta, 0, 1) == '/'){
            $backdrop = 'https://image.tmdb.org/t/p/'.$size.$image_meta;
        }elseif(filter_var($image_meta, FILTER_VALIDATE_URL) && getimagesize($image_meta)){
            $backdrop = $image_meta;
        }
    }
    return esc_url($backdrop);
}



/**
 * @since 1.0
 * @version 1.0
 */
function dbmovies_get_images($data = ''){
    if($data){
        $ititle = get_the_title();
        $images = explode("\n", $data);
        $icount = 0;
        $out_html = "<div id='dt_galery' class='galeria'>";
        foreach($images as $image) if($icount < 10){
            if(!empty($image)){
                if(substr($image, 0, 1) == '/'){
                    $out_html .= "<div class='g-item'>";
                    $out_html .= "<a href='https://image.tmdb.org/t/p/original{$image}' title='{$ititle}'>";
                    $out_html .= "<img src='https://image.tmdb.org/t/p/w300{$image}' alt='{$ititle}'>";
                    $out_html .= "</a></div>";
                }elseif(filter_var($image, FILTER_VALIDATE_URL) && getimagesize($image)){
                    $out_html .= "<div class='g-item'>";
                    $out_html .= "<a href='{$image}' title='{$ititle}'>";
                    $out_html .= "<img src='{$image}' alt='{$ititle}'>";
                    $out_html .= "</a></div>";
                }
            }
            $icount++;
        }
        $out_html .= "</div>";
        // The View
        echo $out_html;
    }
}


/**
 * @since 1.0
 * @version 1.0
 */
function dbmovies_get_rand_image($data = ''){
    if($data){
        $urlimg = '';
        $images = explode("\n", $data);
        $icount = array_rand($images);
        if(!empty($images[$icount])){
            $image = $images[$icount];
        }else{
            $image = $images[0];
        }
        if(substr($image, 0, 1) == '/'){
            $urlimg = 'https://image.tmdb.org/t/p/original'.$image;
        }elseif(filter_var($image,FILTER_VALIDATE_URL) && getimagesize($image)){
            $urlimg = $image;
        }
        if(!empty($urlimg)){
            return esc_url($urlimg);
        }
    }
}


/**
 * @since 1.0
 * @version 1.0
 */
function dbmovies_title_tags($option, $data){
    $option = str_replace('{name}', doo_isset($data,'name'),$option);
    $option = str_replace('{year}', doo_isset($data,'year'),$option);
    $option = str_replace('{season}', doo_isset($data,'season'),$option);
    $option = str_replace('{episode}', doo_isset($data,'episode'),$option);
    return apply_filters('dbmovies_title_tags',$option);
}
