<?php
function getFinalColorValutation($userId){
    global $wpdb;
    $dataValutazioneUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $userId");

    //get legende
    $legende = get_field("legenda", $dataValutazioneUser[0]->idPostType);
    $legendColor = [];
    $colorFinal = '';// get final resultat
    foreach($legende as $d=> $legenda) :
        //get color
        foreach($legenda["fascia"] as $key => $risposta) :
            if($risposta["fascia_verde"])
                $colorAnswer = "verde";
            if($risposta["fascia_giallo"])
                $colorAnswer = "giallo";
            if($risposta["fascia_arancione"])
                $colorAnswer = "arancione";
            if($risposta["fascia_rossa"])
                $colorAnswer = "rossa";
        endforeach;
        $legendColor[$colorAnswer] = $legenda["legenda"];
    endforeach;

    if($dataValutazioneUser):
        $data = $dataValutazioneUser[0]->data;
        $data= json_decode($data);
        $valueDataUser= convert_object_to_array1($data->valutazioni);
        $array = [];
        $countData = count($valueDataUser);
        foreach ($valueDataUser as $key=> $data){
            if(isset($data['color'])){
                array_push($array,  $data['color']) ;
            }
        }
        $countColor = (array_count_values($array));
        $percentVerde = ($countColor['verde']/$countData)*100;
        $percentGiallo = ($countColor['giallo']/$countData)*100;
        $percentArancione = ($countColor['arancione']/$countData)*100;
        $percentRossa = ($countColor['rossa']/$countData)*100;
        $colors = array('verde'=>$percentVerde, 'giallo'=>$percentGiallo, 'arancione'=>$percentArancione,'rossa'=>$percentRossa);
        $colors = array_filter($colors);
        $getColorResult = '';
        if (array_key_exists('verde', $colors))
            $getColorResult= "verde";
        if (array_key_exists("giallo", $colors))
            $getColorResult= "giallo";
        if (array_key_exists("arancione", $colors))
            $getColorResult= "arancione";
        if (array_key_exists('rossa', $colors))
            $getColorResult= "rossa";

        foreach($legendColor as $color => $value):
            if($color = $getColorResult){
                $colorFinal= $color;
            }
        endforeach;
    endif;
    return $colorFinal;
}
function convert_object_to_array1($data) {
    if(is_object($data)) {
        // Get the properties of the given object
        $data = get_object_vars($data);
    }
    if(is_array($data)) {
        //Return array converted to object
        return array_map(__FUNCTION__, $data);
    }
    else {
        // Return array
        return $data;
    }
}
