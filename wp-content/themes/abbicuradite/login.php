<?php /* Template Name: Login */

get_header();
$redirect_url = home_url('/area-test');
if (is_user_logged_in()):
    // Perform the redirect
    header("Location: $redirect_url");
    exit;
else: ?>
    <div class="main-content-login">
        <div class="container d-flex align-items-center justify-content-center">
            <div class="row my-5">
                <div class="col">
                    <div class="content text-center">
                        <h1 class="my-5"><?php the_title()?></h1>
                        <div class="pageBody p-5 mb-5" >
                            <div class="text-center mb-4">
                                <img class="logo" src="<?php echo get_theme_file_uri('/images/logo.png'); ?>" alt="logo">
                            </div>

                            <?php wp_login_form();?>
                            <small>
                                <?php wp_register('','',true);   ?>
                            </small>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;
get_footer();
