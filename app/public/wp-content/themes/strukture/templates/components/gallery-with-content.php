<?php
$contents = forge_var('contents');
$gallery = forge_var('gallery');
?>
<section>
    <?php forge_template('components/content', ['nested' => true, 'contents' => $contents]); ?>
    <?php forge_template('components/gallery', ['gallery' => $gallery]); ?>
</section>
