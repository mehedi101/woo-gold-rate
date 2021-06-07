<?php
namespace Softx\Gold;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     */
    function __construct() {
        $goldPriceList = new Admin\Goldpricebook();

        $this->dispatch_actions( $goldPriceList );

        new Admin\Menu( $goldPriceList );
        new Product\Softx_Product_Meta_Box(); 
    }
    
    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions( $goldPriceList ) {
        add_action( 'admin_init', [ $goldPriceList, 'form_handler' ] );
        add_action( 'admin_post_wd-ac-delete-address', [ $goldPriceList, 'delete_address' ] );
    }
}