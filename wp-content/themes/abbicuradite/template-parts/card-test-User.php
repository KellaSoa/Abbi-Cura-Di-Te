<?php
$term = $args['term'];
$titleArea = strtoupper($term->slug);
$domande = get_field("domande");
$valueTrueAnswers = getTrueAnswers($domande,get_the_ID());
?>
<a class="text-decoration-none" href="<?php the_permalink();  ?>">
    <div class="card card-test test-page <?php echo $titleArea;  ?> card_<?php echo $titleArea;  ?> h-100" style="max-width: 100%">
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
            <p class="text-white fw-bold text-uppercase text-center" data-id="<?php the_ID();?>"><?php the_title();?> </p>
        </div>
        <?php if (isset($valueTrueAnswers['percent']) && $valueTrueAnswers['dataTestUser']): ?>
        <div class="card-footer p-3 text-center <?php echo $titleArea; ?> mt-auto footer-result ">
            <?php
            $message = showMessage($valueTrueAnswers['percent']);
            ?>
            <div class="card-pre-footer d-flex text-center <?php echo $message["textColor"]; ?>">

                    <div class="circle <?php echo $message["bgColor"]; ?> me-2"></div>
                    <p class="fw-bold text-uppercase m-0 pt-1 pe-2">
                        Risultato : <span class="<?php echo $message["textColor"]; ?>"><?php echo round($valueTrueAnswers['percent']) .'%';?></span>
                    </p>
            </div>
            <button class="btn-detail ps-3 pe-3 pt-1 pb-1 text-white ">
                <span class="<?php //echo $message["textColor"]; ?>">Ripeti il test</span>
            </button>
        </div>
        <?php else:?>
        <div class="card-footer p-3 text-center <?php echo $titleArea; ?> mt-auto  ">
            <button class="btn-detail ps-3 pe-3 pt-1 pb-1 text-white">Fai il test</button>
        </div>
        <?php endif;?>
    </div>
</a>
