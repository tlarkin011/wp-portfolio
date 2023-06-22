<?php 

$has_thumbnail = get_the_post_thumbnail_url();

?>

<article class="loop-item search">

	<div class="image-column columns-4" <?php $has_thumbnail ? forge_bg() : forge_bg(get_field('default_banner_image', 'option')); ?>></div>
	<div class="content-column columns-8">
		<h3 class="loop-title"><?php the_title() ?></h3>
		<p><?php echo get_the_excerpt(); ?></p>
		<a class="button read-more" href="<?php the_permalink(); ?>">Read More</a>
	</div>
	
</article>