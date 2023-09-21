<?php /* Template Name: Area test */
get_header();
require_once __DIR__ .'/includes/SectorTest.php';
require_once __DIR__ .'/includes/TrueAnswersTest.php';
require_once __DIR__ .'/includes/AllTestBySector.php';
require_once __DIR__ .'/includes/Card.php';
canAreaRiservata();
global $wpdb;
$userId= get_current_user_id();
$dataValutazioneUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $userId");
$userInfo = get_userdata( $userId);
$userMeta = get_user_meta( $userId);
get_template_part("template-parts/banner-area-riservata");
$lastTest = isset( $_GET['idTest']) ? $_GET['idTest'] : '';
$domande = get_field("domande",$lastTest);
$valueTrueAnswers = getTrueAnswers($domande, $lastTest); ?>
<div class="main-content-area-riservata">
    <input type="hidden" class="lastTest" value="<?php echo $lastTest; ?>">
    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-sm-12 col-md-3 mb-5">
                <?php get_template_part("template-parts/navbar-area-riservata"); ?>
            </div>
            <div class="col-sm-12 col-md-9 contentPageArea">
                <?php if(!current_user_can('administrator') && !empty($dataValutazioneUser)):?>
                <div class="mb-5 pb-2">
                    <h1 class="title-bloc fs-1 fw-bold"><?php echo get_field("titolo_valutazione_test",get_the_ID()); ?> </h1>
                    <h5 class="pt-2 subtitle text-uppercase">
                        <?php echo get_field("sottotitolo_valutazione_test",get_the_ID()); ?>
                    </h5>
                    <?php get_template_part("template-parts/valutazione");?>
                </div>
                <?php endif; ?>


                <div id="area-test">
                    <h1 class="title-bloc fs-1 fw-bold"> <?php echo get_field("titolo_test",get_the_ID()); ?></h1>
                    <h5 class="pt-2 pb-5 subtitle text-uppercase">
                        <?php echo get_field("sottotitola_test");?>
                    </h5>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php
                        $sectorUser= $userMeta['sector'][0];
                        Card($sectorUser); ?>
                    </div>
                    <div class="row">
                        <div class="btn-single-pg-aree mt-5 mb-5 ">
                            <a class="btn-scopri ps-3 pe-3 pt-2 pb-2 text-white fw-bold" href="<?php echo site_url('/area-studio');?>">Sfoglia i materiali informativi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //show modal thanks after test
        jQuery(function($) {
            var lastTest = $(".lastTest").val();
            console.log(lastTest);
            if(lastTest !== "") {
                console.log("popup finish test");
                $("#success_message").modal("show");
            }
        });
    </script>
</div>
<?php
finishTest($valueTrueAnswers,$lastTest);
get_footer();