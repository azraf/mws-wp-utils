<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Plugin Name: MWS WP Utilities
 * Plugin URI: http://makewebsmart.com/wc-utils
 * Description: Some utilities for Wordpress and Woocommerce
 * Version: 1.1
 * Author: Azraf
 * Author URI: http://azraf.me
 */

add_action( 'init', 'mws_wp_utilities_init');
add_action('admin_menu', 'mws_wp_utilities_menu');


//add_action('wp_head','hook_javascript', -1000);

/**
 *  Check if Custom Favicon is set
 */
function mws_wp_utilities_init()
{
    include_once dirname(__FILE__) . '/Config.php';
    $json_config = mws_wputil_get_config();

    // _d($json_config,'$json_a');
    // _d('Tessting');

    if ( $json_config['set_favicon'] == 'on'){
      include_once dirname(__FILE__) . '/get_icon.php';
    }

    if (( $json_config['google_htmltag_option'] == 'on') 
        || ( $json_config['google_analytics_option'] == 'on')
        || ( $json_config['google_adsense_option'] == 'on')
      ){
      require_once dirname(__FILE__) . '/get_google_head_code.php';
    }
}

function mws_wp_utilities_menu()
{
  if ( empty ( $GLOBALS['admin_page_hooks']['mws_wp_util'] ) ){
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
      'mws_wp_util',
      'mws_wp_util_page'
    );
  }
    add_submenu_page('mws_wp_util', 'Copy Remote File', 'Copy Remote File',
        'manage_options', 'mws_wp_copy_url', 'mws_wp_copy_url_callback');
    add_submenu_page('mws_wp_util', 'Set Favicon', 'Set Favicon',
        'manage_options', 'mws_wp_set_icon', 'mws_wp_set_icon_callback');
    add_submenu_page('mws_wp_util', 'Google HTML Verify', 'Google Accounts',
        'manage_options', 'mws_wp_google_htmltag', 'mws_wp_google_htmltag_callback');
    add_submenu_page('mws_wp_util', 'WooCommerce Utilities', 'WooCommerce Utilities',
        'manage_options', 'mws_wp_wc_utils', 'mws_wp_wc_utils_callback');
    add_submenu_page('mws_wp_util', 'PHP info', 'PHP info',
        'manage_options', 'mws_wp_phpinfo', 'mws_wp_phpinfo_callback');
}

if(!function_exists('mws_wc_util_page')){
  function mws_wp_util_page()
  {
//    echo "Hi mws_wp_util_page !!!!!";
      include_once dirname(__FILE__) . '/wp_utils.php';
  }
}

function mws_wp_copy_url_callback()
{
  include_once dirname(__FILE__) . '/copy.php';
}

function mws_wp_set_icon_callback()
{
  include_once dirname(__FILE__) . '/set_icon.php';
}

function mws_wp_google_htmltag_callback()
{
  include_once dirname(__FILE__) . '/google_htmltag.php';
}

function mws_wp_wc_utils_callback()
{
  include_once dirname(__FILE__) . '/wc_utils.php';
}

function mws_wp_phpinfo_callback()
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


if(!function_exists('mws_sanitize_items')){
  function mws_sanitize_items($var,$intArr=[],$delItems=[])
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