<?php
$terms = get_the_terms($post, 'category');
$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');


 ?>
<section class="">
    <div class="page-banner single-page-banner" style="background-color: <?php echo $highlight_one;?> "<?php forge_bg(); ?>>
        <div class="row-bottom row-center row">

            <div class="content-container columns-11  content-column">
                <div class="banner-content-box">
                    <div class="title-container">
                        <?php echo stk_format_terms($terms); ?>
                        <!-- heading -->
                        <h1><?php the_title(); ?></h1>
                    </div>
                </div>

                     <div class="post-meta">
                         <p> <?php echo get_the_date(); ?></p>
                        <p>
                            <?php get_the_author(); ?>
                        </p>
                    </div>
                    <?php forge_template('components/social-share'); ?>


            </div>

   
               
         
  
        </div>
    </div>
</section>
