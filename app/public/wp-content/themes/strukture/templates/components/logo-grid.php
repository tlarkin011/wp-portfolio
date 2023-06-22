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

if($contents) {
  $logo_grid = $contents[0]['logo_grid'];
  $logo_grid_content = $contents[0]['logo_grid_content'];

}

?>

<?php if( $contents ) : ?>

  <section class="logo-grid">


    <h3><?php echo $logo_grid_content;?></h3>
    <div class="row row-center">
      <div class="block-grid-4">

        <?php foreach($logo_grid as $content) : ?>

          <div class="logo-container">
            <?php if ($content['link']) : ?>
            <a href="<?php echo $content['link'] ?>" target="_blank">
              <img src="<?php echo $content['logo'] ?>">
            </a>
            <?php else : ?>
              <img src="<?php echo $content['logo'] ?>">
            <?php endif; ?>
          </div>



        <?php endforeach; ?>



      </div>

    </div>


  </section>

<?php endif; ?>
