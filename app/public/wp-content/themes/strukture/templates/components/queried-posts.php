<?php
/*
// Queried Posts Component w/ Optional Content Above
// How to use:
//<?php forge_template('components/queried-posts', ['field_name' => 'acf_field_name']); ?>
// Accepted vars
// field_name <- Self explanatory
// options <- Set to "true" if field is on an options page
// id <- id for wrapper div, useful for specific customizations
// class <- class for wrapper div, useful for specific customizations. Component type and field name are added automatically.
// heading_tag <-- the tag used for the option content heading, defaults to h2
// loop_heading_tag <-- the tag used for the post loop heading, defaults to h4
*/

$field_name = forge_var('field_name');
$option = forge_var('option');
$id = forge_var('id');
$class = forge_var('class');
$heading_tag = forge_var('heading_tag') ? forge_var('heading_tag') : 'h2';
$loop_heading_tag = forge_var('loop_heading_tag') ? forge_var('loop_heading_tag') : 'h4';
$taxonomy = forge_var('taxonomy') ? forge_var('taxonomy') : 'category';

$contents = stk_get_field($field_name, $option);


$terms = get_terms(
	array(
		'taxonomy' => $taxonomy,
		'hide_empty' => 0
	)
);


foreach ($contents as $content) {
	?>


	<div <?php if($id) { echo 'id="'.$id.'"'; } ?> class="<?= $field_name; ?> <?= $class; ?> queried-posts-component stk-component" <?php if($content['callout_component_image']) { forge_bg($content['callout_component_image']); }?> >
		<?php if($content['callout_display_content']) { ?>
			<div class="row row-<?php echo $content['post_component_content'][0]['callout_component_align_column']; ?> row-middle">
				<div class="columns-<?php echo $content['post_component_content'][0]['callout_component_content_columns']; ?> content-column">

					<!-- subtitle -->
					<?php if($content['post_component_content'][0]['callout_component_subtitle']) { ?>
						<h6 class="subtitle"><?php echo $content['post_component_content'][0]['callout_component_subtitle']; ?></h6>
					<?php } ?>

					<!-- heading -->
					<?php if($content['post_component_content'][0]['callout_component_heading']) { ?>

						<?php echo '<' . $heading_tag . ' class="title"' . '>' . $content['post_component_content'][0]['callout_component_heading'] . '</' . $heading_tag . '>'; ?>
					<?php } ?>

					<!-- text -->
					<?php if($content['post_component_content'][0]['callout_component_text']) { ?>
						<p><?php echo $content['post_component_content'][0]['callout_component_text']; ?></p>
					<?php } ?>

					<!-- buttons -->
					<?php

					if($content['post_component_content'][0]['callout_component_buttons']) { ?>
						<div class="cta-container">
							<?php foreach ($content['post_component_content'][0]['callout_component_buttons'] as $button) { ?>

								<a class="button <?= $button['callout_component_button'][0]['button_style'] ?>" href="<?php echo $button['callout_component_button'][0]['button_link'] ?>"><?php echo $button['callout_component_button'][0]['button_text'] ?></a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>


			</div>
		<?php } ?>
		<div class="row row-center posts-list">
			<?php
			if($content['callout_component_display_type'] == "cols") {
				$container_class = 'post-container block-grid-'.$content['callout_posts_grid_column'];
			}else {
				$container_class = 'block-rows';
			}

			?>

			<div class="<?php echo $container_class; ?>">

				<?php
				$args = array();
				if(!empty($content['callout_post_offset'])) {
					$content['callout_post_type_max'] =  ($content['callout_post_type_max'] == "-1" ? "999" : $content['callout_post_type_max']);
					$args['offset'] = $content['callout_post_offset'];
				}
				$query = (new ForgeQuery)->query($content['callout_post_type'], $content['callout_post_type_max'], $args);

				while($query->have_posts()): $query->the_post(); ?>

					<article <?php post_class(); ?>>
						<div class="post-snippet">
							<?php if($content['thumbnail_display'] == "bg") { ?>
								<a href="<?php the_permalink(); ?>">
									<div class="thumbnail-bg" <?php forge_bg(get_post_thumbnail_id()); ?>>

									<?php }elseif($content['thumbnail_display'] == "true") { ?>
										<a href="<?php the_permalink(); ?>" class="snippet-thumbnail">
                                            <?php the_post_thumbnail(); ?>
										</a>
									<?php }elseif($content['thumbnail_display'] == "icon") { ?>
										<?php ForgeAcf::has('icon')->then('<div class="icon-container"><img src="%s" class="icon" /></div>'); ?>
									<?php } ?>
									<div class="snippet-content">
										<?php ForgeAcf::has('location')->then('<h6 class="location">%s</h6>'); ?>
                                        <?php echo '<a href="' . get_the_permalink() . '"><' . $loop_heading_tag . ' class="title"' . '>' . get_the_title() . '</' . $loop_heading_tag . '></a>'; ?>
                                        <?php if($content['callout_component_show_terms']) : ?>
                                            <div class="taxonomy-links">
                                                <?php
                                                    $post_terms = get_the_terms(get_the_ID(), $taxonomy);
                                                foreach($post_terms as $term) : ?>
                                                    <a class="" href="<?php echo get_term_link( $term ); ?>"> <?php echo $term->name ?></a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

										<?php if($content['callout_posts_excerpt_display'] == "true") { ?>
											<p class="excerpt"><?php excerpt(); ?></p>
										<?php }elseif($content['callout_posts_excerpt_display'] == "desc") { ?>
											<?php ForgeAcf::has('short_description')->then('<p class="excerpt">%s</p>'); ?>
										<?php } ?>
										<?php if($content['callout_component_post_read_more_text'] != "") { ?>
											<a href="<?php the_permalink(); ?>" class="read-more"><?php echo $content['callout_component_post_read_more_text']; ?> <i class="far fa-arrow-right"></i></a>
										<?php } ?>

									</div>
									<?php if($content['thumbnail_display'] == "bg") { ?>

									</div>
								</a>
							<?php } // Closes thumbnail-bg wrapper ?>
						</div>
					</article>

				<?php endwhile; wp_reset_query(); ?>
			</div>
		</div>
		<!-- bottom CTA -->
		<?php

		if($content['callout_component_display_bottom_call_to_action']) { ?>
			<div class="row">
				<div class="columns-12">
					<div class="cta-container">
						<?php foreach ($content['bottom_call_to_action'] as $button) { ?>
							<a class="button <?= $button['button_style'] ?>" href="<?php echo $button['button_link'] ?>"><?php echo $button['button_text'] ?></a>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>

	</div>

<?php }

// Reset $contents to avoid variable repeating bugs
$contents = '';

?>
