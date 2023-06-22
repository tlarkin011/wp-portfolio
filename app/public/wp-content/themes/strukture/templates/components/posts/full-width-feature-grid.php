<?php 
$field_name = forge_var('field_name');

$posts = get_field('relationship');

if( $posts ): ?>

<article class="full-width-feature-wrapper">
        <div class="columns-12 background-post-loop grid-wrapper">

    <?php $grid = 1;?>

    <?php foreach( $posts as $p): ?>

        <?php setup_postdata($p); ?>

            <article class="loop-content loop-post grid<?php echo $grid;?>" <?php forge_bg(get_post_thumbnail_id( $p->ID)); ?>>
                

            <div class="single-post-cat-list">

                <?php 
                 
                     $cat = $p->post_type;

                      if($post_type == 'post') {
                                  $terms = get_the_terms( $p->ID , 'category' );
                                
                                  if ( $terms != null ){
                                    foreach( $terms as $term ) {
                                    $term_link = get_term_link( $term, 'category'  );
                                
                                    echo '<div class="single-post-cat-list">';
                                    echo '<a href="' . $term_link . '">' . $term->name . '</a><p>, </p>';
                                 
                                    echo the_tags("");
                                    $post_date = get_the_date( 'F j, Y' );?>
                                    <p class="post-date"><?php echo $post_date;?></p>
                                    
                                    <?php echo '</div>';
                                    unset($term); } } 
                                  } 

                              else {

                                  $terms = get_the_terms( $p->ID , $cat . '_type' );
                                  
                                  if ( $terms != null ){
                                    foreach( $terms as $term ) {
                                    $term_link = get_term_link( $term, $cat . '_type' );
                                
                                    echo '<div class="single-post-cat-list">';
                                    echo '<a href="' . $term_link . '">' . $term->name . '</a><p>,</p>';
                                 
                                    echo the_tags("");
                                    $post_date = get_the_date( 'F j, Y' );?>
                                    <p class="post-date"><?php echo $post_date;?></p>
                                    
                                    <?php echo '</div>';
                                    unset($term); } } 

                              }
                                  ?>

            </div>


                    <h4 class="loop-title"><?php forge_title_link( $p->ID ); ?></h4>

                    <p><?php excerpt(array('id' => $p->ID) ); ?></p>

                    <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
              
            </article>

            <?php $grid++;?>

    <?php endforeach; ?>

     </div>
  </article>

    <?php wp_reset_postdata();  ?>
<?php endif; ?>

