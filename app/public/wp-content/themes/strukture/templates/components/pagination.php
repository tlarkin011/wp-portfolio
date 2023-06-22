<?php
global $wp_query;
$query = forge_var('query') ? forge_var('query')  : $wp_query;

// if there's only one page
// pagination will not show
$max = $query->max_num_pages;
if ( $max == 1 ) return;
?>
<section class="pagination-container navigation page-section section">
    <div class="row row-center">
        <div class="columns-10 pagination-column">

            <?php
            $pages = '';
            $current = max( 1, get_query_var( 'paged' ) );
            $total = 1;
            $page_links = paginate_links( [
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'format'       => '',
                'add_args'     => false,
                'current'      => $current,
                'total'        => $max,
                'prev_text'    => '&larr;',
                'next_text'    => '&rarr;',
                'type'         => 'array',
                'end_size'     => 1,
                'mid_size'     => 3,
                'prev_next'    => false
            ]  );
            ?>

            <?php if($current == 1 && !$max == 0): ?>
                <p class="prev-disabled"><i class="fa fa-angle-left" aria-hidden="true"></i>Previous</p>
            <?php else: ?>
                <?php echo get_previous_posts_link('<i class="fa fa-angle-left" aria-hidden="true"></i> ' . __('Previous')); ?>
            <?php endif; ?>
            <?php if (is_array($page_links)): ?>
                <div class="page-lists"><?php echo join($page_links); ?></div>
            <?php endif; ?>

            <?php if ($current == $max): ?>
                <p class="next-disabled">Next<i class="fa fa-angle-right" aria-hidden="true"></i></p>
            <?php else: ?>
                <?php echo get_next_posts_link(__('Next').'<i class="fa fa-angle-right" aria-hidden="true"></i>', $max); ?>
            <?php endif; ?>

        </div>
    </div>
</section>