<?php 

$posttype = get_post_type();

switch($posttype) {

  case 'movies':
  $postmeta = postmeta_movies($post->ID);
  break;

  case 'tvshows':
  $postmeta = postmeta_tvshows($post->ID);
  break;
}

// Compose data
$title     = doo_isset($postmeta, 'title');
$permalink = doo_isset($postmeta, 'permalink');
$poster    = doo_isset($postmeta, 'poster');
$imdb      = doo_isset($postmeta, 'imdbRating');
$runtime   = doo_isset($postmeta, 'runtime');
$year      = doo_isset($postmeta, 'year');

?>
<a href="<?php echo $permalink; ?>" title="<?php printf(__('Watch %s Online','mega'), $title); ?>" class="gPoster">
  <div class="inner">
    <div class="p">
      <img data-original="<?php echo $poster; ?>" class="lazy" alt="<?php printf(__('Watch %s Online','mega'), $title); ?> Grátis">
    </div>
    <div class="i">
      <span><?php echo $title; ?></span>
      <div class="mi">
        <div class="y">
          <?php echo $year; ?>
        </div>
        <div class="r">
         <?php echo $imdb; ?>
       </div>
       <div class="t">
         <?php echo $runtime; ?>
       </div>
     </div>
   </div>
 </div>
</a>