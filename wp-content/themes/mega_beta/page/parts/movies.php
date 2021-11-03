<?php $postmeta = postmeta_movies($post->ID); ?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Embed - <?php echo THEME_NAME; ?></title>
	<meta name="robots" content="noFollow">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<style type="text/css">
		:root {
			--darkbg: <?php echo cs_get_option('bgcolor', '#000000'); ?>;
			--orange: <?php echo cs_get_option('maincolor','#FF4900'); ?>;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="<?php echo URI, '/assets/css/embed.css'; ?>" />
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<style> body{background-image:url(<?php echo $postmeta['backdrop']; ?>);} </style>
</head>
<body>

	<div class="content">
		<div class="movieTitle"><?php echo $postmeta['title']; ?></div>

		<div class="playerList">
			<?php HtmlPlayer($postmeta['players']); ?>
		</div>

		<div class="activePlayerButtons">
			<div class="item" onclick="showMoviesPlayerList()">
				<?php _e('SHOW PLAYERS','mega'); ?>
			</div>
			<div class="logo">
			</div>
		</div>
		<div class="playerFrame">
		</div>

	</div>

	<script>

		function getIframe(url){
			return '<iframe src="'+url+'" scrolling="no" frameborder="0" allowfullscreen="" webkitallowfullscreen="" mozallowfullscreen=""></iframe>';
		}

		function getPlayer(id, type){
			if (id) {
				url = "<?php echo admin_url('admin-ajax.php');?>?action=modal&what=iframe&type="+type+"&id="+id;
				$(".playerFrame").append(getIframe(url)).addClass("active");
				$(".activePlayerButtons").addClass("active");
			}
		}

		function showMoviesPlayerList(){
			$(".activePlayerButtons").removeClass("active");
			$(".playerFrame").removeClass("active");
			$(".playerFrame iframe").remove();
		}
	</script>
</body>
</html>