<div class="wrap">
    <h1><?php _e( 'New Price', 'gold-price' ); ?></h1>
    
    <form action="" method="post">
        <table class="form-table">
        <tbody>
                <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="name"><?php _e( 'Carat Name', 'gold-price' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" value="">

                        <?php if ( $this->has_error( 'name' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error( 'name' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
                
                <tr class="row<?php echo $this->has_error( 'price' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="price"><?php _e( 'Carat price', 'gold-price' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="price" id="price" class="regular-text" value="">

                        <?php if ( $this->has_error( 'price' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error( 'price' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field( 'new-price' ); ?>
        <?php submit_button( __( 'Add Price', 'gold-price' ), 'primary', 'submit_price' ); ?>
    </form>
</div>