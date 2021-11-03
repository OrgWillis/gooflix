<?php
/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
class walker_header extends Walker_Nav_Menu{

  function start_el(&$output, $item, $depth=0, $args=array(),$current_object_id=0){
   global $wp_query;
 
  $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
  $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
  $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
  $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

  $item_output = $args->before;
  $item_output .= '<a class="hover item" '. $attributes .'>';
  $item_output .= $args->link_before.apply_filters( 'the_title', $item->title, $item->ID );
  $item_output .= $args->after.'</a>';

  $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
}

}