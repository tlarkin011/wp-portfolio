<?php
/*
// Generic content component
// How to use:
// <?php forge_template('components/content', ['field_name' => 'acf_field_name']); ?>
// Accepted vars
// field_name <- Self explanatory
// options <- Set to "true" if field is on an options page
// id <- id for wrapper div, useful for specific customizations
// class <- class for wrapper div, useful for specific customizations. Component type and field name are added automatically.
// nested <-- set to "true" if using this component inside another component, will bypass ACF functions. See components/content-rows.php for use case.
// contents <-- used together with 'nested' to pass content directly to the component. Useful when nesting. See components/content-rows.php for use case.
// alignment <-- used together with 'nested' to pass content alignment. See components/content-rows.php for use case.
*/

// set repeater => 'true' to use in a repeater

$nested = forge_var('nested');
$repeater = forge_var('repeater');

if ($nested == "true") {
    $contents = forge_var('contents');
    $alignment = forge_var('alignment');

} elseif ($repeater == "true") {
    $field_name = forge_var('field_name');
    $option = forge_var('option');
    $id = forge_var('id');
    $contents = stk_get_sub_field($field_name, $option);

} else {
    $field_name = forge_var('field_name');
    $option = forge_var('option');
    $id = forge_var('id');
    $contents = stk_get_field($field_name, $option);
}

$class = forge_var('class');
$heading_tag = forge_var('heading_tag') ? forge_var('heading_tag') : 'h2';




$row = 0;
foreach ($contents as $content) {
    ?>
    <article <?php if ($id) {
        echo 'id="' . $id . '"';
        } ?> class="<?php $field_name; ?>  <?php $class; ?>  <?php if ($field_name == 'page_banner') {
            echo " page-banner columns-12";
            } else {
                echo " content-component stk-component";
            } ?>" <?php if ($content['callout_component_image']) {
                forge_bg($content['callout_component_image']);
            } ?> >
            <div class="row row-center" id="<?php echo $content['callout_component_subtitle']; ?>">
                <div class="content-container columns-10 content-column">

                    <div class="banner-content-box">


                        <div class="text-container">

                            <!-- subtitle -->
                            <?php if ($content['callout_component_subtitle']) { ?>
                                <h6 class="subtitle"><?php echo $content['callout_component_subtitle']; ?></h6>
                            <?php } ?>

                            <!-- heading -->
                            <?php if ($content['callout_component_heading']) { ?>
                                <?php echo '<' . $heading_tag . ' class="heading">' . $content['callout_component_heading'] . '</' . $heading_tag . '>';
                            } ?>

                            <!-- text -->
                            <?php if ($content['callout_component_text']) { ?>
                                <p><?php echo $content['callout_component_text']; ?></p>
                            <?php } ?>

                        </div>

                        <?php if ($content['callout_component_buttons']) { ?>
                            <!-- cta -->
                            <div class="cta-column">
                                <div class="cta-container">
                                    <?php foreach ($content['callout_component_buttons'] as $button) { ?>
                                        <?php echo stk_construct_button_html($button['callout_component_button'][0]); ?>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php if ($content['callout_component_content_image_toggle'] == 1) { ?>

                    <!-- img -->
                    <div class="image-column">

                        <?php

                        $image = $content['callout_component_content_image'];




                        if( is_array($image) ) {
                            $content_image = $image['url'];
                        } else {
                            $content_image = $image;
                        }

                        ?>


                        <img src="<?php echo $content_image ?>" alt="">
                    </div>
                <?php } ?>

            </div>

        </article>

        <?php
        $row++;
    }

// Reset $contents to avoid variable repeating bugs
    $contents = '';


    ?>
