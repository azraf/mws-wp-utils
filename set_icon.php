<?php
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once __DIR__ .'/bootstrap.php';

$mws_wputil_config = new MwsWpUtilConfig();
$config_settings = $mws_wputil_config->config_values();
if(isset($_POST['mws_wp_util_favicon'])){
    if ( current_user_can( 'manage_options' ) ) {
        if ( check_admin_referer( 'mws_set_favicon' ) ) {
            $mws_wputil_config->config['set_favicon'] = mws_sanitize_items($_POST['mws_wp_util_favicon']);
            $mws_wputil_config->saveReload();
            $config_settings = $mws_wputil_config->config_values();
        }
} else {
  echo "You dont have sufficient privilege to perform this action!";
} // current_user_can method END
}

// _d($config_settings,'$config_settings');

$showFavOn = '';
$showFavOff = '';
if($mws_wputil_config->config['set_favicon'] === 'on'){
  $showFavOn = ' checked';
} else if($mws_wputil_config->config['set_favicon'] === 'off'){
  $showFavOff = ' checked';
}

?>
<div>
    <h2>Create Favicon for your website from <a href="https://create-favicon.com" target="_blank" title="Create Favicon">create-favicon.com</a></h2>
    <p>After generating favicon, upload the files to your wordpress root directory.<br />
    Path will be like: yourdomain.com/favicon-16x16.png OR yourdomain.com/apple-touch-icon.png and so on.
    </p>
    <p>Enabling this option will create 6 lines at the bottom of you html head section:<br />
        <?php
        $str = '<code>';
        $str .= htmlspecialchars('<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />');
        $str .= '<br />'.htmlspecialchars('<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />');
        $str .= '<br />'.htmlspecialchars('<link rel="icon" type="image/png" sizes="64x64" href="/favicon-64x64.png" />');
        $str .= '<br />'.htmlspecialchars('<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />');
        $str .= '<br />'.htmlspecialchars('<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />');
        $str .= '<br />'.htmlspecialchars(' <link rel="manifest" href="/site.webmanifest" />');
        $str .= '</code>';
        echo $str;
        ?>
    </p>
    <br />
    <div class="">
    <?php
    if ( current_user_can( 'manage_options' ) ) {
    ?>
        <form method="post" action="">Enable Custom Favicon link:
            <input type="radio" id="mws_wp_util_icon_on" name="mws_wp_util_favicon" value="on"<?=$showFavOn?> />
                <label for="mws_wp_util_icon_on">On</label> &nbsp; | &nbsp;
                <input type="radio" id="mws_wp_util_icon_off" name="mws_wp_util_favicon" value="off"<?=$showFavOff?> />
                <label for="mws_wp_util_icon_off">Off</label><br>
                <?php wp_nonce_field( 'mws_set_favicon');?>
            <?php  submit_button(); ?>
<!--            <p>-->
<!--                <input type="submit" name="submit" id="submit" class="button button-primary" value="Delete Products">-->
<!--            </p>-->
        </form>
        <?php
    }
    ?>
    </div>
</div>