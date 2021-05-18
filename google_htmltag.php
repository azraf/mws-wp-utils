<?php
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once __DIR__ .'/bootstrap.php';

$mws_wputil_config = new MwsWpUtilConfig();
$config_settings = $mws_wputil_config->config_values();

if(isset($_POST['showtag']) || isset($_POST['google_htmltag_content'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mws_google_htmltag' ) ) {
      if(isset($_POST['showtag'])){
        $mws_wputil_config->config['google_htmltag_option'] = mws_sanitize_items($_POST['showtag']);
      }
      
      if(isset($_POST['google_htmltag_content'])){
        $newContent = $_POST['google_htmltag_content'];
        if(!empty($newContent)){
          $mws_wputil_config->config['google_htmltag_content'] = mws_sanitize_items(trim($newContent));
        }
      }
      $mws_wputil_config->saveReload();
      $config_settings = $mws_wputil_config->config_values();
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } 
}
// _d($config_settings,'$config_settings');

// $userSuspended = $member->disabled ? 'checked' : '';
// $userActive = $member->disabled ? '' : 'checked';

$showTagOn = '';
$showTagOff = '';
if($mws_wputil_config->config['google_htmltag_option'] === 'on'){
  $showTagOn = ' checked';
} else if($mws_wputil_config->config['google_htmltag_option'] === 'off'){
  $showTagOff = ' checked';
}

$google_htmltag_content 
          = !empty($mws_wputil_config->config['google_htmltag_content']) 
          ? $mws_wputil_config->config['google_htmltag_content'] 
          : 'your-verification-string';


?>

<div class="wrap">
  <table class="wp-list-table widefat striped">
    <thead>
      <tr>
      <td>Google verification by HTML tag:</td><td></td>
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
    <p>Enabling this option will create the following line in your html head section:<br />
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
        <?php wp_nonce_field( 'mws_google_htmltag');?>
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
      </div>

      </tbody>  
  </table>
  <br>
  </div>