<?php
class UserSite
{
    private $wpdb;
    protected static ?UserSite $instance = null;

    protected function __construct()
    {
        self::$instance = &$this;
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public static function Instance(): UserSite
    {
        return is_null(self::$instance) ? new UserSite() : self::$instance;
    }

    public function getUserByUserMeta($idDipendente) {
        $meta_key = 'idDipendente';
        $meta_value = $idDipendente;

        // Query users with the specified meta key and value
        $user_query = new WP_User_Query( array(
            'meta_key'   => $meta_key,
            'meta_value' => $meta_value
        ) );

        // Get the list of users
        $users = $user_query->get_results();

        if ( ! empty( $users ) ) {
            // Loop through the results
            foreach ( $users as $user ) {
                // Access user properties
                return  $user->ID;
            }
        } else {
            return null;
        }
    }


    public function getllMetaUserByCodeUser($user_code){

        $user_id = $this->getIdUserByCode($user_code);
        // Get user meta
        $user_meta = get_user_meta($user_id);

        // Combine user data and user meta
        $user_with_meta = array(
            'user_data' => $user_id,
            'user_meta' => $user_meta
        );
        return $user_with_meta;
    // Now $user_meta_values contains an array of user IDs as keys and their corresponding meta values
    }

    public function getIdUserByCode($user_code){
        $meta_key = 'user_code';
        $meta_value = $user_code;

        // Query users with the specified meta key and value
        $user_query = new WP_User_Query( array(
            'meta_key'   => $meta_key,
            'meta_value' => $meta_value
        ) );

        // Get the list of users
        $users = $user_query->get_results();
        $user_id = '';
        if ( ! empty( $users ) ) {
            // Loop through the results
            foreach ( $users as $user ) {
                // Access user properties
                return  $user->ID;
            }
        }
    }

    //Get User When IdDipendente null
    public function getAllUserExternal() {

        $args = array(
            'orderby' => 'ID', // user ID
            'order'   => 'ASC',
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'idDipendente     ',
                    'compare' => 'NOT EXISTS',
                ),
                array(
                    'key' => 'idDipendente',
                    'compare' => 'EXISTS',
                    'value' => '0', // Check if the meta value is empty
                ),
            ),
        );

        $user_query = new WP_User_Query($args);

        // Get the list of users
        $users = $user_query->get_results();

        $datas = array();
        if (!empty( $users ) ) {
            // Loop through the results
            foreach ( $users as $user ) {
                // Access user properties
                $datas[] = $user;
            }
        } else {
            return null;
        }
        return $datas;
    }

    public function redirectUserWithToken($userid,$current_url){

        $dataTestUser = $this->wpdb->get_results("SELECT * FROM wp_valutazione WHERE user_id = $userid");
        if (is_user_logged_in() && $dataTestUser) {
            $redirect = $current_url;//site_url('/area-test');
        } elseif (is_user_logged_in() && empty($dataTestUser))  {
            $idValutazioneUser = getValutazioneUser();
            $redirect = get_permalink($idValutazioneUser); // Get the permalink
        } else {
            $redirect =  site_url('/login');
        }
        return $redirect;
    }
}
UserSite::Instance();