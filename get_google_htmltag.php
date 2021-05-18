<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!function_exists('mws_wphead_set_googlehtmltag')){
  function mws_wphead_set_googlehtmltag(){ 
    include_once dirname(__FILE__) . '/Config.php';
    $json_config = mws_wputil_get_config();
  ?>
    <meta name="google-site-verification" content="<?=$json_config['google_htmltag_content']?>">
<?php }
}
add_action('wp_head','mws_wphead_set_googlehtmltag');

?>
