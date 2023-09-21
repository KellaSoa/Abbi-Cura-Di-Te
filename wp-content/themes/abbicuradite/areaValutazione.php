<?php /* Template Name: Area valutazione */
get_header();
canAreaRiservata();
get_template_part("template-parts/banner-area-riservata");
?>
<div class="main-content-area-riservata mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <?php get_template_part("template-parts/navbar-area-riservata"); ?>
            </div>
            <div class="col-9 contentPageArea">
                <?php get_template_part("template-parts/valutazione"); ?>
                <div class="row">
                    <div class="btn-single-pg-aree mt-5 mb-5 ">
                        <a class="btn-scopri ps-3 pe-3 pt-2 pb-2 text-white fw-bold" href="<?php echo site_url('/area-studio');?>">Sfoglia i materiali informativi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
