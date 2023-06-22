<?php
$field_name = forge_var('field_name');
$callout = get_field($field_name)[0]['accordion_callout'];
$contents = forge_var('contents');

if($field_name) {
  $flex = false;
  $accordion = get_field($field_name)[0]['accordion'];
} elseif($contents) {
  $flex = true;
  $accordion = $contents[0]['accordion'];

}


if( $flex ) {
  $callout_component = $contents[0]['accordion_callout'];
} else {
  $callout_component = $callout;
}

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');


?>



<section class="faq-postings" id="opportunities">

  <div class="row row-center">
 <?php forge_template('components/content/content-intro', ['nested' => "true", 'heading_tag'=> 'h2', 'contents' => $callout_component]);  ?>





   <div class="accordion-holder columns-8">

    <?php foreach($accordion as $content) : ?>

      <div class="accordion-entry">

        <div class="accordion-label">
          <h5 style="color: <?php echo $highlight_one;?>;" ><?php echo $content['accordion_label'] ?></h5>
          <?php if($content['label_meta']) : ?>
            <p ><?php echo $content['label_meta'] ?></p>
          <?php endif; ?>

        </div>

        <div class="accordion-content">
          <p><?php echo $content['accordion_content']  ?></p>

          <?php if( $content['button_link'] ) : ?>

            <a style="background: <?php echo $highlight_one;?>;" class="button one" href="<?php echo $content['button_link'] ?>" target="_blank">Apply Now</a>

          <?php endif; ?>


        </div>

      </div>

    <?php endforeach; ?>



</div>
</div>

</section>
