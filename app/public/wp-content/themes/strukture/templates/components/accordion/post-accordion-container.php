<?php
$query = forge_var('query');

if ($query->have_posts()): ?>
    <section class="accordion">
        <div class="row row-center">
            <div class="columns-12 accordion-holder">
                <? $query->loop('templates/components/accordion/post-accordion-item') ?>
            </div>
        </div>
    </section>
<?php endif; ?>