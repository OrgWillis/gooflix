<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*
*/

# paginação
function pagination($type = 'posts') {

    global $wp_query, $post, $wpdb;

    if ($type === 'comments' && !get_option('page_comments')) return;

    if (!isset($page) && !isset($pages)) {

        if ($type === 'posts') {

            $page = get_query_var('paged');

            $posts_per_page = intval(get_query_var('posts_per_page'));

            $pages = intval(ceil($wp_query->found_posts / $posts_per_page));

        } else {

            $comments = $wpdb->get_var("

                SELECT COUNT(*)

                FROM $wpdb->comments

                WHERE comment_approved = '1'

                AND comment_parent = '0'

                AND comment_post_ID = $post->ID");



            $page = get_query_var('cpage');

            $comments_per_page = get_option('comments_per_page');

            $pages = intval(ceil($comments / $comments_per_page));

        }

        $page = !empty($page) ? intval($page) : 1;
    }

    $output = array();

    if ($pages > 1) {

        $current = $page;

        $max = 3;

        $end = $pages;

        $range = ($current + $max < $end) ? range($current, $current + $max) : range($current - ($current + $max - $end), $end);

        $output[] = '<div class="paginationSystem">';

        $range_start = max($page - $max, 1);

        $range_end = min($page + $max - 1, $pages);

        if ($page > 1) {

            $link = ($type === 'posts') ? get_pagenum_link($page - 1) : get_comments_pagenum_link($page - 1);

            $output[] = '<a class="item click" href="' . $link . '">&lt;</a>';

        }

        for ($i = 1; $i <= $end; $i++) {

            if ($i == 1 || $i == $end || in_array($i, $range)) {

                if ($i == $page) {

                    $output[] = '<a class="item click active">' . $i . '</a>';

                } else {

                    $link = ($type === 'posts') ? get_pagenum_link($i) : get_comments_pagenum_link($i);

                    $output[] = '<a class="item click" href="' . $link . '">' . $i . '</a>';

                }

            } else {

                $output[] = '#';

            }

        }

        if ($page < $pages) {

            $link = ($type === 'posts') ? get_pagenum_link($page + 1) : get_comments_pagenum_link($page + 1);

            $output[] = '<a class="item click" href="' . $link . '">&gt;</a>';

        }

        $output[] = '</div>';

        $output = preg_replace('/>#+</', '><', implode("", $output));

        echo $output;

    }

}