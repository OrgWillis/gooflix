<?php 
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*
*/
function add_meta_tags() {
	global $post;
	$description = cs_get_option('seodescription');
	$seokeywords = cs_get_option('seokeywords');
	$seoimage    = compose_image_option('seoimage');

	if(is_home()) {  ?>
		<?php if($description) { ?>
			<meta name="description" content="<?php echo $description; ?>"/>
		<?php } if($seokeywords) { ?>
			<meta name="keywords" content="<?php echo $seokeywords; ?>"/>
			<!-- SEO  Facebook -->
		<?php } if($seoimage) { ?>
			<meta name="og:image" content="<?php echo $seoimage; ?>"/>
			<meta property="og:locale" content="<?php echo LANG; ?>" />
			<meta property="og:site_name" content="<?php echo THEME_NAME; ?>" />
		<?php } if($description) { ?>
			<meta property="og:description" content="<?php echo $description; ?>" />
		<?php } ?>
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo URL; ?>" />
		<!-- End SEO  Facebook -->
		<!-- SEO  Twitter -->
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:site" content="<?php echo URL; ?>" />
		<meta name="twitter:title" content="<?php echo $description; ?>" />
		<?php  if($description) { ?>
			<meta name="twitter:description" content="<?php echo $description; ?>" />
		<?php } if($seoimage) { ?>
			<meta name="twitter:image" content="<?php echo $seoimage; ?>" />
		<?php }  ?>
		<!-- End SEO  Twitter -->
	<?php }

	if(cs_get_option('seo') == "true") {
		if( $info = cs_get_option('seogooglev') ) { ?>
			<meta name="google-site-verification" content="<?php echo $info; ?>" />
		<?php } if( $info = cs_get_option('seobingv') ) { ?>
			<meta name="msvalidate.01" content="<?php echo $info; ?>" />
		<?php } if( $info = cs_get_option('seoyandexv') ) { ?>
			<meta name='yandex-verification' content="<?php echo $info; ?>" />
		<?php } if(is_single()) { 
			$title         = get_the_title();
			$descriptionFB = TextTags(cs_get_option('descriptionfb'), $title);
			$descriptionTW = TextTags(cs_get_option('descriptiontw'), $title);
			$image         = return_get_poster($post->ID, 'poster', 'w600_and_h900_bestv2');
			?>
			<meta name="description" content="<?php echo $descriptionFB; ?>"/>
			<!-- SEO  Facebook -->
			<meta property="og:type" content="website" />
			<meta property="og:title" content="<?php $title; ?>" />
			<meta property="og:locale" content="<?php echo LANG; ?>" />
			<meta property="og:type" content="website" />
			<meta property="og:site_name" content="<?php echo THEME_NAME; ?>" />
			<meta property="og:description" content="<?php echo $descriptionFB; ?>" />
			<meta property="og:image" content="<?php echo $image; ?>" />
			<meta property="og:url" content="<?php echo $title; ?>" />
			<!-- End SEO  Facebook -->
			<!-- SEO  Twitter -->
			<meta name="twitter:card" content="summary" />
			<meta name="twitter:site" content="<?php the_permalink() ?>" />
			<meta name="twitter:title" content="<?php echo $title; ?>" />
			<meta name="twitter:description" content="<?php echo $descriptionTW; ?>" />
			<meta name="twitter:image" content="<?php echo $image; ?>" />
			<!-- End SEO  Twitter -->
			<?php
		} 
	} 
}

add_action('wp_head', 'add_meta_tags');