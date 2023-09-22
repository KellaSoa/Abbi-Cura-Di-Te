    <div class="site-footer pt-5">
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="pb-3">
                    <a href="<?php echo site_url() ?>"><img class="logo" src="<?php echo get_theme_file_uri('/images/logo.png'); ?>" alt="logo"></a>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-sm-12 col-md-12 col-lg-5">
                    <h6 class="headline fw-bold">Ente Bilaterale Territoriale del Turismo Umbria</h6>
                    <span>Tel.+39 075 506 711</span></br>
                    <span>Mail: info@ebiterumbria.it</span></br>
                    <span>Via Settevalli, 320 - 06126 Perugia</span></br>
                    <span>codice fiscale: 94048500543</span>
                </div>
                <div class="col-6 col-md-6 col-lg-2">
                    <h6 class="headline fw-bold">Link</h6>
                    <ul>
                        <li><a href="<?php echo site_url('/') ?>">Home</a></li>
                        <li><a href="#">Aree di rischio</a></li>
                        <li><a href="<?php echo site_url('/video-gallery') ?>">Video</a></li>
                        <li><a href="<?php echo site_url('/questionario') ?>">Test</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-6 col-lg-2">
                    <h6 class="headline fw-bold">Area riservata</h6>
                    <ul>
                        <?php if(is_user_logged_in()) : ?>
                            <li>
                                <a href="<?php echo site_url('/area-test');?>">Area Test</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/area-studio');?> ">Materiali informativi</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/area-profilo');?>">Profilo</a>
                            </li>
                        <?php else:?>
                            <li><a href="<?php echo site_url('/login'); ?>"><img class="login-footer" src="<?php echo get_theme_file_uri('/images/login-footer.png'); ?>" alt="login-footer"> Login</a></li>
                        <?php endif;?>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="row">
                        <div class="col col-sm-6 col-lg-12 mb-4">
                            <a href="https://www.ebtumbria.it/" target="_blank">
                                <img src="<?php echo get_theme_file_uri('/images/logo-ebitumbria.png'); ?>" alt="Ente Bilaterale del Turismo Umbria" class="d-block mb-2">
                                <span>ebiterumbria.it</span>
                            </a>
                        </div>
                        <div class="col col-sm-6 col-lg-12  mb-4">
                            <li><a href="https://www.inail.it/" target="_blank">
                                    <img src="<?php echo get_theme_file_uri('/images/logo-inail.png'); ?>" alt="Inail" class="d-block mb-2">
                                    <span>inail.it</span>
                                </a>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="footer-privacy">
                <div class="container py-3 d-flex">
                    <ul class="ms-auto list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="#">Privacy Policy - </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">Cookie Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
    </body>
</html>