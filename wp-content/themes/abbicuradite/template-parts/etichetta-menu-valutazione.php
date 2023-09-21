<?php
$dataTestUser=  $args['user'];

$link_questionario = '';
if (is_user_logged_in() && $dataTestUser) {
    $link_questionario = site_url('/area-test');
} elseif (is_user_logged_in() && !$dataTestUser) {
    $link_questionario = site_url('/valutazione/questionario');
} else {
    $link_questionario = site_url('/login');
}
?>

<a class="show-compilare-btn position-fixed" href="<?php echo $link_questionario; ?>">
    <div class="compila">
        <div class="text-white fw-bold yellow-flag p-2">
                <span>
                    Compila subito il questionario
                </span>
            <img class="arrow" src="<?php echo get_theme_file_uri('/images/arrow.png'); ?>" alt="arrow">
        </div>
    </div>
</a>
