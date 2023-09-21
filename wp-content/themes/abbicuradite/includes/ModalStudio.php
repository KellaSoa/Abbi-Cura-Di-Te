<?php
function ModalStudio($term)
{
    $titleArea = strtoupper($term->slug);
    ?>
<div class="modal fade docModal" id="docModal<?php echo $titleArea; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container flex-column justify-content-center align-items-center">
                    <div class="row text-center ">
                        <div class="closeDocModal text-uppercase">Chiudi
                            <span class="fw-bold" aria-hidden="true">X</span>
                        </div>
                    </div>
                    <?php
                    $isMob = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'));

                    if ($isMob) {
                        $images = get_field('slide_mobile', $term);
                    } else {
                        $images = get_field('slide_desktop', $term);
                    }
                    ?>
                    <div class="row">
                        <div id="testCarousel<?php echo $titleArea; ?>" data-tax="<?php echo $titleArea; ?>" data-count="<?php echo count($images); ?>" class="carousel slide d-none d-lg-block testCarousel" data-bs-touch="false" data-bs-interval="false" data-carousel="carousel<?php ?>">
                            <div class="carousel-inner">
                                <?php $count = 0;
                                     foreach ($images as $key => $image) { ?>
                                        <div class="carousel-item shadow-lg <?php if ($count == 0) {
                                            echo ' active';
                                        } else {
                                            echo ' ';
                                        }?>">
                                            <img class="d-block w-100 imgDocument img-fluid" src="<?php echo $image['url']; ?>">
                                            <div class="text-center mt-3">
                                                <p> <?php echo $image['description']; ?></p>
                                            </div>
                                        </div>
                                        <?php ++$count;
                                    }?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#testCarousel<?php echo $titleArea; ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true" style="background-image: url(<?php echo get_theme_file_uri('/images/icon/sliderModal-arrow-left.png'); ?>)"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next text-center text-center mt-5 mb-5" type="button" data-bs-target="#testCarousel<?php echo $titleArea; ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon " aria-hidden="true" style="background-image: url(<?php echo get_theme_file_uri('/images/icon/sliderModal-arrow-right.png'); ?>)"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>         

    
                    <div class="row">
                        <div class="numCarousel text-center "></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php } ?>
