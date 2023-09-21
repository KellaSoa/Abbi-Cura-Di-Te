<?php

    global $wpdb;
    $userId = get_current_user_id();
    $userInfo = get_userdata($userId);
    $userMeta = get_user_meta($userId);
    $dataValutazioneUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $userId");
    // get legende
    $legende = get_field('legenda', $dataValutazioneUser[0]->idPostType);
    $legendColor = [];
    foreach ($legende as $d => $legenda) {
        // get color
        foreach ($legenda['fascia'] as $key => $risposta) {
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
        }
        $legendColor[$colorAnswer] = $legenda['legenda'];
    }

    $current_url = home_url($_SERVER['REQUEST_URI']);
    $valueSplit = explode('/', $current_url);
    if ($valueSplit[5] == 'area-valutazione') { ?>
        <div class="col-9">
            <h1 class="title-bloc fs-1 fw-bold"><?php echo get_field('titolo_valutazione', get_the_ID()); ?>  </h1>
            <h5 class="pt-2 pb-5 subtitle text-uppercase"><?php echo get_field('sottotitolo_valutazione', get_the_ID()); ?></h5>
        </div>
    <?php } ?>
    <div class="row gy-3 gx-5 align-items-center my-5" style="position: relative">

    <?php
    if ($dataValutazioneUser) {
        $data = $dataValutazioneUser[0]->data;
        $data = json_decode($data);
        $valueDataUser = convert_object_to_array($data->valutazioni);
        $array = [];
        $countData = count($valueDataUser);
        foreach ($valueDataUser as $key => $data) {
            if (isset($data['color'])) {
                array_push($array, $data['color']);
            }
        }
        $countColor = array_count_values($array);
        $percentVerde = ($countColor['verde'] / $countData) * 100;
        $percentGiallo = ($countColor['giallo'] / $countData) * 100;
        $percentArancione = ($countColor['arancione'] / $countData) * 100;
        $percentRossa = ($countColor['rossa'] / $countData) * 100;
        $colors = ['verde' => $percentVerde, 'giallo' => $percentGiallo, 'arancione' => $percentArancione, 'rossa' => $percentRossa];
        $colors = array_filter($colors);
        $getColorResult = '';
        if (array_key_exists('verde', $colors)) {
            $getColorResult = 'verde';
        }
        if (array_key_exists('giallo', $colors)) {
            $getColorResult = 'giallo';
        }
        if (array_key_exists('arancione', $colors)) {
            $getColorResult = 'arancione';
        }
        if (array_key_exists('rossa', $colors)) {
            $getColorResult = 'rossa';
        }
        $legendFinal = ''; // get final resultat
        $colorFinal = ''; // get final resultat
        foreach ($legendColor as $color => $value) {
            if ($color = $getColorResult) {
                $legendFinal = $legendColor[$color];
                $colorFinal = $color;
            }
        }?>

        <div class="col-md-12 col-lg-6">
            <div class="Resultdescription">
                <h5 class="fw-bold colorFinal <?php echo $colorFinal; ?>"><?php showMessageColor($colorFinal); ?></h5>
                <?php echo $legendFinal; ?>
                <div class=" mt-5">
                    <a href="#area-test" class="btn-scopri">METTITI ALLA PROVA</a>
                </div>

            </div>
        </div>


    <?php }?>

        <div class="col-md-12 col-lg-6">
            <div class="bottom-canvas" style="position: absolute; bottom: 0; right: 0; width: 100%; height: 20px;background-color: white;
            z-index: 1;"></div>
            <div class="resultValuta">
                <div id="chartContainer" style="height: 370px; width: 100%; "></div>
            </div>
        </div>

    </div>
    <?php
    $dataPoints = [
        ['label' => 'Verde', 'y' => round($percentVerde)],
        ['label' => 'Giallo', 'y' => round($percentGiallo)],
        ['label' => 'Arancione', 'y' => round($percentArancione)],
        ['label' => 'Rossa', 'y' => round($percentArancione)],
    ];

    // get value legende
    function CheckPercent($color, $percent)
    {
        if ($color == 0 || is_null($percent)) {    // add whatever condition you want to check
            echo 'Value percent '.$color.' is empty';
        } else {
            echo 'legende is color'.$color.'with value percent'.$percent;
        }
    }

    function showMessageColor($colorFinal)
    {
        $id_page_valutazione = 290;
        switch ($colorFinal) {
            case 'verde':
                // echo "Ma non farti cogliere impreparato, i rischi sul lavoro possono essere molti: mettiti alla prova con i nostri test!";
                echo get_field('message_colore_verde', $id_page_valutazione);
                break;
            case 'giallo':
                // echo "Non aggravare la situazione e previeni: fai i test e scopri quanto ne sai sui rischi della salute sul lavoro!";
                echo get_field('message_colore_giallo', $id_page_valutazione);
                break;
            case 'arancione':
                // echo "Prevenire e informare: fai i test e scopri come migliorare la tua salute sul lavoro!";
                get_field('message_colore_arancione', $id_page_valutazione);
                break;
            case 'rossa':
                // echo "Non sottovalutare questi rischi, la tua salute è importante: fai i test e scopri quanto puoi imparare!";
                echo get_field('message_colore_rossa', $id_page_valutazione);
                break;
        }
    }
    function convert_object_to_array($data)
    {
        if (is_object($data)) {
            // Get the properties of the given object
            $data = get_object_vars($data);
        }
        if (is_array($data)) {
            // Return array converted to object
            return array_map(__FUNCTION__, $data);
        } else {
            // Return array
            return $data;
        }
    }
    ?>
<script>
    window.onload = function() {
        var verde = "#28A745";
        var giallo = "#ffcc35";
        var arancione = "#ff7007";
        var rosso = "#DC3545";

        CanvasJS.addColorSet("greenShades",
            [//colorSet Array
                verde,
                giallo,
                arancione,
                rosso
            ]);
        var chart = new CanvasJS.Chart("chartContainer", {
            width: 500,
            animationEnabled: true,
            colorSet: "greenShades",
            title: {
                text: "",
                fontColor: "#06449d",
                verticalAlign: "top",
                horizontalAlign: "center",
            },
            subtitles: [{
                text: "",
                fontColor: "#06449d",
            }],
            data: [{
                indexLabelFontSize: 14,
                type: "pie",
                yValueFormatString: "#,##0\"%\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>