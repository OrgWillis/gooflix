 <?php $trailer   = (isset($_GET['trailer'])) ? $_GET['trailer'] : null; ?>
 <div class="generalModal">
 	<div class="inner">
 		<div class="box trailer">
 			<div class="innerbox">
 				<div class="video">
 					<iframe width="640" height="340" src="https://www.youtube.com/embed/<?php echo $trailer; ?>" frameborder="0" allowfullscreen></iframe>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>