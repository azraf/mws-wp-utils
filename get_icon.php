<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!function_exists('mws_wp_head_set_icon')){
function mws_wp_head_set_icon(){ ?>
    <!-- Custom Favicon my MWS WP Utils / create-favicon.com -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo home_url( 'favicon.ico', 'relative' );?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo home_url( 'apple-touch-icon.png', 'relative' );?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo home_url( 'apple-touch-icon.png', 'relative' );?>" />
    <link rel="icon" type="image/png" sizes="64x64" href="<?php echo home_url( 'favicon-64x64.png', 'relative' );?>" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo home_url( 'favicon-32x32.png', 'relative' );?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo home_url( 'favicon-16x16.png', 'relative' );?>" />
    <link rel="manifest" href="<?php echo home_url( 'site.webmanifest', 'relative' );?>" />
<?php }
}
add_action('wp_head','mws_wp_head_set_icon');

?>
