<?php
/* Template Name: Archive esercizi */
get_header();
require_once __DIR__ .'/includes/esercizi.php';
get_template_part("template-parts/banner-small");
$objPost = get_queried_object();

$video = get_field("video_gallery");

?>
<div id="page" class="main mt-5">
    <div class="container w-100 mb-5">
        <div class="row pb-5">
            <div class="col-lg-8">
                <?php if(!empty(get_field("titolo_uno"))):?>
                <h1 class="title-bloc fs-1 fw-bold mt-5 mb-3"><?php echo get_field("titolo_uno"); ?></h1>
                <?php endif;?>
                <?php if(!empty(get_field("paragrafo_uno",$objPost))):?>
                <p class="mb-5"><?php echo get_field("paragrafo_uno",$objPost); ?></p>
                <?php endif;?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row row-video-gallery">
                    <?php foreach ($video as $k => $v) :?>
                        <div class="col-sm-6 col-md-4">
                            <h4 class="text-uppercase"><?php echo $v['titolo_video_youtube']?></h4>
                            <div class="pb-3"><?php echo $v['caption_video_youtube']?></div>
                            <?php echo $v['link_video_youtube']?>
                            <div><?php
                                //echo $v['area_di_rischio_video_youtube'];
                                $terms = get_the_terms($v['area_di_rischio_video_youtube'], "area-rischio");

                                ?></div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>

        </div>

    </div>
</div>
<?php get_footer(); ?>
