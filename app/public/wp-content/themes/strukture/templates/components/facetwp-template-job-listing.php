<?php
if ( have_posts() ) { ?>
	<div class="accordion-holder">
	<?php
	while ( have_posts() ) {
		the_post(); ?>

		<div class="accordion-entry">
			<div class="accordion-label">
				<h5><?php the_title(); ?></h5>
				<p><?php the_field( 'location' ); ?></p>
			</div>

			<div class="accordion-content">
				<p><?php the_content(); ?></p>

				<a style="background: #232323;" class="button one" href="<?php echo esc_url( get_permalink() . '/?gh_jid=' . get_field( 'greenhouse_job_id' ) ); ?>">Apply Now</a>
			</div>
		</div>

		<?php
	} ?>
	</div>
<?php
} else {
	echo '<br><br>No Current Openings.';
}
?>