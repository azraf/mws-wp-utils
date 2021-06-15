<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
include_once __DIR__ .'/bootstrap.php';

// $mws_wputil_config = new MwsWpUtilConfig(false);
// $mws_wputil_config->set_default_values();

// $mws_wputil_config = new MwsWpUtilConfig();
// $config_settings = $mws_wputil_config->config_values();

// _d($config_settings,'$config_settings');

?>

<div class="wrap">
  <table class="wp-list-table widefat striped">
      <thead>
          <tr><td>Utilites</td></tr>
      </thead>
    <tbody>
        <tr>
            <td><a class="" href="<?=admin_url('admin.php?page=mws_wp_copy_url')?>">Copy Remote File</a></td>
    </tr>
    <tr>
        <td><a class="" href="<?=admin_url('admin.php?page=mws_wp_set_icon')?>">Favicon</a></td>
    </tr>
    <tr>
        <td><a class="" href="<?=admin_url('admin.php?page=mws_wp_google_htmltag')?>">Google Accounts</a></td>
    </tr>
    <tr>
        <td><a class="" href="<?=admin_url('admin.php?page=mws_wp_wc_utils')?>">WooCommerce</a></td>
    </tr>
    <tr>
        <td><a class="" href="<?=admin_url('admin.php?page=mws_wp_phpinfo')?>">PHP Info</a></td>
    </tr>
</tbody>
  </table>
</div>