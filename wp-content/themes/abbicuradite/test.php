<?php /* Template Name: Archive test */
get_header();
require_once __DIR__ .'/includes/SectorTest.php';
require_once __DIR__ .'/includes/TrueAnswersTest.php';
require_once __DIR__ .'/includes/AllTestBySector.php';
require_once __DIR__ .'/includes/Card.php';
$userId= get_current_user_id();
$userInfo = get_userdata( $userId);
$userMeta = get_user_meta( $userId);
?>
<?php get_template_part("template-parts/banner"); ?>
<div class="main-content-test">
    <div class="container w-100 mb-5">
        <h1 class="title-bloc fs-1 fw-bold mt-5 mb-3"><?php echo get_field("titolo_uno"); ?></h1>
        <p class="mb-5"><?php echo get_field("paragrafo_uno"); ?></p>
        <div class="row row-cols-1 row-cols-md-3 g-4">

            <?php
            $sectorUser= $userMeta['sector'][0];
            Card($sectorUser);
            ?>
        </div>
    </div>
</div>
<?php get_footer();
