<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Gold Price', 'gold-price' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=gold-price&action=new' ); ?>" class="page-title-action"><?php _e( 'Add New', 'gold-price' ); ?></a>

    <?php if ( isset( $_GET['inserted'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Price has been added successfully!', 'gold-price' ); ?></p>
        </div>
    <?php } ?>

    <?php if ( isset( $_GET['price-deleted'] ) && $_GET['price-deleted'] == 'true' ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Price has been deleted successfully!', 'gold-price' ); ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <?php
        $table = new Softx\Gold\Admin\Price_List();
        $table->prepare_items();
        $table->search_box( 'search', 'search_id' );
        $table->display();
        ?>
    </form>
</div>