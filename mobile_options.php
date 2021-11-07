<?php
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once __DIR__ .'/bootstrap.php';

$themes = wp_get_themes();
$mwswputil_config = new MwsWpUtilConfig();
$config_settings = $mwswputil_config->config_values();
// _d($config_settings,'$config_settings');

// Mobile theme switch form submit
if(isset($_POST['mwswp_mob_theme_select']) || isset($_POST['mwswp_mob_theme_switch'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mwswp_mob_theme_switch' ) ) {
      if(isset($_POST['mwswp_mob_theme_switch'])){
        $mwswputil_config->config['mobile_theme_switch'] = mwswp_sanitize_items($_POST['mwswp_mob_theme_switch']);
      }
      
      if(isset($_POST['mwswp_mob_theme_select'])){
        $newID = $_POST['mwswp_mob_theme_select'];
        if(!empty($newID)){
          $mwswputil_config->config['mobile_theme_select'] = mwswp_sanitize_items(trim($newID));
        }
      }
      $mwswputil_config->saveReload();
      $config_settings = $mwswputil_config->config_values();
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } 
}
$mobThemeSwitchOn = '';
$mobThemeSwitchOff = '';
if($mwswputil_config->config['mobile_theme_switch'] === 'on'){
  $mobThemeSwitchOn = ' checked';
} else if($mwswputil_config->config['mobile_theme_switch'] === 'off'){
  $mobThemeSwitchOff = ' checked';
}

$mobile_theme_select 
          = !empty($mwswputil_config->config['mobile_theme_select']) 
          ? $mwswputil_config->config['mobile_theme_select'] 
          : '';




// Mobile redirect form submit
if(isset($_POST['mobile_redirect_option']) || isset($_POST['mobile_redirect_url'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mwswp_mobile_options' ) ) {
      if(isset($_POST['mobile_redirect_option'])){
        $mwswputil_config->config['mobile_redirect_option'] = mwswp_sanitize_items($_POST['mobile_redirect_option']);
      }
      
      if(isset($_POST['mobile_redirect_url'])){
        $newID = $_POST['mobile_redirect_url'];
        if(!empty($newID)){
          $mwswputil_config->config['mobile_redirect_url'] = mwswp_sanitize_items(trim($newID));
        }
      }
      $mwswputil_config->saveReload();
      $config_settings = $mwswputil_config->config_values();
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } 
}

$mobileRedirectOn = '';
$mobileRedirectOff = '';
if($mwswputil_config->config['mobile_redirect_option'] === 'on'){
  $mobileRedirectOn = ' checked';
} else if($mwswputil_config->config['mobile_redirect_option'] === 'off'){
  $mobileRedirectOff = ' checked';
}

$mobile_redirect_url 
          = !empty($mwswputil_config->config['mobile_redirect_url']) 
          ? $mwswputil_config->config['mobile_redirect_url'] 
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
        <td colspan="2">Wordpress Theme list:</td>
        </tr>
      </thead>
      <tbody>
      <form class="mwswp-utils" method="post">
        <tr>
            <td width="25%">Select theme for mobile:</td>
            <td width="70%">
            <?php
              if(is_array($themes)){
                ?>
                  <select name="mwswp_mob_theme_select" id="mwswp_mob_theme" class="set-width" >
                  <option value=" ">Select a theme</option>
                <?php
                $selected = '';
                foreach($themes as $k=>$v){
                  if(!empty($mobile_theme_select)){
                    if($k == $mobile_theme_select){
                      $selected = ' selected';
                    } else {
                      $selected = '';
                    }
                  }
              ?>
                <option value="<?php echo $k;?>"<?php echo $selected;?>><?php echo $v->Name;?></option>
              <?php
                }
                ?>
                  </select>
                <?php
              }
            ?>
            </td>
          </tr>
          <tr>
            <td width="25%">Theme Switch Enable:</td>
            <td>
            <div>
              <input type="radio" id="mobThemeSwitchOn" name="mwswp_mob_theme_switch" value="on"<?=$mobThemeSwitchOn?> />
              <label for="mobThemeSwitchOn">Enable</label>
            </div>

            <div>
              <input type="radio" id="mobThemeSwitchOff" name="mwswp_mob_theme_switch" value="off"<?=$mobThemeSwitchOff?> />
              <label for="mobThemeSwitchOff">Disable</label>
            </div>
            </td>
          </tr>
          <?php wp_nonce_field( 'mwswp_mob_theme_switch');?>
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