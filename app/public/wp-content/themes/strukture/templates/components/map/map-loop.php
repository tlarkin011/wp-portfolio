<?php
$post_type = forge_var('post_type');
$query = (new ForgeQuery)->query($post_type, -1);
?>
<section class="loop-grid-container">
    <div class="row">
        <div class="block-grid-1 map-loop-container">
            <?php $query->loop('templates/components/map/map-item'); ?>
        </div>
    </div>
</section>
