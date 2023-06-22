<?php
$title = get_the_title();
?>
<div class="accordion-entry" data-status="closed">
    <div class="accordion-label">
        <h5 class="accordion-title"><?php echo $title; ?></h5>

        <div class="icon-container">
            <i class="fa circle-up hidden fa-chevron-circle-up" aria-hidden="true"></i>
            <i class="fa circle-down fa-chevron-circle-down" aria-hidden="true"></i>
        </div>

    </div>
    <div class="accordion-content text-center" style="display: none">
        <p><?php the_content(); ?></p>
    </div>
</div>
