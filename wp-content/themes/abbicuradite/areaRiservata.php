<?php /* Template Name: Area Riservata */
get_header();
canAreaRiservata();
?>
<div class="banner-page pt-5 pb-5" style=" height:500px; background-color:gray">
    <div class="h-50"></div>
    <div class="container pb-5">
        <div class="row">
            <div class="col">
                <h1 class="text-uppercase  text-white fw-bold">Area riservata</h1>

            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
<div class="main-content-area-riservata mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 menuAreaRiservata">
                <nav class="navbar navbar-expand-lg navbar-dark navAreaRiservata" id="sideNav">
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?php site_url('/area-test');?>">Area Test</a></li>
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?php site_url('/area-studio');?>  ">Materiali informativi</a></li>
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?php site_url('/area-profilo');?>">Profilo</a></li>
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?php echo wp_logout_url(site_url('/')); ?>">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-9 contentPageArea">

            </div>
        </div>
    </div>
</div>

<?php
    get_footer();
