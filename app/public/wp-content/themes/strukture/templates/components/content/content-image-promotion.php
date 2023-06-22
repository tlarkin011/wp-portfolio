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

$nested = forge_var('nested');
if ($nested == "true") {
    $contents = forge_var('contents');
} else {
    $field_name = forge_var('field_name');
    $option = forge_var('option');
    $id = forge_var('id');
    $contents = stk_get_field($field_name, $option);
}

$class = forge_var('class');
$heading_tag = forge_var('heading_tag') ? forge_var('heading_tag') : 'h3';

// variables for text colors

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');


$row = 0;
foreach ($contents as $content) {

    ?>
    <article <?= $id ? 'id=' . $id : ''; ?>
             style="background-color:<?php echo $highlight_two;?>;" class="content-component <?= $field_name; ?>  <?= $class; ?>  <?= $content['style']; ?> ">
        <div class="row row-center" id="<?php echo $content['callout_component_subtitle']; ?>">
            <div class="columns-6 content-column">

                <div class="text-container">
                    <!-- subtitle -->
                    <?php if ($content['callout_component_subtitle']) { ?>
                        <h6 style="color:<?php echo $highlight_two ;?>" class="subtitle"><?= $content['callout_component_subtitle']; ?></h6>
                    <?php } ?>
                    <!-- heading -->

                    <?php if ($content['callout_component_heading']) {
                        echo '<' . $heading_tag . ' style="color:' . white . ';" class="heading"  itemprop="name">' . $content['callout_component_heading'] . '</' . $heading_tag . '>';
                    }
                    ?>
                    <!-- text -->
                    <?php if ($content['callout_component_text']) { ?>
                        <p><?= $content['callout_component_text']; ?></p>
                    <?php } ?>
                </div>

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

             <div class="image-column columns-6">
                <div style="background-color: <?php echo $highlight_one;?>" class="frill-box"></div>
                <img src="<?= $content['callout_component_image']; ?>" alt="">
            </div>


        </div>

      


     

    </article>

    <?php
    $row++;
}

// Reset $contents to avoid variable repeating bugs
$contents = '';

?>
