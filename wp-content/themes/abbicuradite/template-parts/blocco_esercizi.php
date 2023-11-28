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