<?php /* Template Name: Register */
if (is_user_logged_in()) {
    wp_safe_redirect(home_url());
}
get_header();
$query_array = [
    'post_type' => 'settore',
    // Showing all posts
    'posts_per_page' => -1,
    // Giving all child posts only
    'post_parent__not_in' => [0],
];
$the_query = new WP_Query($query_array);
// Array to collect all parent posts
$collect_parents = [];
// Get regione province commune
global $wpdb;
$results = $wpdb->get_results('SELECT * FROM regioni Order By nome');
?>
<div class="main-content-register">
    <div class="container d-flex align-items-center justify-content-center">
    <div class="row">
        <div class="col">
            <div class="content">
                <h1 class="title-bloc mt-5 mb-3 fw-bold"><?php the_title(); ?></h1>
                <h5 class="subtitle text-uppercase mb-5">Compila i dati per creare un nuovo account.<br>Potrai metterti alla prova e accedere ai test.</h5>
                <div class="pageBody my-5" >
                    <form action="" id="register-form" method="post">

                        <fieldset class="border p-2 field">
                            <legend class="float-none w-auto p-2">Dati utente</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_email">Email *</label>
                                        <input type="email" name="user_email" id="user_email" required class="form-control">
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_pass">Password *</label>
                                        <input type="password" name="user_pass" id="user_pass" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_pass_again">Conferma password *</label>
                                        <input type="password" name="user_pass_again" id="user_pass_again" class="form-control" required >
                                    </div>
                                </div>
                            </div>

                        </fieldset>

                        <fieldset class="border p-2 field">
                            <legend class="float-none w-auto p-2">Dati anagrafici</legend>
                            <input type="hidden" name="action" value="register_user">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_first">Nome *</label>
                                        <input type="text" name="user_first" id="user_first" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_last">Cognome *</label>
                                        <input type="text" name="user_last" id="user_last" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_first">Telefono *</label>
                                        <input type="text" name="user_phone" id="user_phone" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_last">Sesso </label>
                                        <div class="form-check bloc-sex">
                                            <div class="control-group mb-3">
                                                <label for="sex-male"><input type="radio" name="user_sex" id="sex-male" value="1" class="form-radio-input" required>Maschio</label>
                                            </div>
                                            <div class="control-group mb-3">
                                                <label for="sex-female"><input type="radio"  id="sex-female" name="user_sex" value="0" class="form-radio-input">Femmina</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <div>
                                            <label for="birthDate">Data di nascita</label>
                                            <input id="birthDate" class="form-control" type="date" name="user_birth" class="form-control"/>
                                            <span id="birthDateSelected"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_last">Codice Fiscale * </label>
                                        <input type="text" name="user_tax_id_code" id="user_tax_id_code" maxlength="16" class="form-control">
                                    </div>
                                </div>
                                <div class="clear"></div>

                                <div class="col-sm-12">
                                    <div class="control-group mb-3">
                                        <label for="user_adress">Indirizzo </label>
                                        <input type="text" name="user_adress" id="user_adress" class="form-control" >
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_region">Regione  </label>
                                        <!--input type="text" name="user_province" id="user_province" class="form-control"-->
                                        <select  id = "regione" name="user_region" id="user_region" class="form-control" >
                                            <option  value = "" >Seleziona la Regione </option >
                                            <?php
                                            foreach ($results as $res) {
                                                $valJson = '{"id":"'.$res->codice.'","value":"'.$res->nome.'"}';
                                                echo "<option  value = '".$valJson."' data-id='".$res->codice."' >".$res->nome.'</option >';
                                            }
