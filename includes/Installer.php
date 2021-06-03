<?php
namespace Softx\Gold;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Add time and version on DB
     */
    public function add_version() {
        $installed = get_option( 'sf_goldprice_installed' );

        if ( ! $installed ) {
            update_option( 'sf_goldprice_installed', time() );
        }

        update_option( 'sf_goldprice_version', SF_GOLDPRICE_VERSION );
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $gold_price_table = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}gold_price` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `price` int(255) NOT NULL,
            `created_by` bigint(20) unsigned NOT NULL,
          `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
           )  $charset_collate";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $gold_price_table );
    }
}