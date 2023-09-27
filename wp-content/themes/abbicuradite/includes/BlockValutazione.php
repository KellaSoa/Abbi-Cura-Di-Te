<?php
function blockValutazione($domande,$userId){
    $count = 0;
    $numItems = count($domande);
    foreach($domande as $d=> $domanda) :
    $count++;
    ?>
    <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="question">
            <div class="title">
                <span class="dashicons dashicons-arrow-right-alt2"></span>
                <span class="fw-bold " data-id="<?php echo $d; ?>"><?php echo $domanda["domande"]; ?></span>
            </div>

            <?php if(!empty($domanda["risposte"])) : ?>
                <?php
                $alphabet = range('A', 'Z');
                $colorAnswer = "";
                foreach($domanda["risposte"] as $key => $risposta) :
                    if($risposta["fascia_verde"])
                        $colorAnswer = "verde";
                    if($risposta["fascia_giallo"])
                        $colorAnswer = "giallo";
                    if($risposta["fascia_arancione"])
                        $colorAnswer = "arancione";
                    if($risposta["fascia_rossa"])
                        $colorAnswer = "rossa";
                    ?>
                    <div class="form-check risposte" data-idQ="<?php echo $d; ?>" id="risposte<?php echo $d; ?>">
                        <label>
                                <span class="wpcf7-form-control-wrap">
                                <span class="wpcf7-form-control wpcf7-radio">
                                    <span class="wpcf7-list-item first last">
                                        <input class="form-check-input answer valutazione risposte<?php echo $d; ?>" data-idQ="<?php echo $d; ?>" data-user="<?php echo $userId; ?>" data-color="<?php echo $colorAnswer;?>" type="radio" data-id="<?php echo $count; ?>" name="answer-val-<?php echo $d; ?>" value="<?php echo $key; ?>">
                                        <span class="wpcf7-list-item-label">
                                            <span class="fw-bold alpha">
                                                <?php echo $alphabet[$key].'. '; ?>
                                            </span>
                                            <?php echo $risposta["risposte"]; ?>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="error<?php echo $d; ?> msgError valutazione text-red mt-2 ms-5 fw-bold">Selezionare una risposta</div>
        </div>
    </div>
    <?php
    if ($count == 2) $count = 0;
    endforeach; ?>

<?php }