<?php get_header(); the_post();
$strukture_class = strukture_style();
?>

<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>


<div class="strukture-wrapper <?php echo $strukture_class;?>">

		<div class="map-info-wrapper row row-center">
			<div class="columns-12 flex">
				<div class="columns-8">
					<?php forge_template('components/map/map'); ?>
				</div>

				<div class="columns-4 map-content-wrapper">
					<div class="location-info">
		            <div class="location-block">
		                <i class="fal fa-map-marker-alt"></i>
		                <p><?php echo the_field('address');?></p>
		            </div>

		               <div class="location-block">
		             <i class="fal fa-envelope"></i>
		                <a href="mailto:<?php echo the_field('email');?>"> <?php echo the_field('email');?></a>
		            </div>

		             <div class="location-block">
		               <i class="fal fa-clock"></i>
		                <p><?php echo the_field('hours');?></p>
		            </div>

		               <div class="location-block">
		               <i class="fal fa-phone"></i>
		                <p><?php echo the_field('phone_number');?></p>
		            </div>
		        </div>
				</div>
			</div>
		</div>
		
		<?php forge_template('components/content/content-background', ['field_name' => 'meet_the_team', 'heading_tag' => 'h3']); ?>
		<?php forge_template('components/content-shortcode', ['field_name' => 'get_in_touch_form']); ?>
</div>
<?php get_footer();?>
