<?php
get_header();
require_once __DIR__.'/includes/BlockValutazione.php';
require_once __DIR__.'/includes/BlockAnagrafici.php';
$domandeAnagrafici = get_field('domande_anagrafici');
$domande = get_field('valutazione');
$userId = get_current_user_id();
// get all Request and answers
$datas = [];
foreach ($domande as $d => $domanda) {
    $data['dommanda'] = $d;
    foreach ($domanda['risposte'] as $key => $risposta) {
        if ($risposta['fascia_verde']) {
            $colorAnswer = 'verde';
        }
        if ($risposta['fascia_giallo']) {
            $colorAnswer = 'giallo';
        }
        if ($risposta['fascia_arancione']) {
            $colorAnswer = 'arancione';
        }
        if ($risposta['fascia_rossa']) {
            $colorAnswer = 'rossa';
        }
        $arr = [
            'idQuestion' => $d,
            'idAnswer' => $key,
            'color' => $colorAnswer,
        ];
        array_push($datas, $arr);
    }
}

$id_page_valutazione = 290;
?>
<div class="main quiz">

    <div class="container p-5 d-flex justify-content-center">
        <?php
        while (have_posts()) {
            the_post();
            ?>
            <div class="row my-5">
                <div class="col-sm-8 mx-auto text-center">
                    <h1 class="fs-2 fw-bold pt-4 subtitle text-uppercase text-bold text-center"><?php the_title(); ?></h1>

                    <div><?php the_content(); ?></div>

                </div>
            </div>

        <?php } ?>
    </div>
</div>

<?php

if (is_user_logged_in()) {?>
<form action="" method="post" id="form-valutazione" class="formTestRischi" enctype="multipart/form-data" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
    <input type="hidden" name="action" value="add_test_valutazione_user">
    <input type="hidden" name="userID" id="idUser" value="<?php echo $userId; ?>">
    <input type="hidden" name="idTest" id="idTest" value="<?php echo get_the_ID(); ?>">

    <div class="main quiz">
        <div class="container">
            <div class="cnt-h5">
                <h5><?php echo get_field('titolo_blocco_dati_anagrafici_questionario', $id_page_valutazione); ?></h5>
                <span><?php echo get_field('sottotitolo_blocco_dati_anagrafici_questionario', $id_page_valutazione); ?></span>
            </div>

        </div>
    </div>

    <div class="main quiz bg-light-grey mb-5 mt--15">
        <div class="container py-4">
            <div class="valutazione mt-4">
                <fieldset class="field ">
                    <div class="row gy-5 gx-5">
                    <?php blockAnagrafici($domandeAnagrafici, $userId); ?>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <div class="main quiz mt-5 pt-5">
        <div class="container">
            <div class="cnt-h5">
                <h5><?php echo get_field('titolo_blocco_valutazione_questionario', $id_page_valutazione); ?></h5>
                <span><?php echo get_field('sottotitolo_blocco_valutazione_questionario', $id_page_valutazione); ?></span>
            </div>
        </div>
    </div>

    <div class="main quiz bg-light-blu mb-5 mt--15">
        <div class="container py-4">
            <div class="valutazione mt-4">
                <fieldset class="field ">
                    <div class="row gy-5 gx-5">
                        <?php blockValutazione($domande, $userId); ?>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="main quiz my-5">
        <div class="container py-4">
            <div class="valutazione">
                <div class="my-3 text-center">
                    <button type="button" class="btn-scopri btn-send-valutazione ps-3 pe-3 pt-2 pb-2" data-postType="<?php echo get_the_id(); ?>" data-user="<?php echo $userId; ?>">Invia</button>
                </div>
             </div>
        </div>
    </div>
</form>
<?php } else {
    $urlLogin = site_url('/login');
    wp_safe_redirect($urlLogin);
}
get_footer();
