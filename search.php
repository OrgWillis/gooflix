<?php get_header(); ?>

<div class="wrap" id="searchPage">
	<div class="searchBar">
		<input type="text" placeholder="<?php _e( 'Search for movies or tvshows','mega'); ?>" id="searchPageInput">
		<div class="gButton" onclick="homeSearchBar()">
			<?php get_template_part('assets/img/icone/search'); ?>
		</div>
	</div>
	<div class="generalMoviesList">

		<?php

		if (have_posts()) {

			while (have_posts()) : the_post();

				get_template_part('inc/template/getPost');

				if (strtolower(get_the_title()) == strtolower($GLOBALS['wp']->query_vars['s'])) {
					break;
				}

			endwhile;

		}else{ ?>

			<div class="noMovies">
				<?php _e( 'No results, please search again.','mega'); ?>
			</div>

		<?php } ?>

	</div>
</div>

<?php

pagination();

get_footer();