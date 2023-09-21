<?php
$term=  $args['term'];
$titleArea = strtoupper($term->slug);
?>

<a class="text-decoration-none" href="<?php echo site_url('/login'); ?>">
    <div class="card card-test card_<?php echo $titleArea; ?> test-page <?php echo $titleArea;  ?> h-100" style="max-width: 100%;">
        <div class="headerCard h-100 w-100 text-center pt-3">
            <div class="text-center">
                <img src="<?php echo get_theme_file_uri('/images/icona-'.strtolower($titleArea).'.png'); ?>" class="mx-auto" alt="IMG">
                <div class="h_line"></div>
                <div class="w-100 text-center <?php echo $titleArea; ?>">
                    <span class="text-white fw-bold"><?php echo $titleArea; ?></span>
                </div>
                <div class="h_line"></div>
            </div>
        </div>
        <div class="underline"></div>
        <div class="card-body">
            <p class="text-white fw-bold text-uppercase text-center"><?php the_title(); ?> </p>
        </div>
        <div class="card-footer p-3 text-center <?php echo $titleArea; ?> mt-auto">
            <button class="btn-detail ps-3 pe-3 pt-1 pb-1 text-white">Fai il test</button>
        </div>
    </div>
</a>