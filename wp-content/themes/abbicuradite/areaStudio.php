<?php /* Template Name: Area studio */
get_header();
canAreaRiservata();
require_once __DIR__.'/includes/ModalStudio.php';
require_once __DIR__.'/includes/SectorTest.php';
require_once __DIR__.'/includes/AllTestBySector.php';

get_template_part('template-parts/banner-area-riservata');
?>
<div class="main-content-tax mt-5">
<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-12 col-md-3 mb-5">
            <?php get_template_part('template-parts/navbar-area-riservata'); ?>
        </div>
        <div class="col-sm-12 col-md-9 contentPageArea">
            <h1 class="title-bloc fs-1 fw-bold mb-5">Consulta i documenti per sapere di più</h1>
            <?php $loop = new WP_Query($args); ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                $valueGet = getTestUserBySector();
$sectorCurrentUser = $valueGet['sectorCurrentUser'];
$loop = $valueGet['loop'];
$valueTerm = [];
$arrayAreaRischio = [];
// get all area di rischio by sector user in arrayAreaRischio
                while ($loop->have_posts()) {
                    $loop->the_post();
                    $terms = get_the_terms(get_the_ID(), 'area-rischio');
                    $sectors = get_field('settore'); // sector selected for the test
                    $allTest = AllTestBySector($sectors, $sectorCurrentUser, $valueGet);
                    if (!empty($terms)) {
                        $term = $terms[0] ?? new WP_Term();
                        $titleArea = strtoupper($term->slug);
                        if ($allTest['has_sector'] && is_user_logged_in()) {
                            $valueTerm[] = $term;
                            $arrayAreaRischio[] = $term->slug;
                        }
                    }
                    ModalStudio($term);
                }
                $arrayRischios = array_unique($arrayAreaRischio);
                // show img materiali formativi
                foreach ($arrayRischios as $key => $arrayRischio) {
                    $terms = get_the_terms(get_the_ID(), 'area-rischio');
                    $titleArea = strtoupper($arrayRischio);
                    $ebook = get_field('ebook', $valueTerm[$key]); ?>
                    <div class="col col-sm-6 col-lg-4 my-3">
                        <a href="" class="btn-detail-documento ps-3 pe-3 pt-1 pb-1 text-white text-uppercase" data-area="testCarousel<?php echo $titleArea; ?>" data-tax="<?php echo $titleArea; ?>" data-bs-toggle="modal" data-bs-target="#docModal<?php echo $titleArea; ?>">
                            <img src="<?php echo $ebook['url']; ?>" alt="">
                        </a>
                    </div>
                <?php }
wp_reset_postdata(); ?>
            </div>
        </div>
        <div class="mt-5"></div>
    </div>
    <div class="row align-items-center linktest  my-5">
        <div class="col-3"></div>
        <div class="col-9">
            <div class=" py-5 d-flex justify-content-between">
                <h2 class="text-white fw-bold text-uppercase">Testa le tue conoscenze</h2>
                <a class="btn-test-tax btn-border-radius-bleu mx-auto" href="<?php echo site_url('/area-test'); ?>">Mettiti alla prova</a>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
