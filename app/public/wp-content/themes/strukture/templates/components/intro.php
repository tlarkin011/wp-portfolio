<?php
$class = forge_var('class');
$field_name = forge_var('field_name'); ?>

<section class="intro <?= $class; ?>">
   <?php
   ForgeAcf::content_block($field_name);
   ?>
</section>

