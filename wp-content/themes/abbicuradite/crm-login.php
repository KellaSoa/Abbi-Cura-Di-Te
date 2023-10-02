<?php

/* Template Name: CRM Login */
get_header();
$query_array = [
    'post_type' => 'settore',
    // Showing all posts
    'posts_per_page' => -1,
    // Giving all child posts only
    'post_parent__not_in' => [0],
];
$the_query = new WP_Query($query_array);
global $wpdb;
$results = $wpdb->get_results('SELECT * FROM regioni Order By nome');
$collect_parents = [];
const SECRET = 'EBT-UMB-PG';

if (!isset($_GET['k'])) {
    http_response_code(403);
}
// get Token
$token = $_GET['k'];
$token = explode('-', $token);

if (count($token) != 2) {
    throw new Exception('');
}

$dati = base64_decode($token[0]);
$signature = $token[1];

$check = base64_encode(sha1($token[0].SECRET));

/*if ($signature == $check) {
    echo 'valid';
} else {
    echo 'not valid';
    http_response_code(403);
}*/

$dati = explode('|', $dati);
// idDipendente
//echo 'idDependente: '.$dati[0];

//get data user by idDipendente
//TO DO CHANGE ID TO DYNAMIC
$idDipendente = 10129;
$dataUser = UserCRM::Instance()->getUserById($idDipendente);
foreach ($dataUser as $data):
    var_dump($data);

//http://localhost/Abbi-Cura-Di-Te/crmlogin/?k=MTI0MzJ8MTUyNXxBQUFBQUE3MUEyMUExMjNBfFFVRVNULTAxfDExLzAxLzIwMjMgMTg6MTI6MDA%3D-YzdkMmNhZWY0OTdiODQwYzhlM2I5YTU1MDAwMDMzMzA4NTBkNTQ1YQ%3D%3D
?>
<div class="main-content-register">
    <div class="container d-flex align-items-center justify-content-center">
    <div class="row">
        <div class="col">
            <div class="content">
                <h1 class="my-5"><?php the_title(); ?></h1>
<div class="pageBody my-5" >
    <form action="" id="register-form" method="post">

        <fieldset class="border p-2 field">
            <legend class="float-none w-auto p-2">Dati utente</legend>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group mb-3">
                        <label for="user_email">Email *</label>
                        <input type="email" name="user_email" id="user_email" required class="form-control" value="<?php echo $data->Email; ?>">
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
                        <input type="password" name="user_pass_again" id="user_pass_again" class="form-control" required>
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
                        <input type="text" name="user_first" id="user_first" class="form-control" required value="<?php echo $data->Nome; ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group mb-3">
                        <label for="user_last">Cognome *</label>
                        <input type="text" name="user_last" id="user_last" class="form-control" required value="<?php echo $data->Cognome; ?>">
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
                            <?php $sesso = $data->Sesso;
                            $gender= "";
                            switch ($sesso){
                                case "F":
                                    $gender ="0";
                                case "M":
                                    $gender ="1";
                            }
                            ?>
                            <div class="control-group mb-3">
                                <label for="sex-male"><input type="radio" name="user_sex" id="sex-male" value="1" class="form-radio-input" <?php echo $gender= 1 ? "checked": "" ?>  required>Maschio</label>
                            </div>
                            <div class="control-group mb-3">
                                <label for="sex-female"><input type="radio"  id="sex-female" name="user_sex" value="0" class="form-radio-input" <?php echo  $gender= 0 ? "checked": "" ?>>Femmina</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="control-group mb-3">
                        <div>
                            <label for="birthDate">Data di nascita</label>
                            <?php $date=date_create($data->DataNascita);
                            $dateBirth= date_format($date,"d/m/y");?>
                            <input id="birthDate" class="form-control" type="date" name="user_birth" value ="<?php echo $dateBirth; ?>"/>
                            <span id="birthDateSelected"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group mb-3">
                        <label for="user_last">Codice Fiscale * </label>
                        <input type="text" name="user_tax_id_code" id="user_tax_id_code" maxlength="16" class="form-control" value ="<?php echo $data->CodiceFiscale; ?>">
                    </div>
                </div>
                <div class="clear"></div>

                <div class="col-sm-12">
                    <div class="control-group mb-3">
                        <label for="user_adress">Indirizzo </label>
                        <input type="text" name="user_adress" id="user_adress" class="form-control" value="<?php echo $data->Indirizzo; ?>">
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
                            <option value="<?php echo $data->Provincia; ?>"><?php echo $data->Provincia; ?></option >
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="control-group mb-3">
                        <label for="user_comune">Comune </label>
                        <select  id = "comune" name="user_comune" id="user_comune" class="form-control" >
                            <option value="<?php echo $data->Localita; ?>"><?php echo $data->Localita; ?></option >
                        </select >
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="control-group mb-3">
                        <label for="user_cap">CAP</label>
                        <input type="numeric" name="user_cap" id="user_cap"  maxlength="5" data-id="" class="form-control" value="<?php echo $data->Cap; ?>">
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
                        <input type="text" name="company_user" id="company_user" class="form-control" required value="<?php echo $data->RagioneSociale; ?>">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="control-group mb-3">
                        <label for="iva_company">P.IVA *</label>
                        <input type="text" name="iva_company" id="iva_company" class="form-control" maxlength="16" required value="<?php echo $data->PartitaIva; ?>">
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
            <input type="hidden" name="crm_user" value="1">
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

