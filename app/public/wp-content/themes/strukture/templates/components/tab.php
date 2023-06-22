<?php $field_name = forge_var('field_name');
    $contents = stk_get_field($field_name);

?>
<?php foreach ($contents as $content) :
    $subheading = $content['tab_subheading'];
    $heading = $content['tab_heading'];
    $section_heading =  $content['tab_section_heading'];
?>
<section class="page-section section tab-section">
    <div class="row row-center">
        <div class="columns-12 tab-container">
            <?php if ($subheading || $heading) : ?>
                <div class="section-heading-container">
                    <?php if( $subheading): ?>
                        <h6 class="subtitle"><?= $subheading?></h6>
                    <?php endif; ?>
                    <?php if( $heading): ?>
                        <h2><?= $heading?></h2>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="tab-titles-container">
                <h5>Title</h5>
                <div class="row row-center">
                    <?php
                    $i = 0;
                    foreach ($content['tabs'] as $tab) : the_row();
                        $i++;

                        ?>
                        <a id="tab-title-<?php echo $i; ?>" class="tab-title tab-link <?php if ($i === 1) {echo 'active';} ?>" data-tab="<?php echo $i; ?>" onclick="openTab(event, '<?php echo 'tab-content-' . $i ?>')">
                            <h6 class="single-menu-tab-title"><?php echo $tab['tab_section_heading']; ?></h6>
                        </a>

                    <?php endforeach; ?>
                </div>
            </div>

            <div class="tab-content-container">
                <?php
                $i = 0;
                foreach ($content['tabs'] as $tab) :
                    $i++;
                    ?>
                    <div id="tab-content-<?echo $i; ?>" class="tab-content" style=" display: <?php echo ($i === 1) ? 'block' : 'none'; ?>">
                        <?php forge_template('components/content', ['nested' => "true", 'contents' => $tab['tab_content'], 'heading_tag' => 'h3']); ?>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endforeach; ?>