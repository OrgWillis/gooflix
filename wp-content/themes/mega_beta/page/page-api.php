<?php 

/*

Template Name: Page API

*/
get_header();

$url = compose_pagelink('pageaembed');

?>

<main class="wrap miniPage">
	<h1><?php echo THEME_NAME; ?> BETA <div class="col">API</div></h1>
	<div class="text">
		<h3>API de informações</h3>
		<div class="inner">
			<span>O <strong><?php echo THEME_NAME; ?></strong> conta com uma api de pesquisa de informações do IMDB que responde em formato json dados de filmes e series postados.</span><br>
			<span>Incluindo poster, wallpaper, trailer, descrição, titulo, players (Dublado e Legendado) e muitas outras informações. </span><br>
			<span>Essa API pode ser usada por terceiros, para obter o uso dessa API entre em contato.</span>
		</div><br>
		<h3>API IFRAME</h3>
		<div class="inner">
			<span>Esta Iframe gera a lista de players disponíveis para o filme/série procurado pelo IMDB</span><br>
			<span>No caso de séries, mostra temporadas/episódios/players.</span><br>
			<span>Esta API pode ser usada por qualquer um. No próximo passo você aprende como usar.</span><br>
			<span>O iframe é responsivo e vai funcionar em qualquer dispositivo.</span>
		</div><br>
		<h3>Como usar</h3>
		<div class="inner">
			<span>O iframe é chamado da seguinte forma:</span><br>
			<span><?php echo $url; ?>?type=<b>[TIPO DE PESQUISA]</b>&amp;imdb=<b>[ID DO IMDB]</b></span><br>
			<span>O tipo de pesquisa pode ser <b>"movies"</b> ou <b>"tvshows"</b> e o imdb, é o ID no IMDB</span><br><br>
			<span>Um link final poderia ficar assim:</span><br>
			<span>Filme:</span><br>
			<span><?php echo $url; ?>type=<b>movies</b>&amp;imdb=<b>tt1386697</b></span><br>
			<span>Série:</span><br>
			<span><?php echo $url; ?>?type=<b>tvshows</b>&amp;imdb=<b>tt2193021</b></span><br><br>
			<span>O Iframe deve ser sempre chamado com o atributo "allowfullscreen" para permitir a função de fullscreen</span><br>
			<span>USE SEMPRE HTTPS.</span><br>
			<span>Link com parametros: "<?php echo $url; ?>?type=tvshows&imdb=tt2193021</span><br><br>
			<span>Código final:</span><br>
			<span style="font-size:12px;">&lt;iframe src="<?php echo $url; ?>?type=tvshows&imdb=tt2193021" width="100%" height="500" allowfullscreen="true" scrolling="no" frameborder="0"&gt;&lt;/iframe&gt;</span><br><br>
			<iframe src="<?php echo $url; ?>?type=tvshows&imdb=tt2193021" allowfullscreen="true" width="100%" height="500" frameborder="0" scrolling="no"></iframe>
		</div>
	</div>
</main>

<?php
get_footer();