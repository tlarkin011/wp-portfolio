<?php
$field_name = forge_var('field_name', 'accordion');
$accordions = get_field($field_name);

if (!$accordions) {
    return;
}

foreach ($accordions as $accordion) :
    ?>

    <section class="page-section section accordion">
        <div class="row row-center">
            <div class="columns-10 accordion-holder">
                <?php foreach ($accordion['accordion'] as $accordion_row) :;

                    $title = $accordion_row['title'];
                    $content = $accordion_row['content'];
                    $subtitle = $accordion_row['subtitle'];

                    ?>
                    <div class="accordion-entry" data-status="closed">
                        <div class="accordion-label">
                            <span class="job-title"><?php echo $title; ?></span>

                            <div class="icon-container">

                                <?php if ($subtitle) : ?>
                                    <h6><?php echo $subtitle; ?></h6>
                                <?php endif; ?>
                                <i class="fa circle-up hidden fa-chevron-circle-up" aria-hidden="true"></i>
                                <i class="fa circle-down fa-chevron-circle-down" aria-hidden="true"></i>
                            </div>

                        </div>
                        <div class="accordion-content text-center" style="display: none">
                            <p><?php echo $content; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endforeach; ?>