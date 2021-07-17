<?php
namespace Softx\Gold;

/**
 * Assets handlers class
 */
class API {
    
    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_api']);
    }

     /**
     * Register the API
     *
     * @return void
     */
    public function register_api() {
        $goldPriceApi = new APi\GoldPriceApi();
        $goldPriceApi->register_routes();
    }
}