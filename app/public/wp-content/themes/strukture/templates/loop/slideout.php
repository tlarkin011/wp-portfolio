<!--

This is a flexible loop slideout component. Depending on the design, you may have to add extra content to either the loop-content class, which is what is displayed
in the loop, or the loop hidden class, which is displayed on click

-->

<?php
$block_grid = forge_var('block-grid');
$hidden = forge_var('hidden');
$content = forge_var('content');

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');

?>

<article class="slideout-item">

  <div class="container" >

    <div class="loop-content" <?php forge_bg() ?>>
        <?php
        $hover_image = get_field('hover_image');
        // currently uses 1 image size source but could be updated in the future
        if ($hover_image) {
            $img_src = wp_get_attachment_image_src($hover_image, 'fs-desktop');
//            $mobile = wp_get_attachment_image_src($hover_image, 'fs-desktop');
            if (is_array($img_src)) {
                echo "<picture>";
                echo "<source srcset='{$img_src[0]}' >";
                echo "<img class='hover-image' src='{$img_src[0]}' >";
                echo "</picture>";
            }

        }
        ?>

      <!-- change icons as per design -->

      <div class="minus icon">
       <i  class="fal fa-minus-circle"></i>
     </div>

     <div class="plus icon">
       <i  class="fal fa-plus-circle"></i>
     </div>



     <?php forge_template($content); ?>
     <div class="active-bar"></div>

     <!--       adjust as per design, may be beneficial to create an image container or content container div for appropriate positioning -->
     <div style="background-color:<?php echo $highlight_two;?>" class="active-bar"></div>

   </div>




   <div style="background-color:<?php echo $highlight_two;?>; margin-bottom:20px;" class="loop-hidden">
    <?php forge_template($hidden); ?>

    <div class="close">
     <i style="color:<?php echo $highlight_two;?>;" class="fal fa-minus-circle"></i>
   </div>

 </div>


</div>



</article>
