<?php
get_header();
$domande = get_field("domande");
$terms = get_the_terms(get_the_ID(), "area-rischio");
$term = $terms[0] ?? new WP_Term();
$termSLink = get_term_link($term,"area-rischio");
$userId= get_current_user_id();
$titleArea = strtoupper($term->slug); ?>
<div class="main quiz quiz_test quiz_<?php echo $titleArea;  ?>">
    <div class="container p-5 d-flex justify-content-center">
        <div class="row mt-5 ">
            <div class="col-sm-12 col-md-3">
                <?php
                while(have_posts()):
                the_post();
                ?>
                    <div class="text-center w-50">
                        <img src="<?php echo get_theme_file_uri('/images/icona-'.strtolower($titleArea).'.png'); ?>" class="mx-auto" alt="IMG">
                        <div class="h_line w-100"></div>
                        <div class="w-100 <?php echo $titleArea; ?>">
                            <span class="text-white fw-bold"><?php echo $titleArea; ?></span>
                        </div>
                        <div class="h_line w-100"></div>
                    </div>
                    <p class="fs-4 fw-bold pt-4 subtitle text-uppercase text-white text-bold"><?php the_title(); ?></p>
                <?php endwhile; ?>
            </div>
            <div class="col-sm-12 col-lg-9">
                <form action="" method="post" id="form-questionario" bclass="formTestRischi" enctype="multipart/form-data" data-url="<?php echo admin_url("admin-ajax.php"); ?>">
                    <div id="myCarousel" class="carousel slide mt-5" data-interval="false">
                        <div class="carousel-inner">
                            <input type="hidden" name="action" value="add_test_user">
                            <input type="hidden" name="userID" id="idUser" value="<?php echo $userId;?>">
                            <input type="hidden" name="idTest" id="idTest" value="<?php echo get_the_ID();?>">
                        <?php
                        $count = 0;
                        $numItems = count($domande);
                        foreach($domande as $domanda) : ?>
                        <div class="carousel-item request shadow-lg <?php if($count==0){ echo "active"; } else{ echo " "; }?>">
                            <div class="row h-100">
                                <div class="col-12 col-sm-6 questionario text-center h-100">
                                        <span class="fw-bold" data-id="<?php echo $count; ?>" ><?php echo $domanda["domanda"]."?"; ?></span>
                                        <input class="form-control title" name="title[]" type="hidden" value="<?php echo $count; ?>" />
                                    </div>
                                <div class="col-12 col-sm-6 risposte test" data-idQ="<?php echo $count; ?>" id="risposte<?php echo $count; ?>">
                                    <?php if(!empty($domanda["risposte"])) : ?>
                                        <?php
                                            $alphabet = range('A', 'Z');
                                            foreach($domanda["risposte"] as $key => $risposta) : ?>
                                            <div class="form-check">
                                                <label class="w-100">
                                                    <span class="wpcf7-form-control-wrap w-100">
                                                        <span class="wpcf7-form-control wpcf7-radio w-100">
                                                            <span class="wpcf7-list-item first last w-100">
                                                                <input class="form-check-input answer test risposte<?php echo $count; ?> w-100" data-valueQuestion="<?php echo $domanda["domanda"];?>" data-user="<?php echo $userId; ?>" type="radio" data-id="<?php echo $count; ?>" name="answer-<?php echo $count.$key; ?>"
                                                                       data-idAnswer="<?php echo $key;?>" value="<?php echo $risposta["testo_risposta"]; ?>">
                                                                <span class="wpcf7-list-item-label w-100">
                                                                    <span class="fw-bold alpha">
                                                                        <?php echo $alphabet[$key].'. '; ?>
                                                                    </span>
                                                                    <?php echo $risposta["testo_risposta"]; ?>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <div class="contentBtn">
                                        <a class="ps-3 pe-3 pt-2 pb-2 text-white text-uppercase" data-bs-target="#myCarousel" data-bs-slide="prev" href="#">Precedente</a>
                                        <?php if($count === $numItems-1) :?>
                                            <a class="btn-send ps-3 pe-3 pt-2 pb-2 text-white" href="#" data-user="<?php echo $userId; ?>">INVIA</a>
                                        <?php else: ?>
                                            <a class="btn-avanti ps-3 pe-3 pt-2 pb-2 text-white text-uppercase" data-count-item="<?php echo $numItems-1;?>" data-count="<?php echo $count;?>" data-bs-target="#myCarousel" data-bs-slide="next" href="#">Vai avanti</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        $count++;
                    endforeach; ?>
                </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <!--button-- class="carousel-control-next text-center text-center mt-5 mb-5" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon " aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button-->
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    get_footer();
