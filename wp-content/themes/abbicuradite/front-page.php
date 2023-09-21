<?php get_header();
require_once __DIR__ .'/includes/esercizi.php';
global $wpdb;
$current_user = wp_get_current_user();
$dataTestUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $current_user->ID");
?>
<?php get_template_part("template-parts/etichetta-menu-valutazione", 'etichetta-menu-valutazione', ["user" => $dataTestUser]);?>

<?php get_template_part("template-parts/banner");?>
<div class="main-content-home">
    <div class="container-fluid bloc-content progetto">
        <div class="container mb-5 pt-5 bloc-content">
            <div class="row mt-5">
                <div class="col-sm-6" id="nostro-progetto">
                    <h1 class="title-bloc fs-1 fw-bold"><?php echo get_field("titolo_uno"); ?></h1>
                    <h5 class="pt-2 subtitle text-uppercase"><?php echo get_field("sottotitolo_uno"); ?></h5>
                    <p class="pt-3"><?php echo get_field("paragrafo_uno"); ?></p>
                    <!--a class="btn-scopri text-white" href="#tutti-i-rischi">Scopri tutti i rischi</a-->
                </div>
                <div class="col-sm-6">
                    <iframe class="w-100" height="315" src="<?php echo get_field("video_progetto");?>" title="<?php echo get_field("titolo_uno");; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
            <div class="row row-step mt-5">
                <h1 class="title-bloc fs-1 fw-bold mb-5"><?php echo get_field("titolo_due"); ?></h1>
                <div class="col col-12 col-sm-6 col-md-4 col-lg-4">
                    <a class="title-step text-uppercase fw-bold" href="<?php echo $link_questionario; ?>">
                        <img class="step" src="<?php echo get_theme_file_uri('/images/step1.png'); ?>" alt="step1">
                    </a>
                    <div class="text">
                        <a class="title-step text-uppercase fw-bold" href="<?php echo $link_questionario; ?>">
                            <span class=""><?php echo get_field("passi_uno"); ?></span>
                        </a>
                        <p class="mt-2"><?php echo get_field("descrizione_uno"); ?></p>
                    </div>
                </div>

                <div class="col col-12 col-sm-6 col-md-4 col-lg-4">
                    <a class="title-step text-uppercase fw-bold" href="#tutti-i-rischi">
                        <img class="step" src="<?php echo get_theme_file_uri('/images/step2.png'); ?>" alt="step2">
                    </a>
                    <div class="text">
                        <a class="title-step text-uppercase fw-bold" href="#tutti-i-rischi">
                            <span class="ps-2"><?php echo get_field("passi_due"); ?></span>
                        </a>
                        <p class="mt-2"><?php echo get_field("descrizione_due"); ?></p>
                    </div>
                </div>

                <div class="col col-12 col-sm-6 col-md-4 col-lg-4">
                    <a class="title-step text-uppercase fw-bold" href="<?php if(is_user_logged_in() && $dataTestUser){echo site_url('/area-test'); }elseif(is_user_logged_in() && !$dataTestUser){echo site_url('/valutazione/questionario');} else{echo site_url('/test'); } ?>">
                        <img class="step" src="<?php echo get_theme_file_uri('/images/step3.png'); ?>" alt="step3">
                    </a>
                    <div class="text">
                        <a class="title-step text-uppercase fw-bold" href="<?php if(is_user_logged_in() && $dataTestUser){echo site_url('/area-test'); }elseif(is_user_logged_in() && !$dataTestUser){echo site_url('/valutazione/questionario');} else{echo site_url('/test'); } ?>">
                            <span class="ps-2"><?php echo get_field("passi_tre"); ?></span>
                        </a>
                        <p class="mt-2"><?php echo get_field("descrizione_tre"); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-white bloc-content mb-5">
        <div class="container">
            <div class="row mt-5" id="tutti-i-rischi">
                <h1 class="title-bloc fs-1 fw-bold"><?php echo get_field("titolo_tre"); ?></h1>
                <h5 class="subtitle p-2 text-uppercase"><?php echo get_field("sottotitolo_tre"); ?></h5>
                <p><?php echo get_field("paragrafo_tre"); ?></p>
                <?php
                   $args = array(
                        'taxonomy' => 'area-rischio',
                        'orderby' => 'name',
                        'order'   => 'ASC'
                    );
                   $cats = get_categories($args);
                   foreach($cats as $cat) : $titleArea = strtoupper($cat->slug);  ?>
                       <div class="col col-md-6 col-lg-3 my-3">
                           <a href="<?php echo get_category_link( $cat->term_id );  ?>" class="text-decoration-none">
                           <div class="card front-page card_<?php echo $titleArea; ?>">
                               <div class="d-flex justify-content-center headerCard ">
                                   <div class="cardImgTitle  align-items-center <?php echo $titleArea; ?> ">
                                       <img src="<?php echo get_theme_file_uri('/images/icona-'.strtolower($titleArea).'.png'); ?>" class="card-img-top mx-auto" alt="IMG">
                                   </div>
                                   <div class="cardTitle p-2 w-100 <?php echo $titleArea; ?>">

                                            <span class="text-white fw-bold">
                                            <?php echo get_field("titoletto_header", $cat); ?>
                                                <br>
                                            <?php echo get_field("titolo_header", $cat); ?>
                                            </span>
                                           <?php /*<p class="text-white fw-bold"><?php echo $cat->description ;  ?></p>*/?>

                                   </div>
                               </div>
                               <div  class="w-100 img-front-page" style="background-image: url(<?php echo get_theme_file_uri('/images/'.strtolower($titleArea).'.jpg');?>)"></div>
                               <div class="card-footer p-3 text-center <?php echo $titleArea; ?>">
                                   <div class="btn-detail ps-3 pe-3 pt-1 pb-1 text-white">Scopri di più</div>
                               </div>
                           </div>
                           </a>

                       </div>
                   <?php endforeach;  ?>
                </div>
        </div>
    </div>
    <a href="<?php echo site_url('/test')?>" class="text-decoration-none w-100">
        <div class="container-fluid mb-5 bloc-content test-tax">
            <div class="container bloc-content">
                <div class="row align-items-center">
                    <div class=" py-5 d-flex justify-content-between">
                        <div class="col-12 col-lg-10">
                            <h2 class="text-white fw-bold text-uppercase">Mettiti alla prova con i nostri test</h2>
                        </div>
                        <div class="col-12 col-lg-2 text-end">
                            <button class="btn-test-tax btn-scopri mx-auto">Scopri di più</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <?php /*
    <div class="container-fluid bg-white bloc-content">
       <div class="container mt-5 bloc-content mb-5">
            <div class="row align-items-center">
                <h1 class="title-bloc fs-1 fw-bold mt-3"><?php echo get_field("titolo_quarto"); ?></h1>
                <div class="d-flex justify-content-between">
                    <div class="col-6 col-lg-6">
                        <h5 class="subtitle py-2 text-uppercase"><?php echo get_field("sottotitolo_quarto"); ?></h5>
                    </div>
                    <div class="col-6 col-lg-6 text-end mb-3">
                        <a class="btn-test-tax btn-border-radius-bleu mx-auto" href="<?php echo site_url('/esercizi')?>"><?php echo get_field("button_esercizi"); ?></a>
                    </div>
                </div>
                <p><?php echo get_field("paragrafo_quarto"); ?></p>
            </div>
            <div class="row mt-5 mb-5">
                <?php exercise(4);?>
            </div>
        </div>
    </div>
     */?>
</div>
<?php /*<div class="container mb-5 mt-5">
    <div class="row align-items-center">
        <div class="col-6">
            <img src="<?php echo get_theme_file_uri('/images/img-ente.png'); ?>" class="img-ente mx-auto" alt="IMG">
        </div>
        <div class="col-6">
            <h1 class="title-bloc fw-bold text-uppercase"> Ente Bilaterale del Terziario</h1>
            <h5 class=" subtitle  text-uppercase"> nasce per sostenere e valorizzare gil operatori del settore con l'obiettivo di accrescere la professionalità, l'innovazione e la competitività.</h5>
            <p>Supporta le azienda e i lavoratori con servizi concordati dalle
            organisazzazini sindacali. I servizi offerti riguardano: formazione, sicurezza sul lavoro, fondi di solidarità, conciliazioni su vertenze di lavoro, ricerca e offerta lavorativa, apprendistato e osservatorio.
            </p>
            <div class="mt-4">
                <a class="btn-test-tax btn-border-radius-bleu " href="https://www.ebtumbria.it/" target="_blank">Scopri di più</a>

            </div>
        </div>
    </div>
</div> */?>
<?php  get_footer(); ?>