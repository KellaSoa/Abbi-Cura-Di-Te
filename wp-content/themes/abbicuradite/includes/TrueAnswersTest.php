<?php

//Get All true answers
function getTrueAnswers($domande,$id)
{
    global $wpdb;
    $userId = get_current_user_id();
    //get data user
    $dataTestUser = $wpdb->get_results("SELECT * FROM wp_questionario WHERE user_id = $userId AND id_test = $id ");
    $dataAnswers = [];
    $dataAnswer = [];
    if($domande):
        foreach ($domande as $k => $domanda) :
            $dataAnswer['idQuestion'] = $k;
            foreach ($domanda["risposte"] as $key => $risposta) :
                //var_dump($domanda["risposte"]);
                if ($risposta["risposta_giusta"] == 1):
                    $dataAnswer['idAnswer'] = $key;
                    array_push($dataAnswers, $dataAnswer);
                endif;
            endforeach;
        endforeach;
        if ($dataTestUser):
            $data = $dataTestUser[0]->data;
            $valueDataUser = json_decode($data, true);
            $countCorrect = 0;
            foreach ($dataAnswers as $key => $dataAnswer):
                if ($dataAnswer['idQuestion'] == $valueDataUser[$key]['idQuestion'] && $dataAnswer['idAnswer'] == $valueDataUser[$key]['idAnswer']):
                    $countCorrect++;
                endif;
            endforeach;
            $percent = ($countCorrect / count($dataAnswers)) * 100;
        endif;
    endif;
    return array('percent' => $percent, 'dataTestUser' => $dataTestUser);
}