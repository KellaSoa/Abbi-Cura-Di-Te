<?php
get_header();
?>
<div class="page-content">
    <?php while(have_posts()) : the_post(); ?>
        <div class="container d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col">
                    <div class="content">
                        <h1 class="m-5"><?php the_title()?></h1>
                        <div class="pageBody p-5 mb-5" >
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer();
