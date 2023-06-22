<?php

$field_name = forge_var('field_name');
$nested = forge_var('nested');

if ($nested == true) {
    $contents = forge_var('contents');
    $alignment = forge_var('alignment');
} else {
    $field_name = forge_var('field_name');
    $option = forge_var('option');
    $id = forge_var('id');
    $contents = stk_get_field($field_name, $option);
}



?>

<?php if ($contents) :?>
   

    <section class="icon-post-wrapper">
        <div class="row row-center">

            <div class="icon-loop-block block-grid-<?php echo $block_grid; ?>">

                <?php foreach ($contents as $content) : ?>

                    <div class="icon-post">
                        <div class="wrapper">
                            <img src="<?php echo $content['icon'] ?>">

                            <div class="post-content">

                                <h6 class="subtitle"><?php echo $content['subtitle'] ?></h6>
                                <h3><?php echo $content['heading'] ?></h3>
                                <p><?php echo $content['content'] ?></p>

                                <?php if ($content['link']) : ?>
                                    <a class="button read-more" href="<?php echo $content['link'] ?>"
                                       class="read-more">Learn More</a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php endif; ?>