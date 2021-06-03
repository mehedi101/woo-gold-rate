<?php
global $wpdb;
$retrieve_data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}gold_price " );
//print_r($retrieve_data);
?>
<h1>price list page</h1>

<div class="price-table">
    

    <table style="background-color: #7f8fe8; color:#ffffff; max-width: 300px; font-size: 20px; line-height: 2em; width: 100%;">
        <thead style="background-color:#001fd1">
            <tr style=""><th style="text-align: left; padding-left: 10px;">Carat name</th><th style="text-align: right; padding-right: 10px;">Price per gram</th></tr>
        </thead>
        <tbody style="padding-left: 10px;">
        <?php foreach ($retrieve_data as $retrieved_data){ ?>
            <tr style="">
                <td style=" padding-left: 10px;"><?php echo esc_attr( $retrieved_data->name ); ?></td> 
                <td style="text-align: right; padding-right: 10px; "><?php echo esc_attr( $retrieved_data->price ); ?></td>
            </tr>
        <?php } ?>
        </tbody>


    </table>

</div>

