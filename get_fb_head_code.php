<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function mwswp_fb_get_headcode(){ 

include_once dirname(__FILE__) . '/Config.php';
  $json_config = mwswputil_get_config();

  if ( $json_config['fb_verifymeta_option'] == 'on'){
    ?>
    <meta name="facebook-domain-verification" content="<?php echo $json_config['fb_verifymeta_content'];?>" />
    <?php
  }
}
add_action('wp_head','mwswp_fb_get_headcode');
?>
