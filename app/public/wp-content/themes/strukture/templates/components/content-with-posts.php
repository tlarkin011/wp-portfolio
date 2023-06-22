<?php

//inital data variables
$field_name = forge_var('field_name');
$callout = get_field($field_name)[0]['callout_content'];
$contents = forge_var('contents');


//determining if we have a repeater, and if it comes from a template or flexible content
if( get_field($field_name)[0]['repeater'] ) {
  $repeater = get_field($field_name)[0]['repeater'];
} elseif( $contents[0]['repeater'] ) {
  $repeater = $contents[0]['repeater'];
} else {
  $repeater = false;
}



//determining whether the content component is from a template or flexible content, or whether it is the default featured posts
if( $callout ) {
  $callout_content = $callout;

} elseif( $field_name == 'featured_posts' && forge_var('option') ){

  $callout_content = get_field($field_name, 'option')[0]['callout_content'];

} else {
  $callout_content = $contents[0]['callout_content'];
};


// determining whether the posts are from a template or flexible content

if( get_field($field_name)[0]['callout_posts'] ) {
  $posts = get_field($field_name)[0]['callout_posts'];
} elseif( $contents[0]['callout_posts'] ) {
  $posts = $contents[0]['callout_posts'];
} elseif ( $field_name == 'featured_posts') {
  $posts = get_field($field_name, 'option')[0]['callout_posts'];

} else {
  $posts = '';
};

// determing whether the block grid number comes from a template or flexible content
if( get_field($field_name)[0]['posts_across'] ) {
  $block = get_field($field_name)[0]['posts_across'];
} elseif( $contents[0]['posts_across'] ) {
  $block = $contents[0]['posts_across'];
} elseif( $field_name == 'featured_posts' ) {
  $block = get_field($field_name, 'option')[0]['posts_across'];
} else {
  $block = '';
}

if($contents[0]['display_content_full_width']) {
  $full_width = $contents[0]['display_content_full_width'];
} elseif( get_field($field_name)[0]['display_content_full_width'] ) {
  $full_width = get_field($field_name)[0]['display_content_full_width'];
} elseif( $field_name == 'featured_posts' ) {
  $full_width = get_field($field_name, 'option')[0]['display_content_full_width'];
} else {
  $full_width = false;
}


if($full_width) {
  $alignment_class = 'full-width';
} else {
  $alignment_class = 'half-width';
}

// determing post type based on posts from either template or flexible content

if( !$contents[0]['choose_specific_posts'] && $contents[0]['post_type'] ) {
  $post_type = $contents[0]['post_type'];
} elseif( $field_name == 'featured_posts' ) {

  if( !get_field($field_name, 'option')[0]['choose_specific_posts'] ) {
    $post_type = get_field($field_name, 'option')[0]['post_type'];
  }


} else {
  $post_type = get_post_type($posts[0]);
}

?>



<section class="callout-posts <?php echo $field_name ?> "  >
  <div class="row row-center">
    <div class="callout-container <?php echo $alignment_class ?>">

      <?php forge_template('components/content', ['nested' => "true", 'contents' => $callout_content, 'full_width' => $full_width]);  ?>

      <div class="block-grid-<?php echo $block ?> post-wrapper">

        <?php if( $repeater ) : ?>

          <?php foreach($repeater as $content) : ?>

            <div class="callout-posts-loop icon-post-item">

              <div class="icon-container">
                <img src="<?php echo $content['icon'] ?>">
              </div>

              <div class="text-container">
                <h6 class="subtitle"><?php echo $content['subtitle'] ?></h6>
                <h4><?php echo $content['heading'] ?></h4>
                <p><?php echo $content['content'] ?></p>

                <?php if($content['link']) : ?>

                  <a class="button read-more-two" href="<?php echo $content['link'] ?>">Learn More</a>

                <?php endif; ?>

              </div>

            </div>

          <?php endforeach; ?>


          <?php else : ?>

            <?php

          //if no specific posts are chosen, just query most recent posts based on post type
            if(

              ( (!$contents[0]['choose_specific_posts']) && $contents[0]['post_type'] ) ||

              (get_field($field_name) && (!get_field($field_name)[0]['choose_specific_posts']))

            ) {

              $args = array(
                'post_type' => $post_type,
                'posts_per_page' => 3,
              );

                // if posts are chosen, query those posts
            } else {

              $args = array(
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'post__in' => $posts
              );

            }


            $query = new WP_Query($args);

            while($query->have_posts()) : $query->the_post();

              //using default post loop for now, but if you need different loop files, call
              // forge_template('loop/' . $post_type);
              //as long as your loop file is named after the post type, that will be muy bueno

              forge_template('loop/post');

            endwhile; wp_reset_query(); wp_reset_postdata();
            ?>

          <?php endif; ?>


        </div>
      </div>
    </div>
  </section>
