<?php
require_once 'SectorTest.php';
function Card($sectorUser)
{
    $valueGet = getTestUserBySector();
    $sectorCurrentUser = $valueGet['sectorCurrentUser'];
    $loop = $valueGet['loop'];

    $terms_array = [];
    while ($loop->have_posts()) {
        $loop->the_post();
        $terms = get_the_terms(get_the_ID(), 'area-rischio');
        $sectors = get_field('settore'); // sector selected for the test
        $allTest = AllTestBySector($sectors, $sectorCurrentUser, $valueGet); ?>
        <?php if (!empty($terms)) {
            $term = $terms[0] ?? new WP_Term();
            if ($allTest['has_sector'] && is_user_logged_in()) { ?>
                <div class="col col-sm-6 col-lg-4 my-3">
                    <?php get_template_part('template-parts/card-test-User', null, ['term' => $term]); ?>
                </div>
            <?php } elseif (!is_user_logged_in() || (is_user_logged_in() && current_user_can('administrator'))) {
                // unique Card for each Area rischio
                if (in_array($term->term_id, $terms_array)) {
                    continue;
                }
                $terms_array[] = $term->term_id;
                ?>
                <div class="col col-sm-6 col-lg-3 my-3">
                    <?php
                    get_template_part('template-parts/card-test', null, ['term' => $term]); ?> 
                </div>
            <?php }
            }?>
   <?php }

    wp_reset_postdata();
}
