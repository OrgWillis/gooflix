<?php $postmeta = postmeta_tvshows($post->ID);?>
<!doctype html>
<html class="no-js" lang="en">
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
	<?php if (!isset($_GET['p'])){?><style> body{background-image:url(<?php echo $postmeta['backdrop']; ?>);} </style><?php }?>
</head>
<body>
	<div class="content">

		<?php if (!isset($_GET['p'])){?><div class="movieTitle"><?php echo $postmeta['title']; ?></div><?php }?>

		<div class="selectorBox">

			<div class="preTitT">
				Escolha uma temporada
			</div>
			<div class="seasonList">

				<?php foreach ($postmeta['seasons'] as $key => $value) {?>

					<div data-season-id="<?php echo $value['id']; ?>" class="item" onclick="getEpisodeList(<?php echo $value['id']; ?>, '<?php echo $postmeta['tmdb']; ?>', <?php echo $value['seasons']; ?>)">
						<?php echo $value['seasons']; ?> 
					</div>

				<?php } ?>

			</div>
			<br>

			<div class="preTit" id="seasonPreTit">
				
			</div>

			<div class="episodeList" id="episodeList">

			</div>

		</div>
		<div class="activePlayerButtons">
			<div class="item" onclick="showMoviesPlayerList()">
				MOSTRAR PLAYERS
			</div>
			<a id="downloadBtn" href="" target="_BLANK" class="item down">
				BAIXAR
			</a>
		</div>
		<div class="playerFrame">
		</div>
	</div>
	<script>

		function getIframe(url){
			return '<iframe src="'+url+'" scrolling="no" frameborder="0" allowfullscreen="" webkitallowfullscreen="" mozallowfullscreen=""></iframe>';
		}

		function getPlayer(id, type){
			down = '';
			switch(type){
				case 'fembed':
				down = '<?php echo cs_get_option('linkfembed','https://www.fembed.com/f/'); ?>' + id;
				break;
				case 'verystream':
				down = '<?php echo cs_get_option('linkverystream','https://verystream.com/stream/'); ?>' + id;
				break;
				default:
				down = id;
				break;
			}
			if (id) {
				url = "<?php echo admin_url('admin-ajax.php');?>?action=modal&what=iframe&type="+type+"&id="+id;
				$(".playerFrame").append(getIframe(url)).addClass("active");
				$(".activePlayerButtons").addClass("active");
				$("#downloadBtn").attr("href", down);
			}
		}

		function showMoviesPlayerList(){
			$(".activePlayerButtons").removeClass("active");
			$(".playerFrame").removeClass("active");
			$(".playerFrame iframe").remove();
		}

		function getEpisodeList(ids,tmdb, season){
			$(".seasonList .item").removeClass("active");
			$('[data-season-id="'+ids+'"]').addClass("active");
			$.ajax({
				method: "GET",
				url: "<?php echo rest_url('api/'); ?>tvshows",
				data: { 
					what   : 'epsodes',
					tmdb   : tmdb,
					season : season
				},
				success: function (data) {

					if (data.status == "success") {
						var $list = $("#episodeList");
						$list.fadeOut();
						$list.empty();
						$("#seasonPreTit").html(season+'º Temporada <br> Escolha um episódio');
						$.each(data.episodes, function (index, row) {
							var players = "";
							$.each(row.player, function (index, player) {
								players = players + '<div class="item" onclick="getPlayer(\''+player.url+'\', \''+player.type+'\')">'+player.title+'</div>';
							});
							$list.append('<div class="row"><div class="epTitle">'+row.ep+'º Episódio</div><div class="buttons">'+players+'</div></div>');
						});
						$list.fadeIn();
					}else{return false;}
				}
			});
		}

	</script>
</body>
</html>
