<?php
namespace Softx\Gold\Admin;
use Softx\Gold\Traits\Form_Error;
/**
 * Goldpricebook Handler class
 */
class Goldpricebook {

    use Form_Error;

    /**
     * Plugin page handler
     *
     * @return void
     */

    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/price-new.php';
                break;

            case 'edit':
                $address  = wd_ac_get_address( $id );
                $template = __DIR__ . '/views/price-edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/price-view.php';
                break;

            default:
                $template = __DIR__ . '/views/price-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
    /**
     * Handle the form
     *
     * @return void
     */
    public function form_handler() {
        if ( ! isset( $_POST['submit_price'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-price' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $id      = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
        $name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $price   = isset( $_POST['price'] ) ? sanitize_text_field( $_POST['price'] ) : '';

        if ( empty( $name ) ) {
            $this->errors['name'] = __( 'Please provide a Gold carat name', 'gold-price' );
        }

        if ( empty( $price ) ) {
            $this->errors['price'] = __( 'Please provide a price.', 'gold-price' );
        }

        if ( ! empty( $this->errors ) ) {
            return;
        }

        $args = [
            'name'    => $name,
            'price'   => $price
        ];

        if ( $id ) {
            $args['id'] = $id;
        }

        $insert_id = gp_insert_price( $args );
        //var_dump($insert_id);
        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        if ( $id ) {
            $redirected_to = admin_url( 'admin.php?page=gold-price&action=edit&price-updated=true&id=' . $id );
        } else {
            $redirected_to = admin_url( 'admin.php?page=gold-price&inserted=true' );
        }

        wp_redirect( $redirected_to );
        exit;
    }

    public function delete_price() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'gp-delete-price' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

        if ( gp_delete_price( $id ) ) {
            $redirected_to = admin_url( 'admin.php?page=gold-price&price-deleted=true' );
        } else {
            $redirected_to = admin_url( 'admin.php?page=gold-price&price-deleted=false' );
        }

        wp_redirect( $redirected_to );
        exit;
    }
}