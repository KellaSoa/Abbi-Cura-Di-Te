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

    public function getUserByUserMeta($idDipendente){
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
}
UserSite::Instance();