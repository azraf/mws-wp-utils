<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(isset($_POST['delete_wc_products'])){
    if ( current_user_can( 'manage_options' ) ) {
        if ( check_admin_referer( 'mws_wc_delproducts' ) ) {
            global $wpdb;

            $sql_1 = "DELETE FROM ".$wpdb->prefix."term_relationships WHERE object_id IN (SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'product');";
            $sql_2 = "DELETE FROM ".$wpdb->prefix."postmeta WHERE post_id IN (SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'product');";
            $sql_3 = "DELETE FROM ".$wpdb->prefix."posts WHERE post_type = 'product';";

            $sql_4 = "DELETE relations.*, taxes.*, terms.*
        FROM ".$wpdb->prefix."term_relationships AS relations
        INNER JOIN ".$wpdb->prefix."term_taxonomy AS taxes
        ON relations.term_taxonomy_id=taxes.term_taxonomy_id
        INNER JOIN ".$wpdb->prefix."terms AS terms
        ON taxes.term_id=terms.term_id
        WHERE object_id IN (SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type='product');";

            try{

                $wpdb->query($sql_1);
                $wpdb->query($sql_2);
                $wpdb->query($sql_3);
                $wpdb->query($sql_4);

                echo "<br /><h3>Success! All products removed!</h3>";
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    } else {
    echo "You dont have sufficient privilege to perform this action!";
    } // current_user_can method END
}
?>
<div>
    <h2>Tasks:</h2>
    <div class="">
    <?php
    if ( current_user_can( 'manage_options' ) ) {
    ?>
        <form method="post" action="" onsubmit="return confirm('Do you really want to DELETE all Woocommerce Products?');">
                Delete All woocommerce products &nbsp; <input type="hidden" name="delete_wc_products" />
                <?php wp_nonce_field( 'mws_wc_delproducts');?>
            <?php  submit_button('Delete Products'); ?>
        </form>
        <?php
    }
    ?>
    </div>
</div>
