<?php

/* Template Name: CRM Login */
get_header();


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
// http://localhost/Abbi-Cura-Di-Te/crmlogin/?k=MTI0MzJ8MTUyNXxBQUFBQUE3MUEyMUExMjNBfFFVRVNULTAxfDExLzAxLzIwMjMgMTg6MTI6MDA%3D-YzdkMmNhZWY0OTdiODQwYzhlM2I5YTU1MDAwMDMzMzA4NTBkNTQ1YQ%3D%3D

// TO DO CHANGE ID TO DYNAMIC
$idDipendente = 10444; //$dati[0];//
// get data user by idDipendente
$dataUser = UserCRM::Instance()->getUserById($idDipendente);
//get userid  by idDipendente in metaUser if exist in database site
$userSite = UserSite::Instance()->getUserByUserMeta($idDipendente);?>
<div class="main-content-register">
    <div class="container d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col">
                <div class="content">
                    <?php
                    if ($signature == $check):
                        if($dataUser[0]->idDipendente):// idDipendente exist in table crm_user
                            if($userSite): //idDipendente exist in table user site
                                wp_redirect( home_url( '/login/' ) );
                                exit;
                            else:
                                foreach ($dataUser as $data) :
                                    get_template_part("template-parts/registerCrm",null ,['data'=>$data, 'idDipendente'=>$idDipendente]);
                                endforeach;
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
