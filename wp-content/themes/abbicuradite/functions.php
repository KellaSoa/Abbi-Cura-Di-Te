<?php
require_once __DIR__.'/includes/finishTest.php';
require_once __DIR__.'/includes/getCountCorrectWrongTest.php';
require_once __DIR__.'/includes/getFinalColorValutation.php';

add_action('wp_enqueue_scripts', 'wpdocs_theme_name_scripts');
function wpdocs_theme_name_scripts()
{
    wp_enqueue_style('montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    wp_enqueue_style('montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap-modal-carousel.css');
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('bootstrap-modal-carousel', get_theme_file_uri('/css/bootstrap-modal-carousel.css'));
    wp_enqueue_style('abbicuradite-style', get_stylesheet_directory_uri().'/css/styles.css', [], '4');

    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');

    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('bootstrap-modal-carousel', get_theme_file_uri('/js/bootstrap-modal.js'), ['jquery'], false, true);
    wp_enqueue_script('validate-js', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js');
    wp_enqueue_script('additional-methods-js', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js');
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
    wp_enqueue_script('canvas-js', get_stylesheet_directory_uri().'/js/canvas.js');
    wp_enqueue_script('custom', get_stylesheet_directory_uri().'/js/script.js',
        ['jquery'], false, true);
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
        $user_login = $_POST['user_email'];
        $user_first = $_POST['user_first'];
        $user_last = $_POST['user_last'];
        $user_email = $_POST['user_email'];
        $user_phone = $_POST['user_phone'];
        $user_code = $_POST['user_tax_id_code'];
        $user_sex = $_POST['user_sex'];
        $user_birth = $_POST['user_birth'];
        $user_adress = $_POST['user_adress'];
        $user_region = $_POST['user_region'];
        $user_province = $_POST['user_province'];
        $user_comune = $_POST['user_comune'];
        $user_cap = $_POST['user_cap'];
        $user_pass = $_POST['user_pass'];
        $user_pass_again = $_POST['user_pass_again'];
        // info company
        $company_user = $_POST['company_user'];
        $iva_company = $_POST['iva_company'];
        $user_settore = $_POST['user_settore'];
        // this is require for username check
        require_once ABSPATH.WPINC.'/registration.php';
        $new_user_id = wp_insert_user([
            'user_login' => $_POST['user_email'],
            'user_email' => $user_email,
            'user_first' => $user_first,
            'user_last' => $user_last,
            'user_pass' => $user_pass,
            'user_registered' => date('Y-m-d H:i:s'),
            'role' => 'user',
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
        if ($new_user_id && !is_wp_error($new_user_id)) {
            // send email to admin
            // wp_new_user_notification($new_user_id);
            // log the user in
            wp_setcookie($user_login, $user_pass, true);
            wp_set_current_user($new_user_id, $user_login);
            do_action('wp_login', $user_login);
            echo json_encode(['success' => true, 'redirect' => home_url('/area-test')]);
        } elseif (is_wp_error($new_user_id)) {
            echo json_encode(['success' => false, 'error' => $new_user_id->errors]);
        }
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
 * @param WP_User $user Logged user's data.
 *
 * @return string
 */
function my_login_redirect($redirect_to, $request, $user)
{
    global $wpdb;
    $dataTestUser = $wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $user->ID");
    if (isset($user->roles) && is_array($user->roles)) {
        // check for admins
        if (in_array('administrator', $user->roles) || $dataTestUser) {
            $redirect_to = home_url('/area-test');
        } else {
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
// taxonomy default value for post_type esercizi and test
/*function mfields_set_default_object_terms( $post_id, $post ) {
    if ($post->post_type == 'test' || $post->post_type == 'esercizi')
        wp_set_object_terms($post_id,'mmc', 'area-rischio',true);
}
add_action( 'save_post', 'mfields_set_default_object_terms', 30, 2 );*/
