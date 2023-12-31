<?php
get_header();
require_once __DIR__.'/includes/SectorTest.php';
require_once __DIR__.'/includes/TrueAnswersTest.php';
require_once __DIR__.'/includes/AllTestBySector.php';
require_once __DIR__.'/includes/Card.php';
require_once __DIR__.'/includes/ModalStudio.php';
require_once __DIR__.'/includes/esercizi.php';

global $post;
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$termTaxonomy = get_queried_object();
// vars ACF
$ebookImg = get_field('ebook', $termTaxonomy);
$title = get_field('title', $termTaxonomy);
$content = get_field('content', $termTaxonomy);
$title2 = get_field('titolo_due', $termTaxonomy);
$userId = get_current_user_id();
$userInfo = get_userdata($userId);
$userMeta = get_user_meta($userId);
//$id_page_esercizi = 368;
$id_page_test = 344;
$objPost = get_queried_object();

global $wpdb;
$current_user = wp_get_current_user();
$dataTestUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $current_user->ID");

$video = get_field("video_gallery", 609);
$video_area = [];
foreach ($video as $i => $item) {
    if(!empty($item['area_di_rischio_video_youtube']) && $item['area_di_rischio_video_youtube']->term_id == $objPost->term_id) $video_area[] = $item;
}

$titoletto_header = get_field('titoletto_header', $termTaxonomy);
$titolo_header = get_field('titolo_header', $termTaxonomy);
$sottotitolo_header = get_field('sottotitolo_header', $termTaxonomy);
$titleArea = strtoupper($term->slug);
$titolo_descrizione = get_field('titolo_descrizione', $termTaxonomy);
$sottotitolo_descrizione = get_field('sottotitolo_descrizione', $termTaxonomy);
$testo_descrizione = get_field('testo_descrizione', $termTaxonomy);
?>
<?php get_template_part('template-parts/etichetta-menu-valutazione', 'etichetta-menu-valutazione', ['user' => $dataTestUser]); ?>

