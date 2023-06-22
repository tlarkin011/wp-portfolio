<?php

//currently only set up to be used in the flex content component

$field_name = forge_var('field_name');
$contents = forge_var('contents');

if($field_name) {
  $flex = false;
} elseif($contents) {
  $flex = true;
}

if($flex) {
  $page_links = $contents[0]['page_links'];
  $block_grid = $contents[0]['block_grid'];
}




?>

<?php if($page_links) : ?>

  <section class="page-links">
    <div class="columns-12">
      <div class="block-grid-<?php echo $block_grid  ?>">

        <?php foreach($page_links as $link) : ?>



          <div class="page-link" >
            <div class="container" <?php forge_bg($link['background']); ?>>
              <h2><?php echo $link['heading'] ?></h2>
              <p><?php echo $link['content']  ?></p>
              <a class="button two" href="<?php echo $link['button_link'] ?>"><?php echo $link['button_text'] ?></a>
            </div>
          </div>

        <?php endforeach; ?>

      </div>
    </div>
  </section>

<?php endif; ?>
