<?php
require_once 'finishTest.php';
//Get All true answers
function getCountCorrectWrongTest($userId,$idTest)
{
    global $wpdb;
    $domande = get_field("domande",$idTest);
    $dataTestUser = $wpdb->get_results("SELECT * FROM wp_questionario WHERE user_id = $userId AND id_test = $idTest ");
    $dataAnswers = [];
    $dataAnswer = [];
    $countCorrect = 0;
    $countWrong = 0;
    $percent =0;
    if($domande):
        foreach ($domande as $k => $domanda) :
            $dataAnswer['idQuestion'] = $k;
            foreach ($domanda["risposte"] as $key => $risposta) :
                if ($risposta["risposta_giusta"] == 1):
                    $dataAnswer['idAnswer'] = $key;
                    array_push($dataAnswers, $dataAnswer);
                endif;
            endforeach;
        endforeach;
        if ($dataTestUser):
            $data = $dataTestUser[0]->data;
            $valueDataUser = json_decode($data, true);

            foreach ($dataAnswers as $key => $dataAnswer):
                if ($dataAnswer['idQuestion'] == $valueDataUser[$key]['idQuestion'] && $dataAnswer['idAnswer'] == $valueDataUser[$key]['idAnswer']):
                    $countCorrect++;
                else:
                    $countWrong++;
                endif;
            endforeach;
            $percent = ($countCorrect / count($dataAnswers)) * 100;
        endif;
    endif;
    //get color result test
    //$color =;
    return array('percent' => $percent,'correct' => $countCorrect,'wrong' => $countWrong);
}