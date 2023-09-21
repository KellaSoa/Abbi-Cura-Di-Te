<?php
global $post;
?>

<nav class="navbar navbar-expand-lg navbar-dark navAreaRiservata" id="sideNav">
    <div class="" id="navbarResponsive">
        <ul class="navbar-nav">
            <li class="nav-item <?php if($post->post_name == 'area-test') echo 'active';?>">
                <a class="nav-link js-scroll-trigger" href="<?php echo site_url('/area-test');?>">Area Test</a>
            </li>
            <li class="nav-item <?php if($post->post_name == 'area-studio') echo 'active';?>">
                <a class="nav-link js-scroll-trigger" href="<?php echo site_url('/area-studio');?>  ">Materiali informativi</a>
            </li>
            <li class="nav-item <?php if($post->post_name == 'area-profilo' || $post->post_name == 'area-profil-edit') echo 'active';?>">
                <a class="nav-link js-scroll-trigger" href="<?php echo site_url('/area-profilo');?>">Profilo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="<?php echo wp_logout_url(site_url('/')); ?>>">Logout</a>
            </li>
        </ul>
    </div>
</nav>