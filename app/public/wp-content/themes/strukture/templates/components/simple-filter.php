<?php
$selected_arr = stk_construct_array_from_get_values('category');
?>
<div class="row row-right">
    <div class="simple-filter-form search-form-container filter-form-container columns-5">
        <div class="row row-middle row-right">
            <h6 class="columns-2">Filter by:</h6>
            <form role="search" class="search-form columns-8 row" action="<?php echo site_url('/'); ?>" method="get" id="simple-filter">
                <?php echo stk_construct_taxonomy_select_field('category', $selected_arr, 'post', 'Category'); ?>
                <input  type="hidden" name="post_type" value="post" />
            </form>
        </div>
    </div>
</div>
