<div class="banner-page banner-small py-5" style="background-image: url(<?php the_field('banner'); ?>)">
    <div class="bannerShadow position-absolute"></div>
    <div class="container py-5">
        <div class="row align-items-end py-5">
            <div class="col-12 col-sm-9">
                <h1 class="text-uppercase  text-white fw-bold"><?php echo get_field("title"); ?></h1>
                <h3 class="title-banner text-uppercase  text-white mb-3"><?php echo get_field("sottotitolo"); ?></h3>
                <p class="text-white "><?php echo get_field("paragrafo"); ?></p>
                <div class="btn-single-pg-aree mt-5">
                    <a class="btn-scopri px-4 py-2 text-white" href="#page"><?php echo get_field("btn1"); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>