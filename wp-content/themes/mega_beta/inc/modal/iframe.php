 <?php 

 $type = (isset($_GET['type'])) ? $_GET['type'] : null;
 $id   = (isset($_GET['id'])) ? $_GET['id'] : null;

 if (cs_get_option('ads_mode')) {

 	$url = cs_get_option('ads_link','https://exemplo.com/')."?type={$type}&id={$id}";
 	adsMode($url);

 }else{
 	
 	switch ($type) {
 		case 'verystream':
 		$url = cs_get_option('linkverystream','https://verystream.com/e/').$id;
 		break;
 		case 'openload':
 		$url = cs_get_option('linkopenload','https://oload.tv/embed/').$id;
 		break;
 		case 'thevid':
 		$url = cs_get_option('linkverystream','https://thevid.tv/e/').$id;
 		break;
 		case 'fembed':
 		$url = cs_get_option('linkfembed','https://www.fembed.com/v/').$id;
 		break;
 		default:
 		$url =  $id;
 		break;
 	}

 	iframeMode($url);
 }

 function adsMode($url) { ?>

 	<html class="no-js" <?php language_attributes(); ?>>
 	<head>
 		<meta charset="utf-8" />
 		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
 		<title>Embed - Mega HD Filmes</title>
 		<meta name="robots" content="noFollow">
 		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
 		<link rel="stylesheet" type="text/css" href="<?php echo URI, '/assets/css/ads_mode.css'; ?>" />

 	</head>
 	<body>
 		<div class="box">
 			<div class="title">
 				ATENÇÃO
 			</div>
 			<div class="buttons" id="list">
 				<a href="<?php echo $url; ?>" target="_blank">
 					<div id="playButton">
 						<?php get_template_part('assets/img/icone/button-click'); ?>
 					</div>
 				</a>
 			</div>
 			<div class="text" id="text">
 				Para uma melhor experiência o <span>video</span> será carregado em uma nova aba!
 			</div>
 		</div>
 	</body>
 	</html>

 <?php } function iframeMode($url) { ?>

 	<!doctype html>
 	<html lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
 	<style>

 		body,html{
 			padding:0;
 			left: 0;
 		}
 		iframe{
 			position: fixed;
 			top: 0px;
 			left: 0px;
 			width: 100%;
 			height: 100%;
 		}

 	</style>
 </head>
 <body>
 	<script>

 		if (top.location == self.location) {
 			top.location = "<?php echo esc_url(home_url()); ?>"
 		}else{
 			window.location.href="<?php echo $url; ?>";
 		}

 	</script>
 </body>
 </html>
 <?php } ?>