<?php 

$primary_cat = get_the_terms(get_the_ID(), 'category')[0];
$cat_name = $primary_cat->name;
$cat_link = get_term_link($primary_cat);
$post_date = get_the_date( 'F j, Y' );

?>


<article class="loop-content loop-item loop-post">

	<div class="wrapper">

		<div class="columns-12 image-column">
			<?php forge_thumbnail_link(); ?>
		</div>

		<div class="columns-12 content-column">

			<?php if($cat_name && $cat_link) : ?>
				<div class="single-post-cat-list">
					<a href="<?php echo $cat_link ?>">
						<?php echo $cat_name ?>
					</a>
					<hr class="divider">
					<p><?php echo $post_date ?></p>

				</div>
			<?php endif; ?>

			<h4 class="loop-title"><?php forge_title_link(); ?></h4>

			<p><?php excerpt(20); ?></p>

			<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
		</div>

	</div>
</article>


