
    <section role="banner" class="banner-wrapper search-banner">
        <div class="search-banner product-banner page_banner page-banner" <?php
            forge_bg(get_field('search_bg', 'option'));
         ?> >
            <div class="row-bottom row">

                <div class="content-container columns-8 content-column">
                    <div class="banner-content-box">
                        <div class="title-container">
                            <!-- subtitle -->
                            <h1>Search Results</h1>

                           

                        </div>
                    </div>

                       <?php forge_template('components/filter', ['taxonomies' => ['category'], 'post_type' => 'post']); ?>

                   
                </div>
            </div>
        </div>
    </section>

