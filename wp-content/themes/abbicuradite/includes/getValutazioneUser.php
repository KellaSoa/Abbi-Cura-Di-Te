<?php
function getValutazioneUser(){
    /*valutazione user*/
    $idValutazione= 0;
    $firstIdValue =0;
    $valueGet = getValutazioneBySector();
    $sectorCurrentUser = $valueGet['sectorCurrentUser'];
    $args = array(
        'post_type' => 'valutazione',
        'post_status' => 'publish',
    );
    $loop = new WP_Query( $args );
    $row = 1;
    while ($loop->have_posts()) :
        $loop->the_post();
        if($row == 1) {
            $firstIdValue = get_the_ID();
        }
        $post_id = get_the_ID();
        $sectors = get_field('settoreUtenti',get_the_ID());// sector selected for the valutazione

        $allValutazioneBySector = allValutazioneBySector($sectors,$sectorCurrentUser,$valueGet,$post_id);
        if ($allValutazioneBySector['has_sector']) {
            //return the idValue of postType valutation equal of sector User
            $idValutazione = $allValutazioneBySector['postId'];
            break;
        }
        $row++;
    endwhile;
    wp_reset_query();
    //check if no valutazione for the sector of user so return the first id postType  Valutation
    if ($idValutazione == 0)
        $idValutazione= $firstIdValue;
    return $idValutazione;
    /*end valutazione user*/
}
function getSectorSelectedInEachValutazione($post_id){
    $sectors = get_field('settoreUtenti',$post_id);// sector selected for the valutazione
    if (!empty($sectors) && is_array($sectors)) {
        foreach ($sectors as $value) {
            echo $value->post_title . '<br>';
        }
    }
}
