<?php

/* Template Name: CRM Login */
get_header();

$link_originale = $_GET['k'];
if (!isset($link_originale)) {
    get_template_part("template-parts/page403");
}

$array = explode("-", urldecode($link_originale));

$string_utente = base64_decode($array[0]);
$dati = explode('|', $string_utente);
$dati_utente = base64_encode($string_utente);
$secret_key = "EBT-UMB-PG";

$KeySalt = $dati_utente.$secret_key;

$hash = sha1($KeySalt);
$hash = substr($hash, 0, 6);
$idDipendente = $dati[0];//
$idAzienda = $dati[1];

// get data user by idDipendente
$dataUser = UserCRM::Instance()->getUserById($idDipendente);
//get userid  by idDipendente in metaUser if exist in database site
$idDipendenteInUser = UserSite::Instance()->getUserByUserMeta($idDipendente);

$taxIdCodeUser = $dataUser[0]->CodiceFiscale;

//get user by code fiscale (when user exist in table user and userMeta)
$userWithMeta =  UserSite::Instance()->getllMetaUserByCodeUser($taxIdCodeUser);

$userid = $userWithMeta['user_data'];
$codeUser = $userWithMeta['user_meta'] ['user_code'][0];
/*Login user*/
$user = get_user_by('ID', $userid);
wp_set_current_user($userid, $user->user_login);
wp_set_auth_cookie($userid);
/*end  Login user*/
/*Get redirect user*/
$redirection =  UserSite::Instance()->redirectUserWithToken($userid);
/*end redirect*/
?>
<div class="main-content-register">
    <div class="container d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col">
                <div class="content">
                    <?php
                    if($hash == $array[1]):
                        if($dataUser[0]->idDipendente):// idDipendente exist in table crm_user
                            if($idDipendenteInUser): //idDipendente exist in table user site
                                do_action('wp_login', $user->user_login, $user);
                              wp_redirect($redirection );
                                exit;
                            else:
                                if($codeUser)://User exist in table user because $codeUser exist
                                   //Add meta user idDipendente for this user i.e update user
                                    update_user_meta($userid, 'idDipendente', $idDipendente);
                                    update_user_meta($userid, 'idAzienda', $idAzienda);
                                    do_action('wp_login', $user->user_login, $user);
                                    wp_redirect($redirection);
                                    exit;
                                else:
                                    foreach ($dataUser as $data) :
                                        get_template_part("template-parts/registerCrm",null ,['data'=>$data, 'idDipendente'=>$idDipendente]);
                                    endforeach;
                                endif;
                            endif;
                        else:
                            get_template_part("template-parts/page403");
                        endif;
                    else:
                        get_template_part("template-parts/page403");
                    endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

   <?php get_footer();
