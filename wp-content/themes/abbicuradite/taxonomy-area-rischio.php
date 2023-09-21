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
$id_page_esercizi = 368;
$id_page_test = 344;

global $wpdb;
$current_user = wp_get_current_user();
$dataTestUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $current_user->ID");
?>
<?php get_template_part('template-parts/etichetta-menu-valutazione', 'etichetta-menu-valutazione', ['user' => $dataTestUser]); ?>

<div class="banner-page banner-inside position-relative pt-5 pb-5" style="background-image: url('<?php echo get_field('banner', $termTaxonomy); ?>');">
    <div class="bannerShadow position-absolute"></div>
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-12 col-sm-9">
                <h2 class="title-banner text-uppercase fw-bold text-white mb-3"><?php echo get_field('titoletto_header', $termTaxonomy); ?></h2>
                <h1 class="title-banner text-uppercase fw-bold text-white mb-3"><?php echo get_field('titolo_header', $termTaxonomy); ?></h1>
                <h3 class="title-banner text-white mb-3"><?php echo get_field('sottotitolo_header', $termTaxonomy); ?></h3>
                <div class="btn-single-pg-aree d-flex mt-5">
                    <a class="btn-scopri text-white" href="#sfoglia-le-slide"><?php echo get_field('btn1', $termTaxonomy); ?></a>
                    <a class="btn-scopri text-white" href="#i-nostri-test"><?php echo get_field('btn2', $termTaxonomy); ?></a>
                    <a class="btn-scopri text-white" href="#esercizi-e-consigli" ><?php echo get_field('btn3', $termTaxonomy); ?></a>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
// get_template_part("template-parts/banner-questionario-valutazione");
$titleArea = strtoupper($term->slug);
$objPost = get_queried_object(); ?>
<div class="main-content-tax" id="sfoglia-le-slide">
    <div class="container-fluid content">
        <div class="container pt-5">
            <div class="row align-items-center py-5">
                <div class="col detail-tax">
                    <h1 class="title-bloc fs-1 fw-bold"><?php echo get_field('titolo_descrizione', $termTaxonomy); ?></h1>
                    <h5 class="subtitle text-uppercase"><?php echo get_field('sottotitolo_descrizione', $termTaxonomy); ?></h5>
                    <div class="pt-1"><?php echo get_field('testo_descrizione', $termTaxonomy); ?></div>
                </div>
                <div class="col text-center">
                    <a href="" class="btn-detail-documento ps-3 pe-3 pt-1 pb-1 text-white text-uppercase" data-area="testCarousel<?php echo $titleArea; ?>" data-tax="<?php echo $titleArea; ?>" data-bs-toggle="modal" data-bs-target="#docModal<?php echo $titleArea; ?>">
                        <img src="<?php echo $ebookImg['url']; ?>" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php ModalStudio($term); ?>
    <div class="container-fluid mb-5 bloc-content test-tax">
        <div class="container bloc-content">
            <div class="row align-items-center">
                <div class=" py-5 d-flex justify-content-between">
                    <div class="col-12 col-lg-9">
                        <h2 class="text-white fw-bold text-uppercase"><?php echo get_field('titolo_banner_preview', $id_page_test); ?></h2>
                    </div>
                    <div class="col-12 col-lg-3 text-end">
                        <a class="btn-test-tax btn-border-radius-bleu mx-auto" href="#i-nostri-test"><?php echo get_field('cta_banner_preview', 344); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid content bg-white">
        <div class="container mb-5">
            <div class="row my-5">
                <div class="col-12">
                    
                    <h1 class="title-bloc fs-1 fw-bold mb-4" id="i-nostri-test"><?php echo get_field('testo_banner_preview', $id_page_test); ?></h1>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                $valueGet = getTestUserBySector();
                $sectorCurrentUser = $valueGet['sectorCurrentUser'];
                while (have_posts()) {
                    the_post();
                    if ($post->post_type === 'esercizi') {
                        continue;
                    }
                    $sectors = get_field('settore');
                    $allTest = AllTestBySector($sectors, $sectorCurrentUser, $valueGet);
                    $args = ['term' => $term];
                    if ($allTest['has_sector'] && is_user_logged_in()) { ?>
                    <div class="col col-sm-6 col-lg-4 my-3">
                        <?php get_template_part('template-parts/card-test-User', '', $args); ?>
                    </div>
                    <?php } elseif (!is_user_logged_in() || (is_user_logged_in() && current_user_can('administrator'))) { ?>
                    <div class="col col-sm-6 col-lg-4 my-3">
                        <?php get_template_part('template-parts/card-test', '', $args);
                        break; ?>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php /*
    <div class="container-fluid content pb-5">
        <div class="container pt-5">
            <div class="row">
                <h1 class="title-bloc fs-1 fw-bold mt-5" id="esercizi-e-consigli"><?php echo get_field('titolo_box_area_rischio', $id_page_esercizi); ?></h1>
                <h5 class="p-2 subtitle text-uppercase"><?php echo get_field('sottotitolo_box_area_rischio', $id_page_esercizi); ?></h5>
                <p><?php echo get_field('descrizione_box_area_rischio', $id_page_esercizi); ?></p>
            </div>
            <div class="row esercizi">
                <?php $titleArea = $term->slug;
exercise(6, $titleArea); ?>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row align-items-center bloc-footer-rischio">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 py-3">
                    <img src="<?php echo get_field('immagine_banner', $id_page_esercizi); ?>" alt="" class="w-100"/>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <h1 class="title-bloc fs-1 fw-bold text-white"><?php echo get_field('titolo_immagine_banner', $id_page_esercizi); ?></h1>
                    <h5 class="pt-2 text-white"><?php echo get_field('descrizione_immagine_banner', $id_page_esercizi); ?></h5>
                </div>
            </div>
        </div>
    </div>
    */?>
</div>
<?php get_footer(); ?>