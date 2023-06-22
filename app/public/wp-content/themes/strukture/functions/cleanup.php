<?php
add_action('admin_head', 'hide_editor');
function hide_editor()
{
    $template_file = basename(get_page_template());
    if ($template_file == '_homepage.php'
        OR $template_file == '_flex.php'
        OR $template_file == '_about.php'
        OR $template_file == '_blog.php'
        OR $template_file == '_contact.php'
        OR $template_file == '_single-service.php'
           OR $template_file == '_single-case_study.php'
        OR $template_file == '_careers.php'
        OR $template_file == '_patients.php'
        OR $template_file == '_styled.php'
          OR $template_file == '_how_it_works.php'
          OR $template_file == '_faq.php'
        OR $template_file == '_thank-you.php'

    ) { // template
        remove_post_type_support('page', 'editor');
    }
}

if (!defined('THEME_IMG_PATH')) {
    define('THEME_IMG_PATH', get_stylesheet_directory_uri() . '/images');
}

function strukture_style() {
        $strukture_class = "";

        $rounded = get_field('rounded', 'option');
            if ($rounded == true ) {
                $strukture_class .= " rounded";
            }

        $shadowed = get_field('shadowed', 'option');
            if ($shadowed == true ) {
                $strukture_class .= " shadowed";
            }

        $color_box = get_field('color_box', 'option');
            if ($color_box == true ) {
                $strukture_class .= " color-boxes";
            }
        return $strukture_class;
    }


function background_variables($option = false) {
    if ($option == false) {
        $background_one_color = get_field('background_one_color');
        $background_one_height = get_field('background_one_height');
        $background_one_offset = get_field('background_one_y_offset');
        $background_two_color = get_field('background_two_color');
        $background_two_height = get_field('background_two_height');
        $background_two_offset = get_field('background_two_y_offset');

    } else {

        $background_one_color = get_field('background_one_color', 'option');
        $background_one_height = get_field('background_one_height', 'option');
        $background_one_offset = get_field('background_one_y_offset', 'option');
        $background_two_color = get_field('background_two_color', 'option');
        $background_two_height = get_field('background_two_height', 'option');
        $background_two_offset = get_field('background_two_y_offset', 'option');

    }

    $background_variables = array();

    array_push($background_variables, $background_one_color);
    array_push($background_variables, $background_one_height);
    array_push($background_variables, $background_one_offset);
    array_push($background_variables, $background_two_color);
    array_push($background_variables, $background_two_height);
    array_push($background_variables, $background_two_offset);

    return $background_variables;

}

function background_blocks($background_variables) {
    
?>
    <div class="background_one" style="background-color:<?php echo $background_variables[0];?>; height: <?php echo $background_variables[1];?>%; top: <?php echo $background_variables[2];?>%;"></div>
    <div class="background_two" style="background-color:<?php echo $background_variables[3];?>; height: <?php echo $background_variables[4];?>%; top: <?php echo $background_variables[5];?>%;"></div>
<?php 


}


function example_cats_related_post()
{
    
    $highlight_one = get_field('highlight_color_one', 'option');
    $highlight_two = get_field('highlight_color_two', 'option');
    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category($post_id);

    if (!empty($categories) && is_wp_error($categories)):
        foreach ($categories as $category):
            array_push($cat_ids, $category->term_id);
        endforeach;
    endif;

    $current_post_type = get_post_type($post_id);
    $query_args = array(

        'category__in' => $cat_ids,
        'post_type' => $current_post_type,
        'post__not_in' => array($post_id),
        'posts_per_page' => '2'


    );

    $related_cats_post = new WP_Query($query_args);

    if ($related_cats_post->have_posts()):?>

        <div class="row row-center blog-post-wrapper">
            <div class="columns-12 blog-post-loop block-grid-2">

                <?php while ($related_cats_post->have_posts()): $related_cats_post->the_post(); ?>


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

                 <a style="color:<?php echo $highlight_two;?>; border-bottom:1px solid <?php echo $highlight_two;?>;"  href="<?php the_permalink(); ?>" class="read-more">Read More</a>
            </div>
        </article>
                <?php endwhile; ?>

            </div>
        </div>

        <?php wp_reset_postdata();
    endif;

} 


function example_cats_related_background()
{

    $highlight_one = get_field('highlight_color_one', 'option');
    $highlight_two = get_field('highlight_color_two', 'option');
    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category($post_id);

    if (!empty($categories) && is_wp_error($categories)):
        foreach ($categories as $category):
            array_push($cat_ids, $category->term_id);
        endforeach;
    endif;

    $current_post_type = get_post_type($post_id);
    $query_args = array(

        'category__in' => $cat_ids,
        'post_type' => $current_post_type,
        'post__not_in' => array($post_id),
        'posts_per_page' => '2'


    );

    $related_cats_post = new WP_Query($query_args);

    if ($related_cats_post->have_posts()):?>

  <article class="background-post-wrapper">
    <div class="row row-center">
        <div class="columns-12 background-post-loop block-grid-2">

                <?php while ($related_cats_post->have_posts()): $related_cats_post->the_post(); ?>

                           <article class="content-component loop-content loop-post thumbnail-bg" <?php forge_bg(get_post_thumbnail_id()); ?>>
              
                  <div class="content-column ">

                    <h4 style="color:<?php echo $highlight_one;?>" class="loop-title"><?php forge_title_link(); ?></h4>
                    <p><?php excerpt(); ?></p>

                     <a style="color:<?php echo $highlight_one;?>; border-bottom:1px solid <?php echo $highlight_one;?>;"  href="<?php the_permalink(); ?>" class="read-more">Learn More</a>
                   </div>
            </article>
                <?php endwhile; ?>

            </div>
        </div>
</article>
        <?php wp_reset_postdata();
    endif;

} ?>
