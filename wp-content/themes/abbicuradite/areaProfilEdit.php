<?php /* Template Name: Area profilo edit */
get_header();
canAreaRiservata();
global $wpdb;
$userId= get_current_user_id();
$query_array = array(
    'post_type' => 'settore',
    //Showing all posts
    'posts_per_page' => -1,
    //Giving all child posts only
    'post_parent__not_in' => array( 0 )
);
$the_query = new WP_Query($query_array);
//Array to collect all parent posts
$collect_parents = array();
//Get regione province commune

$results = $wpdb->get_results("SELECT * FROM regioni Order By nome");

?>
<?php
get_template_part("template-parts/banner-area-riservata");
?>
    <div class="main-content-area-riservata mt-5">
        <div class="container-fluid">
            <div class="row my-5">
                <div class="col-sm-12 col-md-3 mb-5">
                    <?php get_template_part("template-parts/navbar-area-riservata"); ?>
                </div>
                <div class="col-sm-12 col-md-9 contentPageArea">
                    <?php $userId= get_current_user_id();
                    $userInfo = get_userdata( $userId);
                    $userMeta = get_user_meta( $userId);
                    ?>
                    <form action="" id="register-form">
                        <fieldset class="border p-2 field">
                            <legend class="float-none w-auto p-2">Dati anagrafici</legend>

                            <div class="control-group mb-3">
                                <input type="hidden" name="action" value="update_register_user">
                                <input type="hidden" name="id_user" value="<?php echo $userId; ?>">

                            </div>
                            <div class="control-group mb-3">
                                <label for="user_first">Nome</label>
                                <input type="text" name="user_first" id="user_first" class="form-control"  value="<?php echo $userMeta['first_name'][0]; ?>" >
                            </div>
                            <div class="control-group mb-3">
                                <label for="user_last">Cognome</label>
                                <input type="text" name="user_last" id="user_last" class="form-control" value="<?php echo $userMeta['last_name'][0]; ?>">
                            </div>
                            <div class="control-group mb-3">
                                <label for="user_email">Email *</label>
                                <input type="email" name="user_email" id="user_email" required class="form-control" value="<?php echo $userInfo->user_email; ?>">
                            </div>
                            <div class="control-group mb-3">
                                <label for="user_first">Telefono</label>
                                <input type="text" name="user_phone" id="user_phone" class="form-control" value="<?php echo $userMeta['user_phone'][0]; ?>">
                            </div>
                            <div class="control-group mb-3">
                                <label for="user_last">Codice Fiscale</label>
                                <input type="text" name="user_tax_id_code" id="user_tax_id_code" maxlength="16" class="form-control" value="<?php echo $userMeta['user_code'][0]; ?>">
                            </div>
                            <div class="control-group mb-3">
                                <fieldset class="border p-2">
                                    <legend class="float-none w-auto p-2">Sesso</legend>
                                    <div class="form-check">
                                        <?php $userSex = $userMeta['user_sex'][0]; ?>
                                        <input type="radio" name="user_sex" value="1" <?php if ($userSex == 1) { echo "checked='checked'"; }  ?> class="form-radio-input">
                                        <label for="user_sex">Maschio</label>
                                        <input type="radio"  name="user_sex" value="0" <?php if ($userSex == 0) { echo "checked='checked'"; }  ?> class="form-radio-input">
                                        <label for="user_sex">Femina</label>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="control-group mb-3">
                                <div>
                                    <label for="birthDate">Data di nascita</label>
                                    <input id="birthDate" class="form-control" type="date" name="user_birth" class="form-control" value="<?php echo $userMeta['user_birth'][0]; ?>"/>
                                    <span id="birthDateSelected"></span>
                                </div>
                            </div>

                            <div class="control-group mb-3">
                                <label for="user_adress">Indirizzo *</label>
                                <input type="text" name="user_adress" id="user_adress" class="form-control" value="<?php echo $userMeta['user_adress'][0]; ?>">
                            </div>


                            <div class="control-group mb-3">
                                <label for="user_region">Regione  </label>
                                <!--input type="text" name="user_province" id="user_province" class="form-control"-->
                                <select  id = "regione" name="user_region" id="user_region" class="form-control">
                                    <option  value = "0" >Seleziona la Regione </option >
                                    <?php
                                    $user_region = json_decode($userMeta['user_region'][0]);
                                    $user_region_id = $user_region->id;
                                    foreach ($results as $res) {
                                        $valJson = '{"id":"'.$res->codice.'","value":"'.$res->nome.'"}';
                                        $checkRegion  = ($user_region_id == $res->codice) ? 'selected':'';
                                        echo "<option  value = '".$valJson."' data-id='".$res->codice."' $checkRegion data-check='".$user_region_id."' >".$res->nome."</option >";
                                    }
                                    ?>
                                </select >
                            </div>
                            <div class="control-group mb-3">
                                <label for="user_province">Provincia </label>
                                <?php $user_province = json_decode($userMeta['user_province'][0]);?>
                                <select  id = "provincia" name="user_province" id="user_province" class="form-control">
                                    <option value="0">Seleziona la Provincia</option >
                                    <option value='<?php echo $userMeta['user_province'][0];?>' selected ><?php echo $user_province->value;?></option >
                                </select>
                            </div>
                            <div class="control-group mb-3">
                                <label for="user_comune">Comune </label>
                                <?php $user_comune = json_decode($userMeta['user_comune'][0]);?>
                                <select  id = "comune" name="user_comune" id="user_comune" class="form-control" >
                                    <option value="0">Seleziona il Comune </option >
                                    <option value='<?php echo $userMeta['user_comune'][0];?>' selected ><?php echo $user_comune->value;?></option >
                                </select >
                            </div>
                            <div class="control-group mb-3">
                                <label for="user_cap">CAP</label>
                                <input type="text" name="user_cap" id="user_cap"  maxlength="5" class="form-control" value="<?php echo $userMeta['user_cap'][0]; ?>">
                            </div>
                            <!--div class="control-group mb-3">
                                <label for="user_pass">Password *</label>

                                <input type="password" name="user_pass" id="user_pass" class="form-control" value="">
                            </div>
                            <div class="control-group mb-3">
                                <label for="user_pass_again">Password Confirm *</label>
                                <input type="password" name="user_pass_again" id="user_pass_again" class="form-control" value="">
                            </div-->
                        </fieldset>
                        <fieldset class="border p-2 field">
                            <legend class="float-none w-auto p-2">Dati aziendali</legend>
                            <div class="control-group mb-3">
                                <label for="company_user">Ragione sociale Azienda</label>
                                <input type="text" name="company_user" id="company_user" class="form-control" value="<?php echo $userMeta['company_user'][0]; ?>">
                            </div>
                            <div class="control-group mb-3">
                                <label for="iva_company">P.IVA</label>
                                <input type="text" name="iva_company" id="iva_company" class="form-control" maxlength="16" value="<?php echo $userMeta['iva_company'][0]; ?>">
                            </div>

                            <div class="control-group mb-3">
                                <label for="user_pass_again">Settore </label><br>
                                <?php while($the_query->have_posts()):
                                    $the_query->the_post();
                                    //if condition is used to eliminate duplicates, generated by same child post of parent.
                                    if(!in_array($post->post_parent, $collect_parents)){
                                        //$collect_parents contains all the parent post id's
                                        $collect_parents[] = $post->post_parent;
                                    }
                                endwhile;?>
                                <?php
                                $sector= $userMeta['sector'][0];
                                $sectorValue= json_decode($sector);
                                ?>
                                <select class="form-select searchSector" id="multiple-select-optgroup-field" name="user_settore" data-placeholder="scegli il settore e mansione" required>
                                    //Printing all the parent posts
                                    <?php

                                    foreach($collect_parents as $parent): ?>
                                        <!-- Printing parent post title -->
                                        <optgroup label="<?php echo get_the_title($parent); ?>" id="<?php echo $parent; ?>">
                                            <?php /* <h2 id="<?php echo $parent; ?>"><a href="<?php echo get_permalink($parent ); ?>"> <?php echo get_the_title($parent); ?></a></h2>*/?>
                                            <?php $currentPostId = $parent;
                                            $args = array(
                                                'post_type' => 'settore',
                                                'post_parent' => $currentPostId
                                            );
                                            $posts = new WP_Query($args);
                                            if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post();
                                                //create json format
                                                $myObjSector = new stdClass();
                                                $myObjSector->idParent = $parent;
                                                $myObjSector->parent = get_the_title($parent);
                                                $myObjSector->idChild = get_the_ID();
                                                $myObjSector->child = get_the_title();
                                                $myObjSector = json_encode($myObjSector);
                                                //end json
                                                $checkSector  = (get_the_ID() == $sectorValue->idChild) ? 'selected':'';
                                                ?>
                                                <option value='<?php echo  $myObjSector; ?>' <?php echo $checkSector;?> ><?php  echo get_the_title(); ?></option>
                                            <?php endwhile; endif; ?>
                                        </optgroup>
                                    <?php endforeach;?>
                                </select>

                            </div>
                        </fieldset>
                        <div class="control-group">
                            <input type="hidden" name="vicode_csrf" value="<?php echo wp_create_nonce('vicode-csrf');?>">
                            <button type="submit" class="btn btn-primary btn-scopri sendUser mb-3 mt-3">INVIA</button>
                            <!--input class="sendUser" type="submit" value="INVIA"/-->
                        </div>
                    </form>
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
                    user_pass: 'Password è obbligatorio',
                    user_pass_again: {
                        required: 'Confirm è obbligatorio',
                        equalTo: 'Password non corrispondente',
                    },
                    user_tax_id_code: 'Codice fiscale non valido',
                    iva_company: 'P.IVA non valido',
                },
            });

            //BEGIN Select REGION PROVINCE
            $('#regione').on('change', function(){
                codRegione = $(this).find(':selected').data("id");
                if(codRegione!=0){
                    $.ajax({
                        type:'POST',
                        url:"<?php echo admin_url("admin-ajax.php"); ?>",
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
                        url:"<?php echo admin_url("admin-ajax.php"); ?>",
                        data:'codProvincia='+codProvincia + '&action=getRegionOrProvince',
                        success:function(rispostahtml){
                            $('#comune').html(rispostahtml);
                        }
                    });
                }else{
                    $('#comune').html('<option value="">Seleziona il Comune</option>');
                }
            });
            $('#comune').on('change', function(){
                codComune = $(this).find(':selected').data("id");
                $('#user_cap').val(codComune);
                $("#user_cap").attr("value", codComune);
            });
            //END  Select REGION PROVINCE COMMUNE
        });


        jQuery("#register-form").submit(function (e)
        {
            e.preventDefault();
            let $this = jQuery(this);
            jQuery('#register-form').attr('disabled',true);
            jQuery.ajax
            ({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                data: $this.serialize(),
                method: "POST",
                dataType : 'json',
                success: function (response)
                {
                    console.log("success");
                    window.location.href = "<?php echo home_url('/area-profilo'); ?>";
                    jQuery('#register-form').removeAttr('disabled');
                },
                error: function(response){
                    jQuery('#register-form').removeAttr('disabled');
                }
            });
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
<?php
get_footer();