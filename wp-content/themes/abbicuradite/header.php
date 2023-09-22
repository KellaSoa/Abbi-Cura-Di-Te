<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    wp_head();
    global $wpdb;
    $current_user = wp_get_current_user();
    $dataTestUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $current_user->ID");

    if (is_user_logged_in() && $dataTestUser) {
        $url_login = site_url('/area-test');
    } elseif (is_user_logged_in() && !$dataTestUser) {
        $url_login =  site_url('/valutazione/questionario');
    } else {
        $url_login =  site_url('/login');
    }
    ?>
</head>
<body>
<nav class="navbar text-white navbar-expand-lg menu-top">
    <div class="container">
        <div class="collapse navbar-collapse text-white" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ps-2 position-relative">
                    <a class="nav-link active login-link" aria-current="page" href="<?php echo $url_login; ?>">
                        <img class="login" src="<?php echo get_theme_file_uri('/images/login.png'); ?>" alt="login">
                        <?php
                        $userMeta = get_user_meta( $current_user->ID);
                        $nameUser = $userMeta['first_name'][0] ? $userMeta['first_name'][0] : 'admin';
                        if(is_user_logged_in()) echo 'Ciao '.$nameUser;  else echo 'Accedi'?>
                    </a>
                    <?php if(is_user_logged_in()): ?>
                        <div class="login-submenu">
                            <div><?php  echo $nameUser; ?></div>
                            <div>
                                <a href="<?php echo wp_logout_url(site_url('/')); ?>">Logout</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ebtumbria.it/" target="_blank">Ente Bilaterale Turismo</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar text-white text-uppercase navbar-expand-lg menu-primary py-3 sticky-top  nav-menu">
    <div class="container">
        <a class="navbar-brand" href="<?php echo site_url() ?>"><img class="logo" src="<?php echo get_theme_file_uri('/images/logo.png'); ?>" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse position-relative" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo site_url('/') ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="<?php echo site_url('/area-rischio/mmc') ?>" id="navbarDropdown" role="button" data-bs-hover="dropdown" aria-expanded="false">
                        Aree di rischio
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo site_url('/area-rischio/mmc') ?>"><span class="fw-bold">MMC</span> - Movimentazione Manuale dei Carichi</a></li>
                        <li><a class="dropdown-item " href="<?php echo site_url('/area-rischio/sbas') ?>"><span class="fw-bold">SBAS</span> - Sovraccarico biomeccanico arti superiori</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url('/area-rischio/vdt') ?>"><span class="fw-bold">VDT</span> - Postazione lavoro videoterminale</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url('/area-rischio/pst') ?>"><span class="fw-bold">PST</span> - Postura</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('/video-gallery')?>" tabindex="-1" >Video
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('/test') ?>" tabindex="-1" >Test</a>
                </li>
                <?php /*
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('/esercizi')?>" tabindex="-1" >Allena il tuo corpo
                        </a>
                    </li>*/?>
                <li class="nav-item  rounded-top position-relative"><!-- valita -->
                    <div class="position-absolute  rounded-top"></div><!--orange-flag -->
                    <a class="nav-link" href="<?php echo $url_login; ?>" tabindex="-1" >valuta il rischio nel tuo lavoro
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>