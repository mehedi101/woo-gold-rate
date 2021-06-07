<?php
/**
 * Insert a new address
 *
 * @param  array  $args
 *
 * @return int|WP_Error
 */
 function gp_insert_price( $args = [] ) {
    global $wpdb;

    if ( empty( $args['name'] ) ) {
        return new \WP_Error( 'no-name', __( 'You must provide a Carat name.', 'gold-price' ) );
    }

    $defaults = [
        'name'       => '',
        'price'      => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );
    
    if ( isset( $data['id'] ) ) {
        $id = trim( esc_attr( $data['id'] ));
        $carat_price = trim(esc_attr( $data['price'] )) ;
        $carat_name = trim( sanitize_text_field( $data['name']));
        //print_r($price);
        unset( $data['id'] );
        
        $updated = $wpdb->update(
            $wpdb->prefix . 'gold_price',
            $data,
            [ 'id' => $id ],
            [
                '%s',
                '%d',
                '%d',
                '%s'
            ],
            [ '%d' ]
        );

        //return $updated;
        //global $wpdb;
        $argsitem = array(
            'post_type'   =>['product'],
            'fields' => 'ids',
            'posts_per_page' => -1,
            'post_status'   => array( 'publish' ),
            'meta_query' =>[
                'relation' => 'AND',
                [
                    'key' => 'softx_assign_carat_name',
                    'value' => $carat_name,
                    'compare' => '='
                ]
            ]

                    
        );

        $product_ids = new WP_Query( $argsitem );
        // echo "product_query: {$product_ids->request}";

        // exit;
         //echo "Last SQL-Query: {$query->request}";
         //$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='assign_carat_name' AND meta_value='%s'", $carat_name, $carat_price ) );
        //echo $product_id;

        /*if($updated){
            update_user_meta( $pid, 'assign_carat_price', $carat_price );

        }*/

        
        
       
          
        
              
        for ($i = 0; $i < count($product_ids->posts); $i++) {
            $pid = $product_ids->posts[$i];
            change_and_save_product_price($carat_price, $pid);

            
            }
        return $update;
    
            

    }else {

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'gold_price',
            $data,
            [
                '%s',
                '%d',
                '%d',
                '%s'
            ]
        );
    
        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'gold-price' ) );
        }
        
       

        return $wpdb->insert_id;
    }
}
    
/**
 * update all the regular price of the productes
 * under a certain gold carat
 * when update rate.
 *
 * @param int $carat_price
 * @param int $productID
 * @return void
 */
function change_and_save_product_price(  $carat_price, $productID  ) {
            
    // Get product
    $product = wc_get_product($productID);

    $regular_price =   $carat_price * $product->weight;

    // Set regular price
    $product->set_regular_price(  round( $regular_price ,3) );
    
    
    // Save to database (Note: You might want to clear cache of your page and then reload, if it still doesn't show up go to the product page and check there.)
    $product->save();
    //softx_assign_carat_price

    update_post_meta(
        $productID,
        'softx_assign_carat_price',
        $carat_price
    );

    return;

}

/**
 * Fetch prices
 *
 * @param  array  $args
 *
 * @return array
 */
function wd_ac_get_addresses( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC'
    ];

    $args = wp_parse_args( $args, $defaults );

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}gold_price
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
    );

    $items = $wpdb->get_results( $sql );

    return $items;
}
  
/**
 * Get the count of total address
 *
 * @return int
 */
function wd_ac_address_count() {
    global $wpdb;

    return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}gold_price" );
}

/**
 * Fetch a single contact from the DB
 *
 * @param  int $id
 *
 * @return object
 */
function wd_ac_get_address( $id ) {
    global $wpdb;

    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}gold_price WHERE id = %d", $id )
    );
}

/**
 * Delete an price
 *
 * @param  int $id
 *
 * @return int|boolean
 */
function gp_delete_price( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'gold_price',
        [ 'id' => $id ],
        [ '%d' ]
    );
}

/**
 * 
 * AUTHOR
 * 
 */
/*=== Author meta box for company  ===*/
/* abstract class Carat_Meta_Box {
    
} 
add_action( 'add_meta_boxes', [ 'Carat_Meta_Box', 'add' ] );
add_action( 'save_post', [ 'Carat_Meta_Box', 'softx_meta_save' ] ); */

  /**
     * Enqueue scripts and styles
     * for woocommerce product edit screen only
     * @return void
     */

add_action( 'admin_footer', 'softx_enqueue_assets' );

function softx_enqueue_assets() {
    wp_enqueue_style( 'price-admin-style' );
    $screen       = get_current_screen();
	$screen_id    = $screen ? $screen->id : '';
    if ( in_array( $screen_id, wc_get_screen_ids() ) ) {
    wp_enqueue_script( 'softx-gold-admin-script' );
    }
    
}


function softx_defer_scripts( $tag, $handle, $src ) {
    $defer = array( 
      'softx-gold-admin-script'
    );
  
    if ( in_array( $handle, $defer ) ) {
       return '<script id="'.$handle.'"  src="' . $src . '" defer ></script>' . "\n";
    }
      
      return $tag;
  } 
  
  add_filter( 'script_loader_tag', 'softx_defer_scripts', 10, 3 );