<?php

require_once 'wp-load.php';
// Define the path to your CSV file
$csv_file = 'path_to_your_csv_file.csv';
$theme_directory = get_template_directory();
// Define the path to the log file
$log_file = $theme_directory.'/log_file_import_csv.log';
var_dump($log_file);
// Open the log file for writing (append mode)
$log_handle = fopen($log_file, 'a');
// Log the start time
$start_time = date('Y-m-d H:i:s');
fwrite($log_handle, "Import started at $start_time\n");

// Open the CSV file
if (($handle = fopen($csv_file, 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        // Assuming the CSV format is "column1,column2,column3"
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
            fwrite($log_handle, "$success_message\n");
        } else {
            // Log skipped user (email already exists)
            $skipped_message = "User skipped (email already exists): Email: $user_email, First Name: $user_first, Last Name: $user_last";
            fwrite($log_handle, "$skipped_message\n");
        }

        // Insert data into WordPress database
        /* $wpdb->insert(
             'wp_posts',
             array(
                 'post_title' => $column1,
                 'post_content' => $column2,
                 'post_status' => 'publish',
                 'post_type' => 'post'
             )
         );*/
    }
    fclose($handle);
}
