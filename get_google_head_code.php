<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function mws_wphead_set_googleheadcode(){ 

  include_once dirname(__FILE__) . '/Config.php';
  $json_config = mws_wputil_get_config();

  if ( $json_config['google_htmltag_option'] == 'on'){
    ?>
    <meta name="google-site-verification" content="<?=$json_config['google_htmltag_content']?>">
    <?php
  }

  if (($json_config['google_analytics_option'] == 'on') && !empty($json_config['google_analytics_id']) ){
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $json_config['google_analytics_id'];?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo $json_config['google_analytics_id'];?>');
    </script>
  <?php 
  }

  if (($json_config['google_adsense_option'] == 'on') && !empty($json_config['google_adsense_id']) ){
    ?>
    <script data-ad-client="<?php echo $json_config['google_adsense_id'];?>" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <?php 
  }

}

add_action('wp_head','mws_wphead_set_googleheadcode');

?>
