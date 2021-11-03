<?php 

// All Postmeta
$postmeta = postmeta_tvshows($post->ID);

// Movies Meta data
$title          = doo_isset($postmeta, 'title');
$description    = doo_isset($postmeta, 'description');
$img            = doo_isset($postmeta, 'poster');
$permalink      = doo_isset($postmeta, 'permalink');
$rating_imdb    = doo_isset($postmeta, 'imdbRating');
$year           = doo_isset($postmeta, 'year');
$time           = doo_isset($postmeta, 'runtime');
$category       = doo_isset($postmeta, 'category');
$original_title = doo_isset($postmeta, 'original');
$cast           = doo_isset($postmeta, 'dir');
$dir            = doo_isset($postmeta, 'creator');
$player         = doo_isset($postmeta, 'players');
$imdb         	= doo_isset($postmeta, 'imdb');

?>
<main id="moviePage">
	<div class="background"></div>
	<div class="hover"></div>
	<div class="wrap">
		<div class="moviePresent">
			<span class="runtime">
				<?php printf(__( 'TVShow Online - Duration: %s', 'mega' ), $time); ?>
				<div class="infos">
					<div class="rating">
						<a href="<?php echo shareimdb($imdb); ?>" target="_BLANK">
							<?php get_template_part('assets/img/icone/rating'); ?>
						</a>
						<?php echo $rating_imdb; ?>
						<div class="of">/10</div>
					</a>
				</div>
				<div class="year">
					<?php printf(__( 'TVshows from <b>%s</b>', 'mega' ), $year); ?>
				</div>
			</div>
			<h2 class="tit"><?php echo $title; ?></h2>
			<p><?php echo $description; ?></p>

			<div class="genres">
				<?php echo get_modified_term_list($post->ID, 'category'); ?>
			</div>

			<span class="prod"><?php _e('Original title','mega'); ?>: <h4><b><?php echo $original_title; ?></b></h4></span>
			<span class="prod"><?php _e('Director','mega'); ?>: <b><?php echo $dir; ?></b></span>
			<span class="prod"><?php _e('Cast','mega'); ?>: <b><?php echo $cast; ?></b></span>
		</div>
		<div id="playButton" class="click" onclick="showPlayerList();">
			<?php get_template_part('assets/img/icone/button-click'); ?>
		</div>
		<div id="playerArea">
			<div id="playerIframe">
			</div>
			<div class="list">
				<iframe src="<?php echo compose_pagelink('pageaembed'); ?>?type=tvshows&imdb=<?php echo $imdb; ?>&p=yes"></iframe>
			</div>
			<div class="gButton closeButton" onclick="closePlayerList()">
				<?php get_template_part('assets/img/icone/button-close'); ?>
			</div>
		</div>
	</div>

</div>
</main>

<div class="clearfix"></div>

<div class="extraData">
	<div class="wrap">
		<div class="gTitle"><?php _e('Related TVshows','mega'); ?></div>
	</div>
	<div class="itemsList">
		<div class="left slideNav"><i><div class="line"></div><div class="line"></div></i></div>
		<div class="right slideNav"><i><div class="line"></div><div class="line"></div></i></div>
		<div class="list itemSlider owl-carousel" id="homeSliderList">

		</div>
	</div>
	<div class="clearfix"></div>
	<div class="wrap">
		<div id="socials">
			<span><?php _e('Liked? Share with your friends!','mega'); ?></span>
			<a target="_BLANK" href="<?php echo sharefacebook($permalink); ?>" class="facebook click" title="compartilhar no facebook" rel="nofollow">
				<?php get_template_part('assets/img/icone/facebook'); ?>
			</a>
			<a target="_BLANK" href="<?php echo sharetwitter($permalink); ?>" class="twitter click" title="compartilhar no Twitter" rel="nofollow">
				<?php get_template_part('assets/img/icone/twitter'); ?>
			</a>

			<a target="_BLANK" href="<?php echo sharewhatsapp($permalink); ?>" class="whatsapp click" title="compartilhar no Whatsapp" rel="nofollow">
				<?php get_template_part('assets/img/icone/whatsapp'); ?>
			</a>

		</div>
	</div>
	<div class="clearfix"></div>
</div>