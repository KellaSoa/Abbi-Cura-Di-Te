<?php
$page = get_page( 691 );
// Check if the page was found
if ( $page ) {
    // Output the page title
    echo ' <h1 class="my-5">' . $page->post_title . '</h1>';

    // Output the page content
    echo apply_filters( 'the_content', $page->post_content );
    echo '<br>';
    //echo '<a class="btn-test-tax btn-border-radius-bleu mx-auto" href="'.site_url('/').'">entra nel sito</a>';
} else {
    // Page not found
    echo '<p>Page not found.</p>';
}