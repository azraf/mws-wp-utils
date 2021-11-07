<?php
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once __DIR__ .'/bootstrap.php';

$mwswputil_config = new MwsWpUtilConfig();
$config_settings = $mwswputil_config->config_values();
// _d($config_settings,'$config_settings');

if(isset($_POST['fb_verifymeta_option']) || isset($_POST['fb_verifymeta_content'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mwswp_fb_verifymeta_form' ) ) {
      if(isset($_POST['fb_verifymeta_option'])){
        $mwswputil_config->config['fb_verifymeta_option'] = mwswp_sanitize_items($_POST['fb_verifymeta_option']);
      }
      
      if(isset($_POST['fb_verifymeta_content'])){
        $newID = $_POST['fb_verifymeta_content'];
        if(!empty($newID)){
          $mwswputil_config->config['fb_verifymeta_content'] = mwswp_sanitize_items(trim($newID));
        }
      }
      $mwswputil_config->saveReload();
      $config_settings = $mwswputil_config->config_values();
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } 
}

$fbVerifymetaOptionOn = '';
$fbVerifymetaOptionOff = '';
if($mwswputil_config->config['fb_verifymeta_option'] === 'on'){
  $fbVerifymetaOptionOn = ' checked';
} else if($mwswputil_config->config['fb_verifymeta_option'] === 'off'){
  $fbVerifymetaOptionOff = ' checked';
}

$fb_verifymeta_content 
          = !empty($mwswputil_config->config['fb_verifymeta_content']) 
          ? $mwswputil_config->config['fb_verifymeta_content'] 
          : 'Redirect url';

?>
<style>
    .mwswp-utils form input[type=text]{
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
    }
    .set-width {
       min-width: 350px;
    }
</style>

<div class="wrap">

<div class="container">
<table class="wp-list-table widefat striped">
    <thead>
      <tr>
      <td colspan="2">Facebook Domain Verify:</td>
      </tr>
    </thead>
    <tbody>
    <form class="mwswp-utils" method="post">
      <tr>
          <td width="25%">Verification Meta Content:</td>
          <td width="70%">
            <input type="text" id="tagContent" name="fb_verifymeta_content" class="set-width" placeholder="<?=$fb_verifymeta_content;?>" />
          </td>
        </tr>
        <tr>
          <td width="25%">Meta String Enable</td>
          <td>
          <div>
            <input type="radio" id="fbVerifymetaOptionOn" name="fb_verifymeta_option" value="on"<?=$fbVerifymetaOptionOn?> />
            <label for="fbVerifymetaOptionOn">Enable</label>
          </div>

          <div>
            <input type="radio" id="fbVerifymetaOptionOff" name="fb_verifymeta_option" value="off"<?=$fbVerifymetaOptionOff?> />
            <label for="fbVerifymetaOptionOff">Disable</label>
          </div>
          </td>
        </tr>
        <?php wp_nonce_field( 'mwswp_fb_verifymeta_form');?>
        <tr>
            <td width="25%">
              <input id="reset_upload_form" class="" type="reset" value="Reset form" />
            </td>
            <td><button id="newsubmit" name="newsubmit" type="submit">Save</button></td>
        </tr>
        </form>
    </tbody>  
  </table>
</div>
<br />
<br />
<br />
  </div>