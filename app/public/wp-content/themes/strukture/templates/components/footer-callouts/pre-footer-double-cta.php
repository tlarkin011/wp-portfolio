<?php 	

	$option = forge_var('option');
	?>
 	<article class="pre-footer-callouts">
 		<div class="columns-12 pre-footer-callouts flex">

 			<div class="columns-6 pre-footer-callout-single">
 				 <?php forge_template('components/content', ['field_name' => 'pre_footer_cta_left', 'option' => $option]); ?>
 			</div>

 			<div class="columns-6 pre-footer-callout-single">
 				<?php forge_template('components/content', ['field_name' => 'pre_footer_cta_right', 'option' => $option]); ?>
 			</div>

 		</div>
 	</article>