<div class="main-content-tax" id="sfoglia-le-slide">
    <div class="container-fluid content">
        <div class="container">
            <div class="row align-items-center py-5">
                <div class="col-sm-6 detail-tax py-3">
                    <?php if(!empty($titoletto_header)):?>
                        <h2 class="title-banner text-uppercase fw-bold mb-3"><?php echo $titoletto_header; ?></h2>
                    <?php endif;?>
                    <?php /*if(!empty($titolo_header)):?>
                        <h1 class="title-bloc fs-1 fw-bold"><?php echo $titolo_header; ?></h1>
                    <?php endif;?>
                    <?php if(!empty($sottotitolo_header)):?>
                        <h5 class="subtitle text-uppercase"><?php echo $sottotitolo_header; ?></h5>
                    <?php endif;*/?>

                    <?php if(!empty($titolo_descrizione)):?>
                    <h1 class="title-bloc fs-1 fw-bold"><?php echo $titolo_descrizione; ?></h1>
                    <?php endif;?>
                    <?php if(!empty($sottotitolo_descrizione)):?>
                    <h5 class="subtitle text-uppercase"><?php echo $sottotitolo_descrizione; ?></h5>
                    <?php endif;?>
                    <?php if(!empty($testo_descrizione)):?>
                    <div class="pt-1 pb-2"><?php echo $testo_descrizione; ?></div>
                    <?php endif;?>
                    <div class="mt-4">
                        <a href="" class="btn-scopri" data-area="testCarousel<?php echo $titleArea; ?>" data-tax="<?php echo $titleArea; ?>" data-bs-toggle="modal" data-bs-target="#docModal<?php echo $titleArea; ?>">
                            Sfoglia il documento
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 text-center py-5 py-md-2">
                    <a href="" class="btn-detail-documento ps-3 pe-3 pt-1 pb-1 text-white text-uppercase" data-area="testCarousel<?php echo $titleArea; ?>" data-tax="<?php echo $titleArea; ?>" data-bs-toggle="modal" data-bs-target="#docModal<?php echo $titleArea; ?>">
                        <img src="<?php echo $ebookImg['url']; ?>" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php ModalStudio($term); ?>

    <?php if(!empty($video_area)):?>
    <div class="container my-5">
        <div class="row align-items-center mt-3 mb-5 justify-content-center">
            <div class="col-12 text-center">
                <h1 class="title-bloc fs-1 fw-bold"><?php echo get_field("titolo_blocco_video", $termTaxonomy); ?></h1>
                <h5 class="subtitle py-2 text-uppercase"><?php echo get_field("sottotitolo_blocco_video", $termTaxonomy); ?></h5>
                <p><?php echo get_field("descrizione_blocco_video", $termTaxonomy); ?></p>
            </div>
        </div>
        <div class="row row-video-gallery justify-content-center">
            <?php
            foreach ($video_area as $k => $v) {
                get_template_part("template-parts/card-video", 'card-video', ["video" => $v, "view_taxonomy" => false]);
            }
            ?>
        </div>
        <div class="row">
            <?php if(!empty(get_field("bottone_blocco_video", $termTaxonomy))):?>
                <div class="col-12 text-center">
                    <a class="btn-test-tax btn-border-radius-bleu mx-auto" href="<?php echo site_url('/video-gallery')?>"><?php echo get_field("bottone_blocco_video", $termTaxonomy); ?></a>
                </div>
            <?php endif;?>
        </div>
    </div>
    <?php endif;?>
    <div class="container-fluid mb-5 bloc-content test-tax">
        <div class="container bloc-content">
            <div class="row align-items-center py-5">
                    <div class="col-12 col-lg-9">
                        <h2 class="text-white fw-bold text-uppercase"><?php echo get_field('titolo_banner_preview', $id_page_test); ?></h2>
                    </div>
                    <div class="col-12 col-lg-3 text-center py-3">
                        <a class="btn-test-tax btn-border-radius-bleu mx-auto" href="#i-nostri-test"><?php echo get_field('cta_banner_preview', 344); ?></a>
                    </div>
            </div>
        </div>
    </div>
    <div class="container-fluid content bg-white">
        <div class="container mb-5">
            <div class="row my-5  justify-content-center">
                <div class="col-12 text-center">

                    <h1 class="title-bloc fs-1 fw-bold mb-4" id="i-nostri-test"><?php echo get_field('testo_banner_preview', $id_page_test); ?></h1>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                <?php
                $args_rischio = [
                    'post_type' => 'test',
                    'orderby' => 'ID',
                    'order' => 'ASC',
                    'tax_query' => [
                        [
                            'taxonomy' => 'area-rischio',
                            'field' => 'slug',
                            'terms' => $term->slug,
                        ],
                    ],
                ];

                $query = new WP_Query($args_rischio);

                $valueGet = getTestUserBySector();
                $sectorCurrentUser = $valueGet['sectorCurrentUser'];
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        if ($post->post_type === 'esercizi') {
                            continue;
                        }
                        $sectors = get_field('settore');
                        $allTest = AllTestBySector($sectors, $sectorCurrentUser, $valueGet);
                        $args = ['term' => $term];
                        if ($allTest['has_sector'] && is_user_logged_in()) { ?>
                            <div class="col col-sm-6 col-lg-4 my-3">
                                <?php get_template_part('template-parts/card-test-User', '', $args);
                            break; ?>
                            </div>
                            <?php } elseif (!is_user_logged_in() || (is_user_logged_in() && current_user_can('administrator'))) { ?>
                            <div class="col col-sm-6 col-lg-4 my-3">
                                <?php get_template_part('template-parts/card-test', '', $args);
                                break; ?>
                            </div>
                        <?php }
                            }
                } else {
                    echo 'Non è disponibile alcun test';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
