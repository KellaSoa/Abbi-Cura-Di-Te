<?php

/* Template Name: CRM Login */

const SECRET = 'EBT-UMB-PG';

if (!isset($_GET['k'])) {
    http_response_code(403);
}
// get Token
$token = $_GET['k'];
$token = explode('-', $token);

if (count($token) != 2) {
    throw new Exception('');
}

$dati = base64_decode($token[0]);
$signature = $token[1];

$check = base64_encode(sha1($token[0].SECRET));

echo $token[0];

if ($signature == $check) {
    echo 'valid';
} else {
    echo 'not valid';
    http_response_code(403);
}

$dati = explode('|', $dati);
echo $dati[0];
echo 'DATI';
echo $dati[1];

/*
AUTOLOGIN
$user_id = 12345;
$user = get_user_by( 'id', $user_id );
if( $user ) {
    wp_set_current_user( $user_id, $user->user_login );
    wp_set_auth_cookie( $user_id );
    do_action( 'wp_login', $user->user_login );
}
*/

// idDipendente
echo $dati[0];

// SELECT FROM usermeta where meta_key = "idDipendente" AND meta_value=$dati[0]

// if has rows -> AUTOLOGIN
// else SELECT FROM import_table where idDip = $dati[0]

// if has rows -> CREATE USER -> AUTOLOGIN
// else redirect login

// Insert in USER table
$user_email = $data[0];
$user_first = $data[1];
$user_last = $data[2];
$user_phone = $data[3];
$user_code = $data[4];
$company_user = $data[5];
$iva_company = $data[6];
$user_settore = $data[7]; // make th  e same format like data user_ register

// Check if the email already exists in the database
$user = get_user_by('user_email', $user_email);
// also code user unique

if (!$user) {
    // Create a new user
    // $user_id = wp_create_user($user_email, wp_generate_password(), $user_email);
    // Insert data into WordPress database
    $new_user_id = wp_insert_user([
        'user_login' => $user_email,
        'user_email' => $user_email,
        'user_first' => $user_first,
        'user_last' => $user_last,
        // 'user_pass' => $user_pass,
        'user_registered' => date('Y-m-d H:i:s'),
        'role' => 'user',
    ]);
    // insert meta_key user
    update_user_meta($new_user_id, 'first_name', $user_first);
    update_user_meta($new_user_id, 'last_name', $user_last);
    update_user_meta($new_user_id, 'user_phone', $user_phone);
    update_user_meta($new_user_id, 'user_code', $user_code);
    /*update_user_meta($new_user_id, 'user_sex', $user_sex);
    update_user_meta($new_user_id, 'user_birth', $user_birth);
    update_user_meta($new_user_id, 'user_adress', $user_adress);
    update_user_meta($new_user_id, 'user_province', $user_province);
    update_user_meta($new_user_id, 'user_region', $user_region);
    update_user_meta($new_user_id, 'user_comune', $user_comune);
    update_user_meta($new_user_id, 'user_cap', $user_cap);*/

    update_user_meta($new_user_id, 'company_user', $company_user);
    update_user_meta($new_user_id, 'iva_company', $iva_company);
    update_user_meta($new_user_id, 'sector', $user_settore);

    // User csv
    update_user_meta($new_user_id, 'is_user_csv', true);
    // Log successful user creation
    $success_message = "User created: Email: $user_email, First Name: $user_first, Last Name: $user_last";
}
