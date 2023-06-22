

<?php
/*
 *  Template Name: Case Studies Page
 */
get_header(); the_post();
$strukture_class = strukture_style();
?>


<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>

<article class="background-post-wrapper">
    <div class="row row-center">
      <div class="columns-12 background-post-loop block-grid-2">

     <?php
        $args = array(
          'post_type' => 'case_study',
          'posts_per_page' => -1
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


<?php 
get_footer(); ?>
