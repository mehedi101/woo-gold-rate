<?php
/**
 * Plugin Name:       SoftX Gold Price
 * Plugin URI:        http://raselahsan.com/plugins/gold-price-list
 * Description:       Gold price management system plugin.
 * Version:           1.0
 * Requires at least: 5.7
 * Requires PHP:      7.3
 * Author:            Mehedi Hasan
 * Author URI:        http://mehedihasn.com/
 * License:           GPL2 
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       softx-gold-price
 * Domain Path:       /languages
 */

 //Don't call file directry.
 if ( !defined( 'ABSPATH' ) ) exit;

 require_once __DIR__ . '/vendor/autoload.php';

 /*******
  * final class
  ***********/
  final class Softx_Gold_Price {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * class constructor
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    } 

    /**
     * inisilizes a singlaton instance
     * 
     * @return \SoftX_Gold_Price
     */
    public static function init() {
        static $instace = false;

        if ( ! $instace ) {
            $instace = new self();
        }
        return $instace;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'SF_GOLDPRICE_VERSION', self::version );
        define( 'SF_GOLDPRICE_FILE', __FILE__ );
        define( 'SF_GOLDPRICE_PATH', __DIR__ );
        define( 'SF_GOLDPRICE_URL', plugins_url( '', SF_GOLDPRICE_FILE ) );
        define( 'SF_GOLDPRICE_ASSETS', SF_GOLDPRICE_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        new Softx\Gold\Assets();
        if ( is_admin() ) {
            new Softx\Gold\Admin();
        } else {
            new Softx\Gold\Frontend();
        }
        new Softx\Gold\API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Softx\Gold\Installer();
        $installer->run();
    }
  }

  /**
 * Initializes the main plugin
 *
 * @return \Gold_Price
 */
function softx_gold_price() {
    return Softx_Gold_Price::init();
}

// kick-off the plugin
softx_gold_price();