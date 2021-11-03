<?php 
get_header();
?>

<div class="wrap" id="listingPage">
    <div class="titleBar">
        <h1><?php _e('Watch Category','mega'); ?>: <b><?php single_cat_title() ?></b></h1>
    </div>
    <div class="generalMoviesList">

        <?php

        if (have_posts()) :

            while (have_posts()) : the_post();

                get_template_part('inc/template/getPost');

            endwhile;

        endif;

        ?>

    </div>
</div>

<?php 

pagination(); 

get_footer();
