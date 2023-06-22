<?php
if (forge_var('nested')) {
    $contents = forge_var('contents');
} else {
    $field_name = forge_var('field_name', 'content_with_details');
    $contents = stk_get_field($field_name);
}
if ($contents) {
    foreach ($contents as $content) {
        $details = $content["details"];
        ?>
        <section class="content-with-details">
            <div class="row row-center">
                <div class="columns-6">
                    <?php ForgeAcf::nested_content_block($content['content'][0], 'content-with-details-content'); ?>
                </div>
                <div class="columns-6">
                    <ul class="details-list">
                        <?php foreach ($details as $detail) : ?>
                            <li class="row detail-list-item">
                                <h5 class="label">
                                    <i class="fas fa-angle-right"></i>
                                    <?php echo $detail['label']; ?>
                                </h5>
                                <p>
                                    <?php echo $detail['content']; ?>
                                </p>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php }
}
?>