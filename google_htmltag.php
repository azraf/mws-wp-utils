<?php
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once __DIR__ .'/bootstrap.php';

$mwswputil_config = new MwsWpUtilConfig();
$config_settings = $mwswputil_config->config_values();
// _d($config_settings,'$config_settings');

// Google Analytics Tracking Code
if(isset($_POST['showcode']) || isset($_POST['google_analytics_id'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mwswp_google_analytics' ) ) {
      if(isset($_POST['showcode'])){
        $mwswputil_config->config['google_analytics_option'] = mwswp_sanitize_items($_POST['showcode']);
      }
      
      if(isset($_POST['google_analytics_id'])){
        $newID = $_POST['google_analytics_id'];
        if(!empty($newID)){
          $mwswputil_config->config['google_analytics_id'] = mwswp_sanitize_items(trim($newID));
        }
      }
      $mwswputil_config->saveReload();
      $config_settings = $mwswputil_config->config_values();
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } 
}

// Google Webmaster HTML meta tag
if(isset($_POST['showtag']) || isset($_POST['google_htmltag_content'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mwswp_google_htmltag' ) ) {
      if(isset($_POST['showtag'])){
        $mwswputil_config->config['google_htmltag_option'] = mwswp_sanitize_items($_POST['showtag']);
      }
      
      if(isset($_POST['google_htmltag_content'])){
        $newContent = $_POST['google_htmltag_content'];
        if(!empty($newContent)){
          $mwswputil_config->config['google_htmltag_content'] = mwswp_sanitize_items(trim($newContent));
        }
      }
      $mwswputil_config->saveReload();
      $config_settings = $mwswputil_config->config_values();
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } 
}

// Adsense
if(isset($_POST['showads']) || isset($_POST['google_adsense_id'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mwswp_google_adsense' ) ) {
      if(isset($_POST['showads'])){
        $mwswputil_config->config['google_adsense_option'] = mwswp_sanitize_items($_POST['showads']);
      }
      
      if(isset($_POST['google_adsense_id'])){
        $newAdsense = $_POST['google_adsense_id'];
        if(!empty($newAdsense)){
          $mwswputil_config->config['google_adsense_id'] = mwswp_sanitize_items(trim($newAdsense));
        }
      }
      $mwswputil_config->saveReload();
      $config_settings = $mwswputil_config->config_values();
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } 
}
// _d($config_settings,'$config_settings');

// $userSuspended = $member->disabled ? 'checked' : '';
// $userActive = $member->disabled ? '' : 'checked';

$showCodeOn = '';
$showCodeOff = '';
if($mwswputil_config->config['google_analytics_option'] === 'on'){
  $showCodeOn = ' checked';
} else if($mwswputil_config->config['google_analytics_option'] === 'off'){
  $showCodeOff = ' checked';
}

$google_analytics_id 
          = !empty($mwswputil_config->config['google_analytics_id']) 
          ? $mwswputil_config->config['google_analytics_id'] 
          : 'Tracking or Measurement ID';



$showTagOn = '';
$showTagOff = '';
if($mwswputil_config->config['google_htmltag_option'] === 'on'){
  $showTagOn = ' checked';
} else if($mwswputil_config->config['google_htmltag_option'] === 'off'){
  $showTagOff = ' checked';
}

$google_htmltag_content 
          = !empty($mwswputil_config->config['google_htmltag_content']) 
          ? $mwswputil_config->config['google_htmltag_content'] 
          : 'your-verification-string';


$showAdOn = '';
$showAdOff = '';
if($mwswputil_config->config['google_adsense_option'] === 'on'){
  $showAdOn = ' checked';
} else if($mwswputil_config->config['google_adsense_option'] === 'off'){
  $showAdOff = ' checked';
}

$google_adsense_id
          = !empty($mwswputil_config->config['google_adsense_id']) 
          ? $mwswputil_config->config['google_adsense_id'] 
          : 'adsense-publisher-id';


?>

<div class="wrap">

<div class="container">
<table class="wp-list-table widefat striped">
    <thead>
      <tr>
      <td colspan="2">Setup Google Analytics Tracking Code:</td>
      </tr>
    </thead>
    <tbody>
    <form method="post">
      <tr>
          <!-- <td><input type="text" value="AUTO_GENERATED" disabled></td> -->
          <td width="25%">Google Analytics ID</td>
          <td>
            <input type="text" id="tagContent" name="google_analytics_id" class="set-width" placeholder="<?=$google_analytics_id;?>" />
          </td>
        </tr>
        <tr>
          <!-- <td><input type="text" value="AUTO_GENERATED" disabled></td> -->
          <td width="25%">Setup Google Analytics</td>
          <td>
          <div>
            <input type="radio" id="showtagOn" name="showcode" value="on"<?=$showCodeOn?> />
            <label for="showtagOn">Enable</label>
          </div>

          <div>
            <input type="radio" id="showtagOff" name="showcode" value="off"<?=$showCodeOff?> />
            <label for="showtagOff">Disable</label>
          </div>
          </td>
        </tr>
        <?php wp_nonce_field( 'mwswp_google_analytics');?>
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

  <div class="container">

  
  <table class="wp-list-table widefat striped">
    <thead>
      <tr>
      <td colspan="2">Google SearchConsole (Webmaster) verification by HTML tag:</td>
      </tr>
    </thead>
    <tbody>
    <style>
    .trm-member form input[type=text]{
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
    }
    .set-width {
       min-width: 350px;
    }
    </style>
    Enabling this option will create the following line in your html head section:<br />
        <?php
        $str = '<code>';
        $str .= htmlspecialchars('<meta name="google-site-verification" content="'.$google_htmltag_content.'">');
        $str .= '</code>';
        echo $str;
        ?>

<div class="trm-member">
  <?php
    if ( current_user_can( 'manage_options' ) ) {
    ?>
      <form method="post">
        <tr>
          <!-- <td><input type="text" value="AUTO_GENERATED" disabled></td> -->
          <td width="25%">Show Html Tag</td>
          <td>
          <div>
            <input type="radio" id="showtagOn" name="showtag" value="on"<?=$showTagOn?> />
            <label for="showtagOn">Enable</label>
          </div>

          <div>
            <input type="radio" id="showtagOff" name="showtag" value="off"<?=$showTagOff?> />
            <label for="showtagOff">Disable</label>
          </div>
          </td>
        </tr>
        
        <tr>
        <tr>
          <!-- <td><input type="text" value="AUTO_GENERATED" disabled></td> -->
          <td width="25%">Verification Code</td>
          <td>
            <input type="text" id="tagContent" name="google_htmltag_content" class="set-width" placeholder="<?=$google_htmltag_content;?>" />
          </td>
        </tr>
        <?php wp_nonce_field( 'mwswp_google_htmltag');?>
        <tr>
            <td width="25%">
              <input id="reset_upload_form" class="" type="reset" value="Reset form" />
            </td>
            <td><button id="newsubmit" name="newsubmit" type="submit">Save</button></td>
        </tr>
      </form>
      <?php
    }
    ?>
      </div> <!--  /trm-members -->

      </tbody>  
  </table>
</div> <!-- /Container -->

<br />
<br />
<br />

<!-- Adsense -->
  <div class="container">

  
  <table class="wp-list-table widefat striped">
    <thead>
      <tr>
      <td colspan="2">Google Adsense Header script tag:</td>
      </tr>
    </thead>
    <tbody>
    <style>
    .trm-member form input[type=text]{
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
    }
    .set-width {
       min-width: 350px;
    }
    </style>
    Enabling this option will create the following line in your html head section:<br />
        <?php
        $str = '<code>';
        // $str .= htmlspecialchars('<meta name="google-site-verification" content="'.$google_htmltag_content.'">');
        $str .= htmlspecialchars('<script data-ad-client="'.$google_adsense_id.'" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>');
        $str .= '</code>';
        echo $str;
        ?>

<div class="trm-member">
  <?php
    if ( current_user_can( 'manage_options' ) ) {
    ?>
      <form method="post">
        <tr>
          <!-- <td><input type="text" value="AUTO_GENERATED" disabled></td> -->
          <td width="25%">Enable Adsense Header Code</td>
          <td>
          <div>
            <input type="radio" id="showAdOn" name="showads" value="on"<?=$showAdOn?> />
            <label for="showAdOn">Enable</label>
          </div>

          <div>
            <input type="radio" id="showAdOff" name="showads" value="off"<?=$showAdOff?> />
            <label for="showAdOff">Disable</label>
          </div>
          </td>
        </tr>
        
        <tr>
        <tr>
          <!-- <td><input type="text" value="AUTO_GENERATED" disabled></td> -->
          <td width="25%">Adsense Publisher ID</td>
          <td>
            <input type="text" id="adsenseId" name="google_adsense_id" class="set-width" placeholder="<?=$google_adsense_id;?>" />
          </td>
        </tr>
        <?php wp_nonce_field( 'mwswp_google_adsense');?>
        <tr>
            <td width="25%">
              <input id="reset_upload_form" class="" type="reset" value="Reset form" />
            </td>
            <td><button id="newsubmit" name="newsubmit" type="submit">Save</button></td>
        </tr>
      </form>
      <?php
    }
    ?>
      </div> <!--  /trm-members -->

      </tbody>  
  </table>
</div> <!-- /Container -->
  

  <br>
  </div>