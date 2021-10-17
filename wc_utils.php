<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once __DIR__ .'/bootstrap.php';

$mws_wputil_config = new MwsWpUtilConfig();
$config_settings = $mws_wputil_config->config_values();
if(isset($_POST['mwswp_del_product_with_image'])){
    if ( current_user_can( 'manage_options' ) ) {
        if ( check_admin_referer( 'mwswp_del_product_image' ) ) {
            $mws_wputil_config->config['del_product_with_image'] = mws_sanitize_items($_POST['mwswp_del_product_with_image']);
            $mws_wputil_config->saveReload();
            $config_settings = $mws_wputil_config->config_values();
        }
} else {
  echo "You dont have sufficient privilege to perform this action!";
} // current_user_can method END
}

// _d($config_settings,'$config_settings');

$mwswpDelProductWithImageOn = '';
$mwswpDelProductWithImageOff = '';
if($mws_wputil_config->config['del_product_with_image'] === 'on'){
  $mwswpDelProductWithImageOn = ' checked';
} else if($mws_wputil_config->config['del_product_with_image'] === 'off'){
  $mwswpDelProductWithImageOff = ' checked';
}




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

if(isset($_POST['delete_wc_product_cats'])){
    if ( current_user_can( 'manage_options' ) ) {
        if ( check_admin_referer( 'mws_wc_delproductcats' ) ) {
            global $wpdb;
            $sql = "DELETE a,c FROM ".$wpdb->prefix."terms AS a
            LEFT JOIN ".$wpdb->prefix."term_taxonomy AS c ON a.term_id = c.term_id
            LEFT JOIN ".$wpdb->prefix."term_relationships AS b ON b.term_taxonomy_id = c.term_taxonomy_id
            WHERE c.taxonomy = 'product_cat'";
            try{
                $wpdb->query($sql);
                echo "<br /><h3>Success! All product categories removed!</h3>";
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    } else {
    echo "You dont have sufficient privilege to perform this action!";
    } // current_user_can method END
}

if(isset($_POST['delete_wc_product_tags'])){
    if ( current_user_can( 'manage_options' ) ) {
        if ( check_admin_referer( 'mws_wc_delproduct_tags' ) ) {
            global $wpdb;
            $sql = "DELETE a,c FROM ".$wpdb->prefix."terms AS a 
            LEFT JOIN ".$wpdb->prefix."term_taxonomy AS c ON a.term_id = c.term_id
            LEFT JOIN ".$wpdb->prefix."term_relationships AS b ON b.term_taxonomy_id = c.term_taxonomy_id
            WHERE c.taxonomy = 'product_tag'";
            try{
                $wpdb->query($sql);
                echo "<br /><h3>Success! All product categories removed!</h3>";
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

    <div class="wc-action">
        <?php
        if ( current_user_can( 'manage_options' ) ) {
        ?>
            <form method="post" action="">Delete image(s)  when delete product?:
                <input type="radio" id="mwswp_del_product_image_on" name="mwswp_del_product_with_image" value="on"<?=$mwswpDelProductWithImageOn?> />
                    <label for="mwswp_del_product_image_on">On</label> &nbsp; | &nbsp;
                    <input type="radio" id="mwswp_del_product_image_off" name="mwswp_del_product_with_image" value="off"<?=$mwswpDelProductWithImageOff?> />
                    <label for="mwswp_del_product_image_off">Off</label><br>
                    <?php wp_nonce_field( 'mwswp_del_product_image');?>
                <?php  submit_button(); ?>
    <!--            <p>-->
    <!--                <input type="submit" name="submit" id="submit" class="button button-primary" value="Delete Products">-->
    <!--            </p>-->
            </form>
            <?php
        }
        ?>
    </div>

    <h2>Tasks:</h2>
    <div class="wc-action">
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
    <div class="wc-action">
    <?php
    if ( current_user_can( 'manage_options' ) ) {
    ?>
        <form method="post" action="" onsubmit="return confirm('Do you really want to DELETE all Woocommerce Product Categories?');">
                Delete All woocommerce product categories &nbsp; <input type="hidden" name="delete_wc_product_cats" />
                <?php wp_nonce_field( 'mws_wc_delproductcats');?>
            <?php  submit_button('Delete Categories'); ?>
        </form>
        <?php
    }
    ?>
    </div>
    <div class="wc-action">
    <?php
    if ( current_user_can( 'manage_options' ) ) {
    ?>
        <form method="post" action="" onsubmit="return confirm('Do you really want to DELETE all Woocommerce Product Tags?');">
                Delete All woocommerce product tags &nbsp; <input type="hidden" name="delete_wc_product_tags" />
                <?php wp_nonce_field( 'mws_wc_delproduct_tags');?>
            <?php  submit_button('Delete Products Tags'); ?>
        </form>
        <?php
    }
    ?>
    </div>
</div>
