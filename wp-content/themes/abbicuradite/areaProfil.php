<?php /* Template Name: Area profilo */
get_header();
canAreaRiservata();

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
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM regioni Order By nome");
get_template_part("template-parts/banner-area-riservata");
?>
    <div class="main-content-area-riservata my-5">
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
                    <div class="row">
                        <div class="col-6">
                            <fieldset class="border p-2 field">
                                <legend class="float-none w-auto p-2">Dati anagrafici</legend>
                                <div class="control-group mb-3">
                                    <label for="user_first" class="fw-bold">Nome: </label>
                                    <span><?php echo $userMeta['first_name'][0]; ?></span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_last" class="fw-bold">Cognome: </label>
                                    <span><?php echo $userMeta['last_name'][0]; ?></span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_email" class="fw-bold">Email: </label>
                                    <span><?php echo $userInfo->user_email; ?></span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_first" class="fw-bold">Telefono: </label>
                                    <span><?php echo $userMeta['user_phone'][0]; ?></span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_last" class="fw-bold">Codice Fiscale: </label>
                                    <span><?php echo $userMeta['user_code'][0]; ?></span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_last" class="fw-bold">Sesso:</label>
                                    <span><?php
                                        $userSexData = $userMeta['user_sex'][0];
                                        $userSex = ($userSexData == 1)? 'Maschio': 'Femina';
                                        echo $userSex; ?>
                                </span>

                                </div>
                                <div class="control-group mb-3">
                                    <div>
                                        <label for="birthDate" class="fw-bold">Data di nascita:</label>
                                        <span><?php echo $userMeta['user_birth'][0]; ?></span>
                                    </div>
                                </div>

                                <div class="control-group mb-3">
                                    <label for="user_adress" class="fw-bold">Indirizzo: </label>
                                    <span><?php echo $userMeta['user_adress'][0]; ?></span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_cap" class="fw-bold">CAP:</label>
                                    <span><?php echo $userMeta['user_cap'][0]; ?></span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_region" class="fw-bold">Regione:  </label>
                                    <span>
                                    <?php
                                    $user_region = json_decode($userMeta['user_region'][0]);
                                    $user_region_value = $user_region->value;
                                    echo $user_region_value ? $user_region_value : $userMeta['user_region'][0];
                                    ?>
                                </span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_province" class="fw-bold">Provincia: </label>
                                    <span>
                                    <?php
                                    $user_province = json_decode($userMeta['user_province'][0]);
                                    echo $user_province->value ? $user_province->value : $userMeta['user_province'][0] ; ?>
                                </span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="user_comune" class="fw-bold">Comune: </label>
                                    <span>
                                    <?php $user_comune = json_decode($userMeta['user_comune'][0]);
                                    echo $user_comune->value ? $user_comune->value : $userMeta['user_comune'][0]; ?>
                                </span>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="border p-2 field">
                                <legend class="float-none w-auto p-2">Dati aziendali</legend>
                                <div class="control-group mb-3">
                                    <label for="company_user " class="fw-bold">Ragione sociale Azienda: </label>
                                    <span><?php echo $userMeta['company_user'][0]; ?></span>
                                </div>
                                <div class="control-group mb-3">
                                    <label for="iva_company" class="fw-bold">P.IVA: </label>
                                    <span><?php echo $userMeta['iva_company'][0]; ?></span>
                                </div>
                                <?php
                                $sector= $userMeta['sector'][0];
                                $sectorValue= json_decode($sector);?>
                                <div class="control-group mb-3" >
                                    <label for="user_pass_again" class="fw-bold">Settore: </label>
                                    <span><?php echo $sectorValue->parent; ?></span>
                                </div>
                                <div class="control-group mb-3" >
                                    <label for="user_pass_again" class="fw-bold">Mansione: </label>
                                    <span><?php echo $sectorValue->child; ?></span>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <?php $idDipendente = $userMeta['idDipendente'][0];
                    if(isset($idDipendente) && !empty($idDipendente)): ?>
                        <p>I dati visibili sono recuperati dall' anagrafica dell'ente bilaterale</p>
                    <?php else : ?>
                        <div class="mt-3 mb-3">
                            <a href="<?php echo site_url('/area-profil-edit');?>" class="btn btn-primary  btn-scopri">Modifica</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();