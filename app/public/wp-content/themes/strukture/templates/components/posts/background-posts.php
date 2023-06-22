
<?php

$post_type = forge_var('post_type');
$posts_per_page = forge_var('posts_per_page');
$block_grid = forge_var('block_grid');
$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');
?>

  <article class="background-post-wrapper">
    <div class="row row-center">
      <div class="columns-12 background-post-loop block-grid-<?php echo $block_grid;?>">


     <?php
        $args = array(
          'post_type' => $post_type,
          'posts_per_page' => $posts_per_page
        );

        $query = new WP_Query($args);

        while($query->have_posts()) : $query->the_post();?>

            <article class="content-component loop-content loop-post thumbnail-bg" <?php forge_bg(get_post_thumbnail_id()); ?>>
              
                  <div class="content-column ">

                    <h4 style="color:<?php echo $highlight_one;?>" class="loop-title"><?php forge_title_link(); ?></h4>
                    <p><?php excerpt(); ?></p>

                     <a style="color:<?php echo $highlight_one;?>; border-bottom:1px solid <?php echo $highlight_one;?>;"  href="<?php the_permalink(); ?>" class="read-more">Learn More</a>
                   </div>
            </article>


       <? endwhile; wp_reset_query();
        ?>

      </div>
    </div>
  </article>

