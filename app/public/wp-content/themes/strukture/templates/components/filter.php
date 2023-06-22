<?php
$taxonomies = forge_var('taxonomies') ? forge_var('taxonomies') : [];
$post_type = forge_var('post_type') ? esc_html(forge_var('post_type')) : 'post';
$include_search = forge_var('search');
// Reset link defaults to acf field: filter reset link set in the options page. If there are multiple filters on a site, you must
// make multiple reset links in the options page and pass the acf field name manually
$reset = get_field(forge_var('reset_link'), 'option') ? get_field(forge_var('reset_link'), 'option') : get_field('filter_reset_link', 'option');
// Array of placeholder names for the select field, must be passed in same order as the taxonomies that they are a placeholder for
$placeholders = forge_var('placeholders');
// Counter to access proper placeholder index in loop
$i = 0;
// Url form submits to, default is usually what you need but this can be handy for specific instances
// such as filter being used on an archive page and you want to filter based on the current archive
// example: url => 'get_home_url() . '/your-archive-path/' . $term->slug'
$form_url = forge_var('url', site_url('/'));
?>
<section class="filter-section">
    <div class="row row-center filter-container">
        <div class="columns-12">
            <div class="filter-form-container">
                <h6>Filter by:</h6>
                <form class="search-form" role="search" action="<?php echo $form_url; ?>" method="get"
                      id="searchform">
                    <div class="flex-container">
                        <input type="hidden" name="post_type" value=<?= $post_type; ?> />
                        <?php foreach ($taxonomies as $taxonomy) :
                            $placeholder = $placeholders ? $placeholders[$i] : null;
                            $i++;
                            $selected_arr = stk_construct_array_from_get_values($taxonomy);
                            // depending on the permalink structure the query string may be overwritten
                            // this check will ensure that the select value persists on form submit if that happens
                            if (is_archive()) {
                                $qo = get_queried_object();
                                if (is_a($qo, "WP_Term")) {
                                    array_push($selected_arr, $qo->slug);
                                }
                            }
                            ?>
                            <div class="select-container">
                                <?php echo stk_construct_taxonomy_select_field($taxonomy, $selected_arr, $post_type, $placeholder); ?>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        <?php endforeach; ?>
                        <?php // this submit button is disables by default to prevent a blank form submit. see site-js for logic to enable ?>
                        <input id="filter-submit-button" disabled class="button one submit-button submit" type="submit"">
                        <?php if ($reset) : ?>
                            <a href="<?= $reset; ?>" class="view-all">Reset</a>
                        <?php endif; ?>
                    </div>
                    <?php if ($include_search) : ?>
                        <div class="select-container search-container">
                            <input id="search-input" class="placeholder" type="text" name="s" placeholder="Search by name"/>
                            <i class="fas fa-search"></i>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</section>