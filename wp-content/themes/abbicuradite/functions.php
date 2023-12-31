<?php
require_once __DIR__.'/includes/finishTest.php';
require_once __DIR__.'/includes/getCountCorrectWrongTest.php';
require_once __DIR__.'/includes/getFinalColorValutation.php';
require_once __DIR__.'/includes/getValutazioneBySector.php';
require_once __DIR__.'/includes/AllTestBySector.php';
require_once __DIR__.'/includes/getValutazioneUser.php';
require_once __DIR__.'/includes/allValutazioneBySector.php';
add_action('wp_enqueue_scripts', 'wpdocs_theme_name_scripts');
require_once __DIR__.'/classes/UserCRM.php';
require_once __DIR__.'/classes/UserSite.php';

function wpdocs_theme_name_scripts()
{
    wp_enqueue_style('montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    wp_enqueue_style('montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap-modal-carousel.css');
    wp_enqueue_style('style', get_stylesheet_uri(), [], 1.2);
    wp_enqueue_style('bootstrap-modal-carousel', get_theme_file_uri('/css/bootstrap-modal-carousel.css'));
    wp_enqueue_style('abbicuradite-style', get_stylesheet_directory_uri().'/css/styles.css', [], '6.1');

    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');

    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('bootstrap-modal-carousel', get_theme_file_uri('/js/bootstrap-modal.js'), ['jquery'], false, true);
    wp_enqueue_script('validate-js', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js');
    wp_enqueue_script('additional-methods-js', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js');
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
    wp_enqueue_script('canvas-js', get_stylesheet_directory_uri().'/js/canvas.js');
    wp_enqueue_script('custom', get_stylesheet_directory_uri().'/js/script.js', ['jquery'], 1.2, true);

}

add_action('wp_enqueue_scripts', 'load_dashicons_front_end');
function load_dashicons_front_end()
{
    wp_enqueue_style('dashicons');
}

add_filter('register_url', 'eb_register_url', 10, 1);
function eb_register_url(): ?string
{
    return site_url('register');
}

add_action('wp_ajax_nopriv_register_user', 'register_user');

// register new user
function register_user()
{
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    if (!empty($_POST)) {
        // info perso
        $user_login = $_POST['user_email'] ?? null;
        $user_first = $_POST['user_first'] ;
        $user_last = $_POST['user_last'] ;
        $user_email = $_POST['user_email'] ;
        $user_phone = $_POST['user_phone'] ?? 0;
        $user_code = $_POST['user_tax_id_code'];
        $user_sex = $_POST['user_sex'] ?? null;
        $user_birth = $_POST['user_birth'];
        $user_adress = $_POST['user_adress'];
        $user_region = $_POST['user_region'];
        $user_province = $_POST['user_province'];
        $user_comune = $_POST['user_comune'];
        $user_cap = $_POST['user_cap'];
        $user_pass = $_POST['user_pass'] ?? null;
        $user_pass_again = $_POST['user_pass_again'] ?? null;
        // info company
        $company_user = $_POST['company_user'];
        $iva_company = $_POST['iva_company'];
        $user_settore = $_POST['user_settore'];
        $user_idDipendente = $_POST['idDipendente'] ??  0;
        $user_idAzienda = $_POST['idAzienda'] ??  0;
        $isUserExternal = $_POST['isUserExternal'] ?? '';
        // this is require for username check 
        require_once ABSPATH.WPINC.'/registration.php';
        $new_user_id = wp_insert_user([
            'user_login' => $user_email,
            'user_email' => $user_email,
            'user_first' => $user_first,
            'user_last' => $user_last,
            'user_pass' => $user_pass,
            'user_registered' => date('Y-m-d H:i:s'),
            'role' => 'user',
        ]);

        if ( !is_wp_error( $new_user_id ) ) {
            // insert meta_key user
            update_user_meta($new_user_id, 'first_name', $user_first);
            update_user_meta($new_user_id, 'last_name', $user_last);
            update_user_meta($new_user_id, 'user_phone', $user_phone);
            update_user_meta($new_user_id, 'user_code', $user_code);
            update_user_meta($new_user_id, 'user_sex', $user_sex);
            update_user_meta($new_user_id, 'user_birth', $user_birth);
            update_user_meta($new_user_id, 'user_adress', $user_adress);
            update_user_meta($new_user_id, 'user_province', $user_province);
            update_user_meta($new_user_id, 'user_region', $user_region);
            update_user_meta($new_user_id, 'user_comune', $user_comune);
            update_user_meta($new_user_id, 'user_cap', $user_cap);

            update_user_meta($new_user_id, 'company_user', $company_user);
            update_user_meta($new_user_id, 'iva_company', $iva_company);
            update_user_meta($new_user_id, 'sector', $user_settore);
            update_user_meta($new_user_id, 'idDipendente', $user_idDipendente);
            update_user_meta($new_user_id, 'idAzienda', $user_idAzienda);
            update_user_meta($new_user_id, 'isUserExternal', $isUserExternal);


            $checkout_option = isset($_POST['privacy_policy']) ? sanitize_text_field($_POST['privacy_policy']) : '';
            update_user_meta($new_user_id, 'privacy_policy', $checkout_option);

            $checkout_option = isset($_POST['privacy_policy']) ? sanitize_text_field($_POST['privacy_policy']) : '';
            update_user_meta($new_user_id, 'privacy_policy', $checkout_option);

            $user_id = $new_user_id;
            $user = get_user_by('ID', $user_id);
            wp_clear_auth_cookie();
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user->user_login, $user);

            $response = array('success' => true);
        } else {
            $response = array('success' => false, 'message' => $new_user_id->get_error_message());
        }

        wp_send_json($response);
    }
    wp_die();
}
// add colum sector in users table admin
function theme_add_user_sector_column($columns)
{
    $columns['sector'] = __('Settore', 'theme');

    return $columns;
}
add_filter('manage_users_columns', 'theme_add_user_sector_column');

// show data colum sector in users table admin
function theme_show_user_sector_data($value, $column_name, $user_id)
{
    if ('sector' == $column_name) {
        $sectorData = get_user_meta($user_id, 'sector', true);
        $sector = json_decode($sectorData, true);

        return $sector['parent'].'-'.$sector['child'];
    } // end if
}
add_action('manage_users_custom_column', 'theme_show_user_sector_data', 10, 3);

// getRegionOrProvince in register
function getAllData()
{
    global $wpdb;
    if (!empty($_POST['codRegione'])) {
        $codRegione = $_POST['codRegione'];
        $results = $wpdb->get_results('Select* From province Where codice_regione = '.$codRegione.' Order By nome');
        echo '<option value="">Seleziona la Provincia</option>';
        foreach ($results as $res) {
            $valJson = '{"id":"'.$res->codice.'","value":"'.$res->nome.'"}';
            echo "<option  value = '".$valJson."' data-id='".$res->codice."' >".$res->nome.'</option >';
        }
    } else {
        if (!empty($_POST['codProvincia'])) {
            $codProvincia = $_POST['codProvincia'];
            $results = $wpdb->get_results('Select * From comuni Where codice_provincia = '.$codProvincia.' Order By nome');
            echo '<option value="">Seleziona il Comune</option>';
            foreach ($results as $res) {
                $valJson = '{"id":"'.$res->codice.'","value":"'.$res->nome.'"}';
                echo "<option  value = '".$valJson."' data-id='".$res->codice."' >".$res->nome.'</option >';
            }
        }
    }
}
add_action('wp_ajax_getRegionOrProvince', 'getAllData');
add_action('wp_ajax_nopriv_getRegionOrProvince', 'getAllData');

function canAreaRiservata()
{
    if (!is_user_logged_in()) {
        wp_safe_redirect(home_url());
    }
}

add_action('wp_ajax_update_register_user', 'update_register_user');
// add_action('wp_ajax_nopriv_update_register_user', 'update_register_user');
// register new user
function update_register_user()
{
    $user_id = (int) $_POST['id_user'];
    if (!empty($_POST)) {
        // info perso
        $user_first = $_POST['user_first'];
        $user_last = $_POST['user_last'];
        $user_email = $_POST['user_email'];
        $user_phone = $_POST['user_phone'];
        $user_code = $_POST['user_tax_id_code'];
        $user_sex = $_POST['user_sex'];
        $user_birth = $_POST['user_birth'];
        $user_adress = $_POST['user_adress'];
        $user_cap = $_POST['user_cap'];
        $user_region = $_POST['user_region'];
        $user_province = $_POST['user_province'];
        $user_comune = $_POST['user_comune'];
        $user_pass = $_POST['user_pass'];
        $user_pass_again = $_POST['user_pass_again'];
        // info company
        $company_user = $_POST['company_user'];
        $iva_company = $_POST['iva_company'];
        $user_settore = $_POST['user_settore'];
        // this is require for username check
        require_once ABSPATH.WPINC.'/registration.php';
        $new_user_id = wp_update_user([
            'ID' => $user_id,
            'user_login' => $_POST['user_email'],
            'user_email' => $user_email,
            'display_name' => $_POST['user_email'],
            /*'user_last' => $user_last,
            'user_pass' => $user_pass,*/
            'user_registered' => date('Y-m-d H:i:s'),
        ]);
        // insert meta_key user
        update_user_meta($new_user_id, 'first_name', $user_first);
        update_user_meta($new_user_id, 'last_name', $user_last);
        update_user_meta($new_user_id, 'user_phone', $user_phone);
        update_user_meta($new_user_id, 'user_code', $user_code);
        update_user_meta($new_user_id, 'user_sex', $user_sex);
        update_user_meta($new_user_id, 'user_birth', $user_birth);
        update_user_meta($new_user_id, 'user_adress', $user_adress);
        update_user_meta($new_user_id, 'user_province', $user_province);
        update_user_meta($new_user_id, 'user_region', $user_region);
        update_user_meta($new_user_id, 'user_comune', $user_comune);
        update_user_meta($new_user_id, 'user_cap', $user_cap);

        update_user_meta($new_user_id, 'company_user', $company_user);
        update_user_meta($new_user_id, 'iva_company', $iva_company);
        update_user_meta($new_user_id, 'sector', $user_settore);

        // send email to admin
        // wp_new_user_notification($new_user_id);
        // log the user in
        // wp_setcookie($user_login,$user_pass, true);
        // wp_set_current_user($new_user_id,$user_login);
        // do_action('wp_login',$user_login);
        return json_encode(['success' => true]);
    }
}

// logout
add_action('wp_logout', 'auto_redirect_after_logout');
function auto_redirect_after_logout()
{
    wp_safe_redirect(home_url());
    exit;
}

// Add test User
add_action('wp_ajax_add_test_user', 'add_test_user');
function add_test_user()
{
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    global $wpdb;
    $tablename = $wpdb->prefix.'questionario';
    $data = $_POST['data'];
    $data = str_replace('\\', '', $data);
    /*$data = str_replace('[{', '{{', $data);
    $data = str_replace('}]', '}}', $data);*/
    $idUser = $_POST['userId'];
    $idTest = $_POST['idTest'];
    if (!session_id()) {
        session_start();
    }

    $getTestUser = $wpdb->query($wpdb->prepare("SELECT * FROM $tablename WHERE user_id=$idUser AND id_test = $idTest"));

    if ($getTestUser) {
        $userTest = $wpdb->query($wpdb->prepare("UPDATE $tablename SET data='$data' WHERE user_id=$idUser AND id_test = $idTest"));
    } else {
        $userTest = $wpdb->insert($tablename, [
            'user_id' => $idUser,
            'id_test' => $idTest,
            'data' => $data,
        ]);
    }
    if ($userTest) {
        $_SESSION['last_test'] = $idTest;
        echo json_encode(['success' => true, 'redirect' => home_url('/area-test?idTest='.$idTest)]);
    } else {
        echo json_encode(['error' => 'error insert test user']);
    }
    wp_die();
}
// Add test  Valutazione User

add_action('wp_ajax_add_test_valutazione_user', 'add_test_valutazione_user');
function add_test_valutazione_user()
{
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    global $wpdb;
    $tablename = $wpdb->prefix.'valutazione';
    $idUser = $_POST['userId'];
    $idPostType = $_POST['idPostType'];
    $data = $_POST['data'];
    $data = str_replace('\\', '', $data);
    $getTestUser = $wpdb->query($wpdb->prepare("SELECT * FROM $tablename WHERE user_id=$idUser AND idPostType=$idPostType"));
    if ($getTestUser) {
        $userTest = $wpdb->query($wpdb->prepare("UPDATE $tablename SET data='$data' WHERE user_id=$idUser AND idPostType=$idPostType"));
    } else {
        $userTest = $wpdb->insert($tablename, [
            'user_id' => $idUser,
            'idPostType' => $idPostType,
            'data' => $data,
        ]);
    }
    if ($userTest) {
        echo json_encode(['success' => true, 'redirect' => home_url('/area-valutazione')]);
    } else {
        echo json_encode(['error' => 'error insert test user']);
    }
    wp_die();
}

/**
 * @param WP_User $user logged user's data
 *
 * @return string
 */
function my_login_redirect($redirect_to, $request, $user)
{
    global $wpdb;
    $link_originale = $_GET['k'];
    $dataTestUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $user->ID");
    if (isset($user->roles) && is_array($user->roles)) {
        // check for admins
        if (in_array('administrator', $user->roles) || $dataTestUser) {
            $redirect_to = home_url('/area-test');
        } elseif($link_originale) {
            $current_url = home_url(add_query_arg(array(), $wpdb->request));
            $redirect_to = $current_url;
        }
        else{
            $redirect_to = home_url('/valutazione/questionario');
        }
    }

    return $redirect_to;
}
add_filter('login_redirect', 'my_login_redirect', 10, 3);

// remove admin bar
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

add_action('init', 'my_remove_editor_from_post_type');
function my_remove_editor_from_post_type()
{
    remove_post_type_support('page', 'editor');
}

/**
 * Display taxonomy selection as dropdown.
 *
 * @param WP_Post $post
 * @param array   $box
 */
function cb_taxonomy_select_meta_box($post, $box)
{
    $screen = get_current_screen();
    if ($screen->id === 'esercizi') {
        post_tags_meta_box($post, $box);

        return;
    }

    $defaults = ['taxonomy' => 'category'];

    if (!isset($box['args']) || !is_array($box['args'])) {
        $args = [];
    } else {
        $args = $box['args'];
    }

    extract(wp_parse_args($args, $defaults), EXTR_SKIP);

    $tax = get_taxonomy($taxonomy);
    $selected = wp_get_object_terms($post->ID, $taxonomy, ['fields' => 'ids']);
    $hierarchical = $tax->hierarchical;
    ?>
    <div id="taxonomy-<?php echo $taxonomy; ?>" class="selectdiv">
        <?php
        if (current_user_can($tax->cap->edit_terms)) {
            if ($hierarchical) {
                wp_dropdown_categories([
                    'taxonomy' => $taxonomy,
                    'class' => 'widefat',
                    'hide_empty' => 0,
                    'name' => "tax_input[$taxonomy][]",
                    'selected' => count($selected) >= 1 ? $selected[0] : '',
                    'orderby' => 'name',
                    'hierarchical' => 1,
                    'show_option_all' => ' ',
                ]);
            } else {?>
                <select name="<?php echo "tax_input[$taxonomy][]"; ?>" class="widefat">
                    <option value="0"></option>
                    <?php foreach (get_terms($taxonomy, ['hide_empty' => false]) as $term) { ?>
                        <option value="<?php echo esc_attr($term->slug); ?>" <?php echo selected($term->term_id, count($selected) >= 1 ? $selected[0] : ''); ?>><?php echo esc_html($term->name); ?></option>
                    <?php } ?>
                </select>
                <?php
            }
        }
    ?>
    </div>
    <?php
}
// change login label
function gettext_filter($translation, $orig, $domain)
{
    switch ($orig) {
        case 'Username o Indirizzo Email':
            $translation = 'Indirizzo Email';
            break;
    }

    return $translation;
}
add_filter('gettext', 'gettext_filter', 10, 3);

function force_post_categ_init()
{
    wp_enqueue_script('jquery');
}

function acf_load_color_field_choices($field)
{
    // Reset choices
    $field['choices'] = [];

    // Get the Text Area values from the options page without any formatting
    $choices = get_field('area_di_rischio_video_youtube', 'option', false);

    // Explode the value so each line is a new element in the array
    $choices = explode("\n", $choices);

    // Remove unwanted white space
    $choices = array_map('trim', $choices);

    // Loop through the array and add to field 'choices'
    if (is_array($choices)) {
        foreach ($choices as $choice) {
            $field['choices'][$choice] = $choice;
        }
    }

    // Return the field
    return $field;
}

add_filter('acf/load_field/name=color', 'acf_load_color_field_choices');

add_action('add_meta_boxes', 'csv_register_meta_boxes');
function csv_register_meta_boxes()
{
    add_meta_box('eb-export-csv', __('EXPORT RISPOSTE CSV', 'textdomain'), 'export_csv_display', 'test', 'side');
}

function export_csv_display()
{
    $postID = intval($_GET['post']);
    ?>
    <p>
        Scarica il report delle risposte degli utenti.
    </p>

    <a target="_blank" href="<?php echo admin_url("admin-ajax.php?post={$postID}&action=export_csv"); ?>" class="button button-primary button-large" style="width: 100%; text-align:center">EXPORT</a>
    <?php
    echo '<b';
}

add_action('wp_ajax_export_csv', 'export_csv');
function export_csv()
{
    // header csv
    $postID = intval($_GET['post']);
    $timestamp = date('Y-m-d_H-i');
    $filename = str_replace(' ', '-', get_the_title($postID)).'_'.$timestamp.'.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'"');

    $csv = csv_data($postID);

    $fp = fopen('php://output', 'wb');
    fwrite($fp, "\xEF\xBB\xBF");
    foreach ($csv as $line) {
        fputcsv($fp, $line, ',');
    }
    fclose($fp);

    wp_die();
}

function csv_data($postID): array
{
    $csv = [];

    $idUsers = getDataUser($postID);
    $dataUsers = getMetaUserAndDataTests($idUsers, $postID);
    $rows = [];
    // TODO: Header row for empty csv
    foreach ($dataUsers as $user) {
        $row = [];
        $row['Cognome'] = $user['last_name'];
        $row['Nome'] = $user['first_name'];
        $row['Email'] = $user['nickname'];
        $row['Codice fiscale'] = $user['user_code'];
        $row['Settore'] = $user['settore'];
        $row['Mansione'] = $user['mansione'];
        $row['Azienda'] = $user['company_user'];
        $row['P.IVA'] = $user['iva_company'];

        $questions = json_decode($user['datas']);
        foreach ($questions as $question) {
            $row[$question->valueQuestion] = $question->valueAnswer;
        }
        $result = $user['resultTest'];
        $row['risposte giuste'] = $result['correct'];
        $row['risposte errate'] = $result['wrong'];
        $row['percentuale risposte'] = round($result['percent']).'%';

        $row['fascia profilo di rischio'] = $user['colorFinal'];

        $csv[] = $row;
    }

    $firstrows = array_keys($csv[0] ?? []);
    $csv = [$firstrows, ...$csv];

    return $csv;
}
function getMetaUserAndDataTests($idUsers, $idTest)
{
    $users = [];
    global $wpdb;
    $tablename = $wpdb->prefix.'questionario';

    foreach ($idUsers as $iduser) {
        $dataTestUser = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tablename WHERE  id_test = $idTest AND user_id = $iduser"));
        $users[$iduser] = [];
        $users[$iduser]['first_name'] = get_user_meta($iduser, 'first_name', true);
        $users[$iduser]['last_name'] = get_user_meta($iduser, 'last_name', true);
        $users[$iduser]['nickname'] = get_user_meta($iduser, 'nickname', true); // email
        // $users[$iduser]["user_phone"] = get_user_meta ($iduser, "user_phone"); //phone
        $users[$iduser]['user_code'] = get_user_meta($iduser, 'user_code', true); // code fiscale
        $sectorData = get_user_meta($iduser, 'sector', true); // settore
        $sector = json_decode($sectorData, true);
        $users[$iduser]['settore'] = $sector['parent'];
        $users[$iduser]['mansione'] = $sector['child'];
        $users[$iduser]['company_user'] = get_user_meta($iduser, 'company_user', true); // code fiscale
        $users[$iduser]['iva_company'] = get_user_meta($iduser, 'iva_company', true); // IVA
        // all other keys

        // datas test and anwers
        $data = $dataTestUser[0]->data;
        $users[$iduser]['datas'] = $data;
        // Result test user

        $resultTest = getCountCorrectWrongTest($iduser, $idTest);
        $users[$iduser]['resultTest'] = $resultTest;
        $colorFinal = getFinalColorValutation($iduser);
        $users[$iduser]['colorFinal'] = $colorFinal;
    }

    return $users;
}
function getDataUser($postID)
{
    global $wpdb;
    $tablename = $wpdb->prefix.'questionario';
    $idUsersDoneTest = $wpdb->get_results($wpdb->prepare("SELECT `user_id` FROM $tablename WHERE  id_test = $postID"));
    $idUsers = [];
    if (!empty($idUsersDoneTest)) {
        foreach ($idUsersDoneTest as $key => $item) {
            $datas = $item->user_id;
            $idUsers[] = json_decode($datas, true);
        }
    }

    return $idUsers;
}
add_action('login_form_middle', 'add_lost_password_link');
function add_lost_password_link()
{
    return '<a href='.wp_lostpassword_url().'>Password dimenticata?</a>';
}

// change login label
function gettext_filter_lost_password($translation, $orig, $domain)
{
    switch ($orig) {
        case 'Username or Email Address':
            $translation = 'Indirizzo Email';
            break;
    }

    return $translation;
}
add_filter('gettext', 'gettext_filter_lost_password', 10, 3);

// return only parent settore in relation with valutazione
function filter_relationship_field_query($args, $field, $post_id)
{
    // Check if this is the specific field you want to filter
    if ($field['name'] === 'settoreUtenti') {
        // Add a filter to the query to only show parent posts
        $args['post_parent'] = 0;
    }

    return $args;
}

add_filter('acf/fields/relationship/query', 'filter_relationship_field_query', 10, 3);

// Add column Sector in table postType Valutazione
function custom_column_header($columns)
{
    $columns['custom_column'] = 'Settore';

    return $columns;
}
$post_type = 'valutazione';
add_filter("manage_{$post_type}_posts_columns", 'custom_column_header');

function custom_column_content($column, $post_id)
{
    if ($column == 'custom_column') {
        getSectorSelectedInEachValutazione($post_id);
    }
}
add_action("manage_{$post_type}_posts_custom_column", 'custom_column_content', 10, 2);
// end add column Sector in table postType Valutazione
// Begin Order column in table postType Valutazione
function reorder_admin_columns($columns)
{
    $custom_column = $columns['custom_column'];
    unset($columns['custom_column']);
    $columns = array_slice($columns, 0, 2, true) + ['custom_column' => $custom_column] + array_slice($columns, 2, count($columns) - 2, true);

    return $columns;
}
add_filter("manage_{$post_type}_posts_columns", 'reorder_admin_columns');
// END Order column in table postType Valutazione
// Add column Sector in table postType Test
function custom_column_header_test($columns)
{
    $columns['custom_column'] = 'Settore';

    return $columns;
}
$post_type = 'test';
add_filter("manage_{$post_type}_posts_columns", 'custom_column_header_test');

function custom_column_content_test($column, $post_id)
{
    if ($column == 'custom_column') {
        getSectorSelectedInEachTest($post_id);
    }
}
add_action("manage_{$post_type}_posts_custom_column", 'custom_column_content_test', 10, 2);
// end add column Sector in table postType Test
// Begin Order column in table postType Test
function reorder_admin_columns_test($columns)
{
    $custom_column = $columns['custom_column'];
    unset($columns['custom_column']);
    $columns = array_slice($columns, 0, 2, true) + ['custom_column' => $custom_column] + array_slice($columns, 2, count($columns) - 2, true);

    return $columns;
}
add_filter("manage_{$post_type}_posts_columns", 'reorder_admin_columns_test');
// END Order column in table postType Test

// Add privacy in register

function check_privacy_checkbox($errors, $sanitized_user_login, $user_email)
{
    if (empty($_POST['privacy_policy'])) {
        $errors->add('privacy_policy_error', __('È necessario accettare Privacy Policy.', 'abbicuradite'));
    }

    return $errors;
}

add_filter('registration_errors', 'check_privacy_checkbox', 10, 3);

function save_checkout_field($user_id)
{
    if (isset($_POST['privacy_policy'])) {
        update_user_meta($user_id, 'privacy_policy', sanitize_text_field($_POST['privacy_policy']));
    }
}

add_action('user_register', 'save_checkout_field');
// END privacy register

// BEGIN CRON
function import_user_crm_callback()
{
    $processor = UserCRM::Instance();
    $processor->truncateTableAndLog();
    $processor->CSVProcessor();
}

add_action('import_user_crm', 'import_user_crm_callback');

function activate() {
    wp_schedule_event( strtotime('10:44:00'), 'daily', 'import_user_crm' );
}

function deactivate() {
    wp_clear_scheduled_hook('import_user_crm');
}


function trigger_custom_event()
{
    do_action('import_user_crm');
}
// END CRON

//AUTOLOGIN
function custom_auto_login() {
    $user_id = $_POST['user_id'];
    $user = get_user_by('ID', $user_id);
    wp_set_current_user($user_id, $user->user_login);
    wp_set_auth_cookie($user_id);
    do_action('wp_login', $user->user_login, $user);

    $response = array('success' => true);
    wp_send_json($response);
}
add_action('wp_ajax_custom_auto_login', 'custom_auto_login');

/*ADD BUTTON EXPORT CSV USER EXTERNAL*/
// Add custom button to the top of the user list table

add_action('wp_ajax_export_users_csv', 'export_users_csv');
function export_users_csv() {

    $timestamp = date('Y-m-d_H-i');
    $filename = 'export-utenti-esterni-ebt-'.$timestamp.'.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="'.$filename.'"');

    $csv = dataUserExternal();
    $fp = fopen('php://output', 'wb');
    fwrite($fp, "\xEF\xBB\xBF");

    foreach ($csv as $line) {
        fputcsv($fp, $line,',');
    }
    fclose($fp);
    wp_die();
}
function dataUserExternal(): array
{
    $csv = [];

    $dataUsers = UserSite::Instance()->getAllUserExternal();
    $rows = [];
    // TODO: Header row for empty csv
    foreach ($dataUsers as $user) {
        $row = [];
        $idDipendente   = get_user_meta($user->ID, 'idDipendente', true) ?? 0;
        $last_name      = get_user_meta($user->ID, 'last_name', true);
        $first_name     = get_user_meta($user->ID, 'first_name', true);
        $adress         = get_user_meta($user->ID, 'user_adress', true);
        $localita       = get_user_meta($user->ID, 'user_comune', true);
        $user_localita  = json_decode($localita);
        $localitaValue = $user_localita->value ?? '';
        $cap            = get_user_meta($user->ID, 'user_cap', true);
        $provincia      = get_user_meta($user->ID, 'user_province', true);
        $user_province  = json_decode($provincia);
        $provinciaValue = $user_province->value ?? '';

        $nickname       = get_user_meta($user->ID, 'nickname', true);
        $sex            = get_user_meta($user->ID, 'user_sex', true);
        $sexValue       = $sex == 1 ? 'M' : 'F';
        $birth          = get_user_meta($user->ID, 'user_birth', true);

        $user_code      = get_user_meta($user->ID, 'user_code', true);
        $sectorData     = get_user_meta($user->ID, 'sector', true);
        $sector         = json_decode($sectorData, true);
        $idAzienda      = get_user_meta($user->ID, 'idAzienda', true) ?? 0;
        $company_user   = get_user_meta($user->ID, 'company_user', true);
        $iva_company    = get_user_meta($user->ID, 'iva_company', true);

        $row['IdDipendente']    = $idDipendente;
        $row['Cognome']         = $last_name;
        $row['Nome']            = $first_name;
        $row['Indirizzo']       = $adress;
        $row['Localita']        = $localitaValue;
        $row['Cap']             = $cap;
        $row['Provincia']       = $provinciaValue;
        $row['Email']           = $nickname;
        $row['CodiceFiscale']   = $user_code;
        $row['Settore']         = $sector['parent'];
        $row['Mansione']        = $sector['child'];
        $row['Sesso']           = $sexValue;
        $row['DataNascita']     = $birth;
        $row['IdAzienda']       = $idAzienda;
        $row['RagioneSociale']  = $company_user;
        $row['DataNascita']     = $sector['child'];
        $row['Azienda']         = $company_user;
        $row['P.IVA']           = $iva_company;

        $csv[] = $row;
    }
    $firstrows = array_keys($csv[0] ?? []);
    $csv = [$firstrows, ...$csv];

    return $csv;
}
function add_export_csv_endpoint() {
    add_submenu_page(
        null,
        'Export Users CSV',
        'Export Users CSV',
        'export',
        'export_users_csv',
        'export_users_csv'
    );
}
add_action('admin_menu', 'add_export_csv_endpoint');

function add_export_csv_button() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let exportButton = document.createElement('a');
            exportButton.classList.add('button');
            exportButton.classList.add('button-primary');
            exportButton.href = '<?php echo admin_url('admin-ajax.php?action=export_users_csv'); ?>';
            exportButton.innerText = 'Export UTENTI ESTERNI EBT';
            exportButton.target = '_blank';
            let actions = document.querySelector('.alignleft.actions');
            actions.appendChild(exportButton);
        });
    </script>
    <?php
}
add_action('admin_footer-users.php', 'add_export_csv_button');
/*END BUTTON CSV USER*/

/*CRON IMPORT USERS*/
register_activation_hook(__FILE__, 'activate_csv_export_cron');

function activate_csv_export_cron() {
    if (!wp_next_scheduled('export_csv_user_external')) {
        wp_schedule_event(time(), 'daily', 'export_csv_user_external');
    }
}

// Deactivate the cron job on plugin deactivation
register_deactivation_hook(__FILE__, 'deactivate_csv_export_cron');

function deactivate_csv_export_cron() {
    wp_clear_scheduled_hook('export_csv_user_external');
}

// Define the cron event
add_action('export_csv_user_external', 'export_csv_users');

// Function to export CSV users
function export_csv_users() {
    $csv_file_path= CRM_FTP_PATH.'/users.csv';

    $csv_data = dataUserExternal();
    $fp = fopen($csv_file_path, 'w');
    fwrite($fp, "\xEF\xBB\xBF");

    foreach ($csv_data as $line) {
        fputcsv($fp, $line,',');
    }
    fclose($fp);
    wp_die();
}

/*END CRON IMPORT USERS*/
