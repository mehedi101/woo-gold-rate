<?php
namespace Softx\Gold\Frontend;


/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'price-list', [ $this, 'render_shortcode' ] );
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_shortcode( $atts, $content = '' ) {
       
        wp_enqueue_script( 'price-script' );
        wp_enqueue_style( 'price-style' );
       
        ob_start();
        include __DIR__ . '/views/gold-price-list.php';
        return ob_get_clean();
    }
}