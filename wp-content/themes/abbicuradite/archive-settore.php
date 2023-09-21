<?php
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
while($the_query->have_posts()):
    $the_query->the_post();
    //if condition is used to eliminate duplicates, generated by same child post of parent.
    if(!in_array($post->post_parent, $collect_parents)){
        //$collect_parents contains all the parent post id's
        $collect_parents[] = $post->post_parent;
    }
endwhile;?>
<select class="form-select" id="multiple-select-optgroup-field" data-placeholder="Choose anything" multiple>
    //Printing all the parent posts
    <?php foreach($collect_parents as $parent): ?>
        <!-- Printing parent post title -->
        <optgroup label="<?php echo get_the_title($parent); ?>">
            <?php /* <h2 id="<?php echo $parent; ?>"><a href="<?php echo get_permalink($parent ); ?>"> <?php echo get_the_title($parent); ?></a></h2>*/?>
            <?php $currentPostId = $parent;
            $args = array(
                'post_type' => 'settore',
                'post_parent' => $currentPostId
            );
            $posts = new WP_Query($args);
            if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post(); ?>
                <option><?php  echo get_the_title(); ?></option>
            <?php endwhile; endif; ?>
        </optgroup>
    <?php endforeach;?>
</select>