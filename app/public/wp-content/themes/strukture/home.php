<?php
/*
 *  Template Name: Blog Page
 */
get_header(); the_post();
$strukture_class = strukture_style();
?>


<?php forge_template('blog/page-banner', ['field_name' => 'blog_page_banner', 'option' => true]); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">


  <div class="row row-center blog-post-wrapper">
    <div class="columns-12 blog-post-loop block-grid-2">

      <?php while (have_posts()): the_post(); ?>
      


        <article class="loop-content loop-post row">
            <div class="columns-12 image-column">
                <?php forge_thumbnail_link(); ?>
            </div>

            <div class="columns-12 content-column">

                  <?php  

                                  $terms = get_the_terms( $post->ID , 'category' );
                                
                                  if ( $terms != null ){
                                    foreach( $terms as $term ) {
                                    $term_link = get_term_link( $term, 'category'  );
                                
                                    echo '<div class="single-post-cat-list">';
                                    echo '<a href="' . $term_link . '">' . $term->name . '</a><p>,</p>';
                                 
                                    echo the_tags("");
                                    $post_date = get_the_date( 'F j, Y' );?>
                                    <p class="post-date"><?php echo $post_date;?></p>
                                    
                                    <?php echo '</div>';
                                    unset($term); } } 
                         
                                  ?>

              <h3 style="color:<?php echo $highlight_one;?>"  class="loop-title"><?php forge_title_link(); ?></h3>

              <?php excerpt(); ?>

                 <a style="color:<?php echo $highlight_one;?>; border-bottom:1px solid <?php echo $highlight_one;?>;"  href="<?php the_permalink(); ?>" class="read-more">Read More</a>
            </div>
        </article>

      <?php endwhile; ?>
     
    </div>
  </div>
 <?php forge_template('components/pagination'); ?>
</div>

<?php 

forge_template('components/content/content-background', ['field_name' => 'standard_pre_footer_cta', 'option' => true]);
 get_footer(); ?>