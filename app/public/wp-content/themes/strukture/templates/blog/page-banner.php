<?php
/*
// Generic content component
// How to use:
// <?php forge_template('components/content', ['field_name' => 'acf_field_name']); ?>
// Accepted vars
// field_name <- Self explanatory
// option <- Set to "true" if field is on an options page
// id <- id for wrapper div, useful for specific customizations
// class <- class for wrapper div, useful for specific customizations. Component type and field name are added automatically.
// nested <-- set to "true" if using this component inside another component, will bypass ACF functions. See components/content-rows.php for use case.
// contents <-- used together with 'nested' to pass content directly to the component. Useful when nesting. See components/content-rows.php for use case.
// alignment <-- used together with 'nested' to pass content alignment. See components/content-rows.php for use case.
// heading_tag <-- the heading tag to be used, defaults to h2
// acf_id <-- Post or post id if content needs to be accessed from another page or a taxonomy archive page
*/

$field_name = forge_var('field_name');
$option = forge_var('option');
$acf_id = forge_var('acf_id');
$id = forge_var('id');
$class = forge_var('class');
$contents = stk_get_field($field_name, $option, $acf_id);
$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');
$itemtype = forge_var('item_type');
// schema information for SEO, choose the itemtype that most closely matches the given page
// examples: ItemPage   : single item / product
// examples: ContactPage  
// examples: FAQPage  
// examples: AboutPage  
// examples: Event
// examples: Service
// examples: Product
// examples: IndividualProduct
// examples: Course
// examples: Blog

// see https://schema.org/docs/full.html

$banner_wrapper = 'banner-wrapper';

$heading_tag = forge_var('heading_tag') ? forge_var('heading_tag') : 'h1';

$row = 0;
foreach ($contents as $content) {
    $heading_content = $content['callout_component_heading'] ?? get_the_title();
    ?>
    <section role="banner" class="<?= $banner_wrapper; ?> " itemscope itemtype="http://schema.org/<?php echo $itemtype;?>">
        <div <?php if ($id) {
            echo 'id="' . $id . '"';
        } ?> class="<?= $field_name; ?>  <?= $class; ?> product-banner page-banner" style="background-color: <?php echo $highlight_one;?>"        <?php if ($content['callout_component_image']) {
            forge_bg($content['callout_component_image']);
        } ?> >
            <div class="row-bottom row"
                 id="<?php echo $content['callout_component_subtitle']; ?>">

                <div class="content-container columns-8 content-column">
                    <div class="banner-content-box">
                        <div class="title-container">
                            <!-- subtitle -->
                            <?php if ($content['callout_component_subtitle']) { ?>
                                <div class="subtitle-title-container">
                                      <h6 style="color:<?php echo $highlight_two ;?>" class="subtitle"><?= $content['callout_component_subtitle']; ?></h6>
                                </div>
                            <?php } ?>
                            <!-- heading -->
                            <?php if ($content['callout_component_heading']) { ?>
                                <?php   echo '<' . $heading_tag . ' class="heading"  itemprop="name">' . $content['callout_component_heading'] . '</' . $heading_tag . '>';
                            } ?>

                           

                        </div>
                    </div>

                    <!-- text -->
                    <?php if ($content['callout_component_text']) { ?>
                        <?= $content['callout_component_text']; ?>
                    <?php } ?>

                    
                     
                    <?php if ($content['callout_component_buttons']) { ?>
                        <!-- cta -->
                        <div class="cta-column">
                            <div class="cta-container">
                                  <?php foreach ($content['callout_component_buttons'] as $button) { ?>
                                <?php echo stk_construct_button_html($button['callout_component_button'][0], $highlight_one, $highlight_two); ?>
                            <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
          <div class="filter-wrapper">
         <?php forge_template('components/filter', ['taxonomies' => ['category'], 'post_type' => 'post']); ?>
     </div>
    </section>

    <?php
    $row++;
}

// Reset $contents to avoid variable repeating bugs
$contents = '';

?>
