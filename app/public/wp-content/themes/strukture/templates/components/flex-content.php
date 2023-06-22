<?php
/*
  Flex content component
    usage: <?php forge_template('components/flex-content' ['field_name' => 'YOUR_ACF_FIELD_NAME']); ?>
    this component gives users the ability to build pages as they see fit as flex content can be rearranged in any order in the wp backend.
    The acf_fc_layout name must correspond to the switch statement case
    and the component must be nested to allow content to be passed directly to the component
    (as opposed to getting the acf fields within the component).
    See templates/content.php for reference of a nested component
 */
    $field_name = forge_var('field_name', 'flex_content');
    $contents = stk_get_field($field_name);
// Counter for unique selectors for styling purposes
    $i = 0;
    foreach ($contents as $content) :
        foreach ($content['flex_content'] as $flex_content) :
            $i++;
            switch ($flex_content['acf_fc_layout']) {
                 
                case 'content_background':
                forge_template('components/content/content-background', ['nested' => true, 'contents' => $flex_content['content'], 'class' => 'flex-content-component-' . $i]);
                break;


                case 'content_image':
                forge_template('components/content/content-image', ['nested' => true, 'contents' => $flex_content['content'], 'class' => 'flex-content-component-' . $in]);
                break;


                case 'content_intro':
                forge_template('components/content/content-intro', ['nested' => true, 'contents' => $flex_content['content'], 'class' => 'flex-content-component-' . $in]);
                break;


                case 'related_posts':
                example_cats_related_post();
                break;



                case 'content_with_posts': forge_template('components/content-with-posts', ['contents' => $flex_content['content_with_posts']]);
                break;
                case 'content_with_categories':

                forge_template('components/content-with-categories', ['nested' => true, 'contents' => $flex_content['content'], 'class' => 'flex-content-component-' . $i]);
                break;
                case 'content_with_details':
                forge_template('components/content-with-details', ['nested' => true, 'contents' => $flex_content['content']]);
                break;





                case 'highlights':
                forge_template('components/highlights', ['nested' => true, 'contents' => $flex_content['highlights']]);
                break;
                case 'gallery':
                forge_template('components/gallery', ['nested' => true, 'contents' => $flex_content['gallery']]);
                break;
               
                case 'image_or_video_row':
                forge_template('components/image-or-video-row', ['nested' => true, 'contents' => $flex_content['image_or_video_row']]);
                break;
                
                case 'page_links':
                forge_template('components/page-links', ['contents' => $flex_content['page_links']]);
                break;
               
                case 'icon_posts':
                forge_template('components/icon-post-flex', ['nested' => true, 'block_grid' =>3, 'contents' => $flex_content['icon_posts'], 'class' => 'flex-content-component-' . $i]);
                break;
                case 'accordion_with_content':
                forge_template('components/accordion', ['contents' => $flex_content['accordion_with_content']]);
                break;
                case 'logo_grid':
                forge_template('components/logo-grid', ['nested' => true, 'contents' => $flex_content['logo_grid']]);
                break;
                case 'featured_testimonials':
                forge_template('components/featured-testimonials', ['contents' => $flex_content['featured_testimonials'], 'class' => 'flex-content-component-' . $i]);
                break;

                case 'wsywig':
                forge_template('components/wsywig', ['nested' => true, 'contents' => $flex_content['content']]);
                break;

            
            }
        endforeach;
    endforeach;
