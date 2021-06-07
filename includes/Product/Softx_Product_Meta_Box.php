<?php
namespace Softx\Gold\Product;

class Softx_Product_Meta_Box{

    public function __construct( )
    {
        add_action( 'add_meta_boxes', [ $this, 'add' ] );
        add_action( 'save_post', [ $this, 'softx_meta_save' ] );
    }
	
    // Set up and add the meta box.
    public  function add() {
        $screens = [ 'product', 'authormeta_cpt' ];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'author_metabox_id',          // Unique ID
                'Assign to the Caret name & price', // Box title
                [ $this, 'html' ],   // Content callback, must be of type callable
                $screen                  // Post type
            );
        }
    }
    // Display the meta box HTML to the user.     
    public function html( $post ) {
        $value = get_post_meta( $post->ID, 'softx_assign_carat_name', true ); 
        $name_price = get_post_meta( $post->ID, 'softx_assign_carat_price', true );         
        global $wpdb;  
        $companymetausers = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}gold_price " );
        //print_r ($companymetausers);
        
        ?>
        
        <label for="caratname_field"><?php _e( "Choose your Caret Name", "softx-gold-price" ); ?></label>
        <select name="caratname_field" id="caratname_field" class="postbox">

            <option value=""> <?php _e("Select Your Caret Name", "softx-gold-price")?> </option> 
            <?php foreach ( $companymetausers as $user ) { 
            
                ?>                
             
                <option <?php selected($name_price, $user->price); ?>  value="<?php echo $user->price; ?>" > <?php echo '<span>' . esc_html( $user->name ) . '</span>'; ?> </option>          
   
              <?php  } ?>
              
        </select>
        <input type="hidden" name="assign_carat_name"  id="assign_carat_name" value=""/>
        
        
        <?php
    }
    // Save the meta box selections.     
    public function softx_meta_save( int $post_id ) {
        if ( array_key_exists( 'caratname_field', $_POST ) ) {
            update_post_meta(
                $post_id,
                'softx_assign_carat_price',
                trim($_POST['caratname_field'])
            );
        }

        if ( array_key_exists( 'assign_carat_name', $_POST ) ) {
            update_post_meta(
                $post_id,
                'softx_assign_carat_name',
                trim($_POST['assign_carat_name']) 
            );
        }

        
    }


 }
