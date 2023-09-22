<?php
/* Template Name: Archive esercizi */
get_header();
require_once __DIR__ .'/includes/esercizi.php';
get_template_part("template-parts/banner-small");
$objPost = get_queried_object();

$video = get_field("video_gallery");
//print_r($video);
?>
<div id="page" class="main mt-5">
    <div class="container w-100 mb-5">
        <div class="row pb-5">
            <div class="col-lg-8">
                <?php if(!empty(get_field("titolo_uno"))):?>
                <h1 class="title-bloc fs-1 fw-bold mt-5 mb-3"><?php echo get_field("titolo_uno"); ?></h1>
                <?php endif;?>
                <h5 class="subtitle text-uppercase"><?php echo get_field('sottotitolo_uno'); ?></h5>
                <?php if(!empty(get_field("paragrafo_uno",$objPost))):?>
                <div class="mt-4 mb-5"><?php echo get_field("paragrafo_uno",$objPost); ?></div>
                <?php endif;?>
            </div>
        </div>

        <div class="row row-video-gallery">
            <?php
            foreach ($video as $k => $v)  get_template_part("template-parts/card-video", 'card-video', ["video" => $v, "view_taxonomy" => true]);
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
