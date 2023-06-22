<?php $query = (new ForgeQuery)->query('project', 3); ?>
<section class="page-section">
    <div class="row">
        <div class="block-grid-3 case-study-grid">
            <?php $query->loop('templates/loop/post'); ?>
        </div>
    </div>
</section>
<?php forge_template('components/pagination', ['query' => $query]); ?>
