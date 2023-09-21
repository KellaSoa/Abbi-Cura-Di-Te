<?php
function finishTest($valueTrueAnswers,$id){ ?>
<div class="modal" id="success_message" tabindex="-1" aria-labelledby="success_message" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="imgbox">
                    <img src="<?php echo get_theme_file_uri('/images/checked.png'); ?>" alt="" class="img">
                </div>

                <div class="title mb-5">
                    <h1 class="title-bloc"><?php echo get_field("titolo_popup",get_the_ID());?></h1>
                    <h3 class="title-bloc fw-bold <?php
                    $message = showMessage($valueTrueAnswers['percent']);
                    echo $message["textColor"]; ?>  ">
                        Hai risposto correttamente al <?php echo round($valueTrueAnswers['percent']) .' %';//strtoupper(get_the_title($id)); ?> delle domande.</h3>
                    <h5 class="title-bloc"><?php echo $message["message"]; ?> </h5></div>
            </div>

        </div>
    </div>
</div>
<?php }
function percentBetween($percent, $low, $high) {
    if (($percent >= $low) && ($percent <= $high))
        return true;
    else
        return false;
}

function showMessage($percent){
    $caso1 = percentBetween($percent, 90, 100);
    $caso2 = percentBetween($percent, 50, 89);
    $caso3 = percentBetween($percent, 0, 49);
    $message ='';
    $text= '';
    if($caso1){
        //$message= "Complimenti! Continua ad allenarti con i nostri test e resta informato sui rischi sul lavoro.";
        $message= get_field("hight_resultat",get_the_ID());
        $text= 'text-success';
        $background = 'bg-success';
    }
    if($caso2)
    {
        $message= get_field("medium_resultat",get_the_ID());
        //$message= "Puoi fare di meglio! Leggi i nostri materiali informativi e riprova. Prevenire i rischi è importante.";
        $text= 'text-warning';
        $background = 'bg-warning';
    }

    if($caso3){
        //$message= "La tua salute è importante: studia i nostri materiali e riprova il test! Conoscere i rischi è il primo passo per prevenirli.";
        $message= get_field("low_resultat",get_the_ID());
        $text= 'text-danger';
        $background = 'bg-danger';
    }
    return array("message"=>$message,"textColor"=>$text, "bgColor"=>$background);
} ?>