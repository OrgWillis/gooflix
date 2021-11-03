<?php 
$icon = compose_image_option('down_app');
$icon = ($icon) ? $icon : return_assets_image('app.png');

?>
 <div class="generalModal">
 	<div class="inner">
 		<div class="appPromo box" style="width:300px!important;">
 			<div class="innerbox">
 				<div class="coolButton orange close corner" onclick="closeAllModals();">
 					<div class="icon w20" data-generate-icon>
 						<div class="closeIcon">
 						</div>
 					</div>
 				</div>
 				<a href="<?php echo compose_pagelink('pageapp'); ?>">
 					<img src="<?php echo $icon; ?>">
 				</a>
 			</div>
 		</div>
 	</div>
 </div>