<?php endforeach;?>
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
        user_pass: 'Password è obbligatorio',
                user_pass_again: {
            required: 'Confirm è obbligatorio',
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
    get_footer();
/*
AUTOLOGIN
$user_id = 12345;
$user = get_user_by( 'id', $user_id );
if( $user ) {
    wp_set_current_user( $user_id, $user->user_login );
    wp_set_auth_cookie( $user_id );
    do_action( 'wp_login', $user->user_login );
}
*/


// SELECT FROM usermeta where meta_key = "idDipendente" AND meta_value=$dati[0]

// if has rows -> AUTOLOGIN
// else SELECT FROM import_table where idDip = $dati[0]

// if has rows -> CREATE USER -> AUTOLOGIN
// else redirect login

// Insert in USER table
/*$user_email = $data[0];
$user_first = $data[1];
$user_last = $data[2];
$user_phone = $data[3];
$user_code = $data[4];
$company_user = $data[5];
$iva_company = $data[6];
$user_settore = $data[7]; // make th  e same format like data user_ register

// Check if the email already exists in the database
$user = get_user_by('user_email', $user_email);
// also code user unique

if (!$user) {
    // Create a new user
    // $user_id = wp_create_user($user_email, wp_generate_password(), $user_email);
    // Insert data into WordPress database
    $new_user_id = wp_insert_user([
        'user_login' => $user_email,
        'user_email' => $user_email,
        'user_first' => $user_first,
        'user_last' => $user_last,
        // 'user_pass' => $user_pass,
        'user_registered' => date('Y-m-d H:i:s'),
        'role' => 'user',
    ]);
    // insert meta_key user
    update_user_meta($new_user_id, 'first_name', $user_first);
    update_user_meta($new_user_id, 'last_name', $user_last);
    update_user_meta($new_user_id, 'user_phone', $user_phone);
    update_user_meta($new_user_id, 'user_code', $user_code);
    /*update_user_meta($new_user_id, 'user_sex', $user_sex);
    update_user_meta($new_user_id, 'user_birth', $user_birth);
    update_user_meta($new_user_id, 'user_adress', $user_adress);
    update_user_meta($new_user_id, 'user_province', $user_province);
    update_user_meta($new_user_id, 'user_region', $user_region);
    update_user_meta($new_user_id, 'user_comune', $user_comune);
    update_user_meta($new_user_id, 'user_cap', $user_cap);

    update_user_meta($new_user_id, 'company_user', $company_user);
    update_user_meta($new_user_id, 'iva_company', $iva_company);
    update_user_meta($new_user_id, 'sector', $user_settore);

    // User csv
    update_user_meta($new_user_id, 'is_user_csv', true);
    // Log successful user creation
    $success_message = "User created: Email: $user_email, First Name: $user_first, Last Name: $user_last";
}
