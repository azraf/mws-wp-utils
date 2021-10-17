<?php
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once __DIR__ .'/bootstrap.php';

$mws_wputil_config = new MwsWpUtilConfig();
$config_settings = $mws_wputil_config->config_values();
// _d($config_settings,'$config_settings');

if(isset($_POST['mobile_redirect_option']) || isset($_POST['mobile_redirect_url'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mwswp_mobile_options' ) ) {
      if(isset($_POST['mobile_redirect_option'])){
        $mws_wputil_config->config['mobile_redirect_option'] = mws_sanitize_items($_POST['mobile_redirect_option']);
      }
      
      if(isset($_POST['mobile_redirect_url'])){
        $newID = $_POST['mobile_redirect_url'];
        if(!empty($newID)){
          $mws_wputil_config->config['mobile_redirect_url'] = mws_sanitize_items(trim($newID));
        }
      }
      $mws_wputil_config->saveReload();
      $config_settings = $mws_wputil_config->config_values();
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } 
}

$mobileRedirectOn = '';
$mobileRedirectOff = '';
if($mws_wputil_config->config['mobile_redirect_option'] === 'on'){
  $mobileRedirectOn = ' checked';
} else if($mws_wputil_config->config['mobile_redirect_option'] === 'off'){
  $mobileRedirectOff = ' checked';
}

$mobile_redirect_url 
          = !empty($mws_wputil_config->config['mobile_redirect_url']) 
          ? $mws_wputil_config->config['mobile_redirect_url'] 
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
      <td colspan="2">Redirect url for mobile:</td>
      </tr>
    </thead>
    <tbody>
    <form class="mwswp-utils" method="post">
      <tr>
          <td width="25%">URL for mobile</td>
          <td width="70%">
            <input type="text" id="tagContent" name="mobile_redirect_url" class="set-width" placeholder="<?=$mobile_redirect_url;?>" />
          </td>
        </tr>
        <tr>
          <td width="25%">Mobile Redirect</td>
          <td>
          <div>
            <input type="radio" id="mobileRedirectOn" name="mobile_redirect_option" value="on"<?=$mobileRedirectOn?> />
            <label for="mobileRedirectOn">Enable</label>
          </div>

          <div>
            <input type="radio" id="mobileRedirectOff" name="mobile_redirect_option" value="off"<?=$mobileRedirectOff?> />
            <label for="mobileRedirectOff">Disable</label>
          </div>
          </td>
        </tr>
        <?php wp_nonce_field( 'mwswp_mobile_options');?>
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