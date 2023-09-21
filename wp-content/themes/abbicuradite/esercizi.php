<?php
/* Template Name: Archive esercizi */
get_header();
require_once __DIR__ .'/includes/esercizi.php';
get_template_part("template-parts/banner");
$objPost = get_queried_object();
?>
<div class="main mt-5">
    <div class="container w-100 mb-5">
        <h1 class="title-bloc fs-1 fw-bold mt-5 mb-3"><?php echo get_field("titolo_uno"); ?></h1>
        <p class="mb-5"><?php echo get_field("paragrafo_uno",$objPost); ?></p>
        <div class="row esercizi">
            <?php exercise(12);?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
