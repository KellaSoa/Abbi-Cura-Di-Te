<?php
function exercise($perPage,$nameArea =''){
    $args = array(
        'post_type' => 'esercizi',
        'post_status' => 'publish',
        'posts_per_page' => $perPage,
    );

    $loop = new WP_Query( $args );
    while ($loop->have_posts()) :
        $loop->the_post();
        $terms = get_the_terms(get_the_ID(), "area-rischio");
        $slugTaxExercice =[];
        if(!empty($terms)):
            if(empty($nameArea)):
                CardEsercizi($terms);
            else:
                foreach ($terms as $term):
                    $name = explode(' ',$term->name);
                    $slugTaxExercice[] = strtolower($name[0]);
                endforeach;
                if (in_array($nameArea, $slugTaxExercice)):
                    CardEsercizi($terms);
                endif;
            endif;
        endif;
    endwhile;
}
function CardEsercizi($terms){ ?>
    <div class="col-lg-4 mb-3 d-flex align-items-stretch">
        <div class="card esercizi">
            <!--add video-->
            <iframe class="w-100" height="315" src="<?php echo get_field("video_esercizi");?>" title="<?php the_title(); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            <div class="card-body d-flex flex-column">
                <h3 class="card-title title-bloc text-uppercase"><?php the_title(); ?></h3>
                <p class="card-text"><?php the_content(); ?></p>  
            </div>
            <div class="card-footer">
                <?php foreach ($terms as $term): $name = explode(' ',$term->name); ?>
                    <a class="areaRischio " href="<?php echo site_url('/area-rischio/'. strtolower($name[0])); ?>"><span class="areaRischio menu-<?php echo strtolower($name[0]); ?>"> > <?php if(strtolower($name[0]) == 'sbas') echo substr($term->name, 5); else echo substr($term->name, 4); ?></span></a><br>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php }