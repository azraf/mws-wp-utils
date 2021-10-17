<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'before_delete_post', function( $id ) {
    $product = wc_get_product( $id );
    if ( ! $product ) {
        return;
    }
    $all_product_ids         = [];
    $product_thum_id_holder  = [];
    $gallery_image_id_holder = [];
    $thum_id                 = get_post_thumbnail_id( $product->get_id() );
    if ( function_exists( 'dokan' ) ) {
        $vendor = dokan()->vendor->get( dokan_get_current_user_id() );
        if ( ! $vendor instanceof WeDevs\Dokan\Vendor\Vendor || $vendor->get_id() === 0 ) {
            return;
        }
        $products = $vendor->get_products();
        if ( empty( $products->posts ) ) {
            return;
        }
        foreach ( $products->posts as $post ) {
            array_push( $all_product_ids, $post->ID );
        }
    } else {
        $args     = [ 'posts_per_page' => '-1' ];
        $products = wc_get_products( $args );
        foreach ( $products as $product ) {
            array_push( $all_product_ids, $product->get_id() );
        }
    }
    foreach ( $all_product_ids as $product_id ) {
        if ( intval( $product_id ) !== intval( $id ) ) {
            array_push( $product_thum_id_holder, get_post_thumbnail_id( $product_id ) );
            $wc_product        = wc_get_product( $product_id );
            $gallery_image_ids = $wc_product->get_gallery_image_ids();
            if ( empty( $gallery_image_ids ) ) {
                continue;
            }
            foreach ( $gallery_image_ids as $gallery_image_id ) {
                array_push( $gallery_image_id_holder, $gallery_image_id );
            }
        }
    }
    if ( ! in_array( $thum_id, $product_thum_id_holder ) && ! in_array( $thum_id, $gallery_image_id_holder ) ) {
        wp_delete_attachment( $thum_id, true );
        if ( empty( $thum_id ) ) {
            return;
        }
        $gallery_image_ids = $product->get_gallery_image_ids();
        if ( empty( $gallery_image_ids ) ) {
            return;
        }
        foreach ( $gallery_image_ids as $gallery_image_id ) {
            wp_delete_attachment( $gallery_image_id, true );
        }
    }
} );




// // Automatically Delete Woocommerce Images After Deleting a Product
// add_action( 'before_delete_post', 'delete_product_images', 10, 1 );

// function delete_product_images( $post_id )
// {
//     $product = wc_get_product( $post_id );

//     if ( !$product ) {
//         return;
//     }

//     $featured_image_id = $product->get_image_id();
//     $image_galleries_id = $product->get_gallery_image_ids();

//     if( !empty( $featured_image_id ) ) {
//         wp_delete_post( $featured_image_id );
//     }

//     if( !empty( $image_galleries_id ) ) {
//         foreach( $image_galleries_id as $single_image_id ) {
//             wp_delete_post( $single_image_id );
//         }
//     }
// }

/**
 * 
 *  woocommerce product image auto delete
 * -----------------------------------------------------------------------------
 */

//  add_action('after_delete_post','wdm_delete_post_images',10,1);

// function wdm_delete_post_images($post_id)
// {
//    $featured_image_id = get_post_meta($post_id,'_thumbnail_id',true);

//    $image_galleries_id = get_post_meta($post_id,'_product_image_gallery',true);

//    if(!empty($featured_image_id))
//    {
//      wp_delete_post($featured_image_id);
//    }

//   if(!empty($image_galleries_id))
//   {
//     $image_galleries_array = split(',',$image_galleries_id);

//     foreach($image_galleries_array as $single_image_id)
//     {
//         wp_delete_post($single_image_id);
//     }
//   }
// }


?>
