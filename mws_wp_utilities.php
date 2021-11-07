<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Plugin Name: MWS WP Utilities
 * Plugin URI: http://makewebsmart.com/wc-utils
 * Description: Some utilities for Wordpress and Woocommerce
 * Version: 1.2
 * Author: Azraf
 * Author URI: http://azraf.me
 */

add_action( 'init', 'mwswp_utilities_init');
add_action('admin_menu', 'mwswp_utilities_menu');


//add_action('wp_head','hook_javascript', -1000);


/**
 *  Check if Custom Favicon is set
 */
function mwswp_utilities_init()
{
    include_once dirname(__FILE__) . '/Config.php';
    $json_config = mwswputil_get_config();

    $mobile_redirect_url = trim($json_config['mobile_redirect_url']);
    if (($json_config['mobile_redirect_option'] == 'on') && !empty($mobile_redirect_url)){
      if ( wp_is_mobile() ) {
        header ('Location: '.$mobile_redirect_url );
        exit;
      }
    }

    $mobile_theme_select = trim($json_config['mwswp_mob_theme_select']);
    if (($json_config['mobile_theme_switch'] == 'on') && !empty($mobile_theme_select)){

      if(wp_is_mobile()){
        add_filter( 'stylesheet', $mobile_theme_select);
        add_filter( 'template', $mobile_theme_select);
    }
    
    }

    if ( $json_config['set_favicon'] == 'on'){
      include_once dirname(__FILE__) . '/get_icon.php';
    }

    if ( $json_config['del_product_with_image'] == 'on'){
      include_once dirname(__FILE__) . '/get_wc_del_product_img.php';
    }

    if (( $json_config['google_htmltag_option'] == 'on') 
        || ( $json_config['google_analytics_option'] == 'on')
        || ( $json_config['google_adsense_option'] == 'on')
      ){
      require_once dirname(__FILE__) . '/get_google_head_code.php';
    }

    if ( $json_config['fb_verifymeta_option'] == 'on') {
      require_once dirname(__FILE__) . '/get_fb_head_code.php';
    }
}


function mwswp_utilities_menu()
{
  if ( empty ( $GLOBALS['admin_page_hooks']['mwswp_util'] ) ){
    // add_menu_page(
    //   'Page Title',
    //   'Top Menu Title',
    //   'manage_options',
    //   'my_unique_slug',
    //   'my_magic_function'
    // );
    add_menu_page(
      'MWS WP Utilities',
      'MWS WP Utilities',
      'manage_options',
      'mwswp_util',
      'mwswp_util_page'
    );
  }
    add_submenu_page('mwswp_util', 'Copy Remote File', 'Copy Remote File',
        'manage_options', 'mwswp_copy_url', 'mwswp_copy_url_callback');
    add_submenu_page('mwswp_util', 'Set Favicon', 'Set Favicon',
        'manage_options', 'mwswp_set_icon', 'mwswp_set_icon_callback');
    add_submenu_page('mwswp_util', 'Google HTML Verify', 'Google Accounts',
        'manage_options', 'mwswp_google_htmltag', 'mwswp_google_htmltag_callback');
    add_submenu_page('mwswp_util', 'Facebook Utilities', 'Facebook Utilities',
        'manage_options', 'mwswp_fb_metatag', 'mwswp_fb_metatag_callback');
    add_submenu_page('mwswp_util', 'WooCommerce Utilities', 'WooCommerce Utilities',
        'manage_options', 'mwswp_wc_utils', 'mwswp_wc_utils_callback');
    add_submenu_page('mwswp_util', 'Mobile Options', 'Mobile Options',
        'manage_options', 'mwswp_mobile_options', 'mwswp_mobile_options_callback');
    add_submenu_page('mwswp_util', 'PHP info', 'PHP info',
        'manage_options', 'mwswp_phpinfo', 'mwswp_phpinfo_callback');
}

if(!function_exists('mwswp_wc_util_page')){
  function mwswp_util_page()
  {
//    echo "Hi mwswp_util_page !!!!!";
      include_once dirname(__FILE__) . '/wp_utils.php';
  }
}

function mwswp_copy_url_callback()
{
  include_once dirname(__FILE__) . '/copy.php';
}

function mwswp_set_icon_callback()
{
  include_once dirname(__FILE__) . '/set_icon.php';
}

function mwswp_google_htmltag_callback()
{
  include_once dirname(__FILE__) . '/google_htmltag.php';
}

function mwswp_fb_metatag_callback()
{
  include_once dirname(__FILE__) . '/fb_verify_meta.php';
}

function mwswp_wc_utils_callback()
{
  include_once dirname(__FILE__) . '/wc_utils.php';
}

function mwswp_mobile_options_callback()
{
  include_once dirname(__FILE__) . '/mobile_options.php';
}

function mwswp_phpinfo_callback()
{
    include_once dirname(__FILE__) . '/phpinfo.php';
}
if(!function_exists('_d')){
    function _d($var,$str=false,$e=false)
    {
        if($str){
            echo '<br />' . $str;
        }
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        if($e){
            exit(' --- '. $e .' ---');
        }
    }
}


if(!function_exists('mwswp_sanitize_items')){
  function mwswp_sanitize_items($var,$intArr=[],$delItems=[])
  {
      if(is_array ($var)){
          $ret = [];
          // if exist _wpnonce, omit from return array
          if(isset($var['_wpnonce'])){
              unset($var['_wpnonce']);
          }
          // if exist _wp_http_referer,  omit it from return array
          if(isset($var['_wp_http_referer'])){
              unset($var['_wp_http_referer']);
          }
          if(!empty($delItems)){
              foreach($delItems as $del) {
                  unset($var[$del]);
              }
          }
          foreach($var as $k=>$v){
              if(!empty($intArr) && in_array($k,$intArr)){
                  if(!empty($v)){
                      $ret[$k] = intval($v);
                  } else {
                      $ret[$k] = '';
                  }
              }else {
                  $ret[$k] = sanitize_text_field($v);
              }
          }
          return $ret;
      } else {
          return sanitize_text_field($var);
      }
  }
}

function mwswp_mobile_theme_switch() {
  if(wp_is_mobile()){
  global $mobile_theme_select;
  // https://developer.wordpress.org/reference/functions/switch_theme/
  // https://stackoverflow.com/questions/30796038/how-to-set-the-theme-programatically-in-wordpress      

      return $mobile_theme_select;
  }
}