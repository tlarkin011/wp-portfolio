<?php
$field_name = forge_var('field_name');
$block_grid = forge_var('block_grid');
$option = forge_var('option') ? 'option' : null;

if (forge_var('nested')) {
    $contents = forge_var('contents');
} else {
    $contents = stk_get_field($field_name, $option);
}

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');

?>

<?php if ($contents) :
    $contents = $contents[0]['icon_posts']; ?>
    <section class="icon-post-wrapper <?php echo $field_name;?>">
        <div class="row row-center icon-post-wrap">

            <div class="icon-loop-block block-grid-<?php echo $block_grid; ?>">

                <?php foreach ($contents as $content) : ?>

                    <div class="icon-post">
                        <div class="wrapper">
                            <img src="<?php echo $content['icon'] ?>">

                            <div class="post-content">

                              
                                <h4 style="color:<?php echo $highlight_one;?>;"><?php echo $content['heading'] ?></h4>
                                
                            
                                        <h6 style="color:<?php echo $highlight_two;?>;" class="subtitle"><?php echo $content['sub_heading'] ?></h6>
                            

                                <p><?php echo $content['content'] ?></p>

                                <?php if ($content['link']) : ?>

                                      <a style="color:<?php echo $highlight_two;?>" href="<?php echo $content['link'] ?>" class="read-more">Learn More</a>


                               
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php endif; ?>