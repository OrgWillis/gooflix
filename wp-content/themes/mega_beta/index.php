<?php get_header(); ?>

<div id="mainLauncher">

	<?php 

	$args = array(
		'post_type'   => array('movies'),
		'post_status' => 'publish',
		'showposts'   => 1,
		'meta_query'  => array (
			array (
				'key'     => 'featured_post',
				'value'   => '1',
				'compare' => 'LIKE'
			)
		)
	);

	$list_query = get_posts($args);

	if (count($list_query)) {
		foreach ($list_query as $post) { 

			$postmeta    = postmeta_movies($post->ID);
			// Movies Meta data
			$title       = doo_isset($postmeta, 'title');
			$img         = doo_isset($postmeta, 'poster');
			$permalink   = doo_isset($postmeta, 'permalink');
			$description = doo_isset($postmeta, 'description');
			$backdrop    = doo_isset($postmeta, 'backdrop');
			$time        = doo_isset($postmeta, 'runtime');
			$rating_imdb = doo_isset($postmeta, 'imdbRating');
			$year        = doo_isset($postmeta, 'year');
			$youtube     = doo_isset($postmeta, 'youtube_id');

			?>

			<style>
				#mainLauncher .background{ background-image: url(<?php echo $backdrop; ?>); }
			</style>
			<div class="background"></div>
			<div class="hover"></div>
			<div class="wrap">
				<div class="moviePresent">
					<span class="runtime">
						<?php printf(__( 'Movies Online - Duration: %s', 'mega' ), $time); ?>
					</span>
					<div class="infos">
						<div class="rating">
							<?php get_template_part('assets/img/icone/rating'); ?>
							<?php echo $rating_imdb; ?>
							<div class="of">/10</div>
						</div>
						<div class="year">
							<?php printf(__( 'Movie from <b>%s</b>', 'mega' ), $year); ?>
						</div>
					</div>
					<h3><?php echo $title; ?></h3>
					<p>
						<?php echo $description; ?>
					</p>
					<div class="buttons">
						<a href="<?php echo $permalink; ?>" class="gButton red iconized" title="Assistir <?php echo $title; ?> Online Gratis">
							<?php get_template_part('assets/img/icone/button-red'); ?>
							<?php _e('Watch Free Movie', 'mega'); ?>
						</a>
						<span class="gButton iconized" data-open-trailer="<?php echo $youtube; ?>">
							<?php get_template_part('assets/img/icone/button-red'); ?>
							<?php _e('Trailer','mega'); ?>
						</span>
					</div>
				</div>
			</div>

			<?php 	
		}
	} 
	?>
</div>

<div id="listingHome">
	<div class="wrap">
		<div class="options">
			<span class="item active" data-get-slider-movies="launch">
				<?php get_template_part('assets/img/icone/rating'); ?>
				<?php _e('Mega Launch', 'mega'); ?>
			</span>
			<span class="item" data-get-slider-movies="recent">
				<?php get_template_part('assets/img/icone/recent'); ?>
				<?php _e('Mega Recent', 'mega'); ?>
			</span>
			<span class="item" data-get-slider-movies="recommend">
				<?php get_template_part('assets/img/icone/recommend'); ?>
				<?php _e('Mega Recommended', 'mega'); ?>
			</span>
			<span class="item" data-get-slider-movies="views">
				<?php get_template_part('assets/img/icone/views'); ?>
				<?php _e('Most Watched', 'mega'); ?>
			</span>
		</div>
	</div>
	<div class="itemsList">
		<div class="left slideNav"><i><div class="line"></div><div class="line"></div></i></div>
		<div class="right slideNav"><i><div class="line"></div><div class="line"></div></i></div>
		<div class="list itemSlider owl-carousel" id="homeSliderList">
		</div>
	</div>
	<div class="wrap">
		<div id="lastHome">
			<h1><?php _e('NAVIGATE FOR THE CATEGORY YOU LIKE MOST!','mega'); ?></h1>
			<?php list_category(); ?>
		</div>
	</div>
</div>

<?php 
get_footer();