?>
                                        </select >
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_province">Provincia</label>
                                        <select  id = "provincia" name="user_province" id="user_province" class="form-control" >
                                            <option value="">Seleziona la Provincia</option >
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="control-group mb-3">
                                        <label for="user_comune">Comune </label>
                                        <select  id = "comune" name="user_comune" id="user_comune" class="form-control" >
                                            <option value="">Seleziona il Comune </option >
                                        </select >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="control-group mb-3">
                                        <label for="user_cap">CAP</label>
                                        <input type="numeric" name="user_cap" id="user_cap"  maxlength="5" data-id="" class="form-control" value="">
                                    </div>
                                </div>

                            </div>
                        </fieldset>

                        <fieldset class="border p-2 field">
                            <legend class="float-none w-auto p-2">Dati aziendali *</legend>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="control-group mb-3">
                                        <label for="company_user">Ragione sociale Azienda *</label>
                                        <input type="text" name="company_user" id="company_user" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="control-group mb-3">
                                        <label for="iva_company">P.IVA *</label>
                                        <input type="text" name="iva_company" id="iva_company" class="form-control" maxlength="16" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="control-group mb-3">
                                        <label for="user_pass_again">Settore *</label><br>
                                        <?php while ($the_query->have_posts()) {
                                            $the_query->the_post();
                                            // if condition is used to eliminate duplicates, generated by same child post of parent.
                                            if (!in_array($post->post_parent, $collect_parents)) {
                                                // $collect_parents contains all the parent post id's
                                                $collect_parents[] = $post->post_parent;
                                            }
                                        }?>
                                        <select class="form-select searchSector" id="multiple-select-optgroup-field" name="user_settore" data-placeholder="Indica il settore e la mansione" multiple required >

                                            <?php foreach ($collect_parents as $parent) { ?>
                                                <!-- Printing parent post title -->
                                                <optgroup label="<?php echo get_the_title($parent); ?>" id="<?php echo $parent; ?>">
                                                    <?php /* <h2 id="<?php echo $parent; ?>"><a href="<?php echo get_permalink($parent ); ?>"> <?php echo get_the_title($parent); ?></a></h2> */ ?>
                                                    <?php $currentPostId = $parent;
                                                $args = [
                                                    'post_type' => 'settore',
                                                    'post_parent' => $currentPostId,
                                                ];
                                                $posts = new WP_Query($args);
                                                if ($posts->have_posts()) {
                                                    while ($posts->have_posts()) {
                                                        $posts->the_post();
                                                        // create json format
                                                        $myObjSector = new stdClass();
                                                        $myObjSector->idParent = $parent;
                                                        $myObjSector->parent = get_the_title($parent);
                                                        $myObjSector->idChild = get_the_ID();
                                                        $myObjSector->child = get_the_title();
                                                        $myObjSector = json_encode($myObjSector);
                                                        // end json
                                                        ?>
                                                        <option value='<?php echo $myObjSector; ?>'><?php echo get_the_title(); ?></option>
                                                    <?php }
                                                    } ?>
                                                </optgroup>
                                            <?php }?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <div class="row">
                            <label for="privacy_policy" class="privacy">
                                <input type="checkbox" id="privacy_policy" name="privacy_policy" required />
                                <a href="<?php echo esc_url(get_permalink(3)); ?>"> Accetto Privacy Policy</a>.
                            </label>
                        </div>
                        <div class="control-group text-end">
                            <input type="hidden" name="vicode_csrf" value="<?php echo wp_create_nonce('vicode-csrf'); ?>">
                            <p class="error-send error"></p>
                            <button type="submit" class="btn btn-primary btn-scopri sendUser mt-3 mx-0">INVIA</button>
                            <!--input class="sendUser" type="submit" value="INVIA"/-->
                        </div>

                        <div id="error">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    jQuery(document).ready(function($) {
        jQuery.validator.addMethod("codiceFiscale", function(value, element)
            {
                return validateCF(value);
            },
            "Codice fiscale non valido."
        );
        jQuery.validator.addMethod("pIVA", function(value, element)
            {
                return validatePIVA(value);
            },
            "P.IVA non valido."
        );

        // validate pass/passconfirm,tax_id_code and iva
        $("#register-form").validate({
            rules: {
                user_pass: 'required',
                user_pass_again:  {
                    required: true,
                    equalTo: "#user_pass",
                },
                user_tax_id_code: { codiceFiscale: true },
                iva_company: { pIVA: true },
            },
            messages: {
                user_pass: 'Campo obbligatorio',
                user_pass_again: {
                    required: 'Campo obbligatorio',
                    equalTo: 'Password non corrispondente',
                },
                //user_tax_id_code: 'Codice fiscale non valido',
                iva_company: 'P.IVA non valido',
            },
        });

        //BEGIN Select REGION PROVINCE
        $('#regione').on('change', function(){
            codRegione = $(this).find(':selected').data("id");
            if(codRegione!=0){
                $.ajax({
                    type:'POST',
                    url:"<?php echo admin_url('admin-ajax.php'); ?>",
                    data:'codRegione='+codRegione+ '&action=getRegionOrProvince',
                    success:function(rispostahtml){
                        $('#provincia').html(rispostahtml);
                        $('#comune').html('<option value="">Seleziona la Provincia</option>');
                    }
                });
            }else{
                $('#provincia').html('<option value="">Seleziona la Provincia</option>');
                $('#comune').html('<option value="">Seleziona il Comune </option>');
            }
        });

        $('#provincia').on('change', function(){

            codProvincia = $(this).find(':selected').data("id");
            if(codProvincia!=0){
                $.ajax({
                    type:'POST',
                    url:"<?php echo admin_url('admin-ajax.php'); ?>",
                    data:'codProvincia='+codProvincia + '&action=getRegionOrProvince',
                    success:function(rispostahtml){
                        $('#comune').html(rispostahtml);
                    }
                });
            }else{
                $('#comune').html('<option value="">Seleziona il Comune</option>');
            }
        });
        /*$('#comune').on('change', function(){
            codComune = $(this).find(':selected').data("id");
            $('#user_cap').val(codComune);
            $("#user_cap").attr("value", codComune);
        });*/
        //END  Select REGION PROVINCE COMMUNE
    });
    jQuery("#register-form").submit(function (event)
    {
        jQuery('#register-form').attr('disabled',true);

        if (jQuery(this).find('[required]').filter(function() {
            return this.value === '';
        }).length > 0) {
            // There are required fields that are empty, prevent form submission
            console.log('Please fill out all required fields.');
            event.preventDefault();
        } else {
            if (!jQuery('#privacy_policy').is(':checked')) {
                // Checkbox is unchecked, prevent form submission
                console.log('Please check the checkbox.');
                event.preventDefault();
            }else {
                console.log('required OK.');
                let $this = jQuery(this);
        jQuery.ajax
        ({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: $this.serialize(),
            method: "POST",
            dataType : 'json',
            success: function (response)
            {
                console.log(response)
                if(response.success)
                {
                    window.location.href = "<?php echo home_url('/area-test'); ?>";
                }
                else
                {
                    for(let key in response.error)
                    {
                        let $err = jQuery("<div></div>");
                        $err.text(response.error[key]);
                        jQuery("#error").show();
                        jQuery("#error").html($err);
                    }

                }
                jQuery('#register-form').removeAttr('disabled');
            },
            error: function (response)
            {
                var errorLabel = jQuery('form label').hasClass('error');
                if(jQuery('.content #register-form label.error').is(":visible")){
                    console.log('shown');
                }
                else{
                    jQuery('.error-send').text('Spiacente, quello utenti esiste già!');
                }

                jQuery('#register-form').removeAttr('disabled');
            }
        });
            }

        }
    });

    function validateCF(cfins)
    {
        let cf = cfins.toUpperCase();
        const cfReg = /^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/;
        if (!cfReg.test(cf)) return false;
        const set1 = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const set2 = "ABCDEFGHIJABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const setpari = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const setdisp = "BAKPLCQDREVOSFTGUHMINJWZYX";
        let s = 0;
        for(let i = 1; i <= 13; i += 2 )
            s += setpari.indexOf(set2.charAt(set1.indexOf(cf.charAt(i))));
        for(let i = 0; i <= 14; i += 2 )
            s += setdisp.indexOf(set2.charAt(set1.indexOf(cf.charAt(i))));
        if (s%26 != cf.charCodeAt(15)-'A'.charCodeAt(0) )
            return false;
        return true;
    }

    function validatePIVA(piva)
    {
        let valid = false;
        if(piva.length === 11) valid = /^\d+$/.test(piva);
        else if (piva.length === 13)
        {
            let first2 = piva.slice(0,2);
            let other = piva.slice(2);
            valid = /^[a-zA-Z]+$/.test(first2) && /^\d+$/.test(other);
        }
        return valid;
    }
    </script>
<?php get_footer(); ?>
