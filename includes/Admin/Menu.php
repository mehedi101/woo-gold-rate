<?php
namespace Softx\Gold\Admin;

/**
 * The Menu handler class
 */
class Menu {

    public $goldPriceList;
    /**
     * Initialize the class
     */
    function __construct( $goldPriceList ) {
        $this->goldPriceList = $goldPriceList;

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug= 'gold-price';
        $capability= 'manage_options';

        $hook = add_menu_page( __( 'Softx Goldprice', 'gold-price' ), __( 'Gold price', 'gold-price' ), $capability, $parent_slug, [ $this->goldPriceList, 'plugin_page' ], 'dashicons-welcome-learn-more' );
        add_submenu_page( $parent_slug, __( 'Price list', 'gold-price' ), __( 'Price list', 'gold-price' ), $capability, $parent_slug, [  $this->goldPriceList, 'plugin_page'] );
        add_submenu_page( $parent_slug, __( 'Settings', 'gold-price' ), __( 'Settings', 'gold-price' ), $capability, 'gold-price-settings', [ $this, 'settings_page' ] );
        
      //  add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
        add_action( 'admin_head', [ $this, 'enqueue_assets' ] );
    }

    /**
     * Render the plugin page
     *
     * @return void
     */
    

    public function goldPriceList_page() {
        $goldPriceList = new Goldpricebook();
        $goldPriceList->plugin_page();
        
    }

    /**
     * Handles the settings page
     *
     * @return void
     */
    public function settings_page() {
        echo 'Settings Page';
    }

      /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'price-admin-style' );
        wp_enqueue_script( 'softx-gold-admin-script' );
        
    }
}