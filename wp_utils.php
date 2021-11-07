<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
include_once __DIR__ .'/bootstrap.php';

// $mwswputil_config = new MwsWpUtilConfig(false);
// $mwswputil_config->set_default_values();

// $mwswputil_config = new MwsWpUtilConfig();
// $config_settings = $mwswputil_config->config_values();

// _d($config_settings,'$config_settings');

?>

<div class="wrap">
  <table class="wp-list-table widefat striped">
      <thead>
          <tr><td>Utilites</td></tr>
      </thead>
    <tbody>
        <tr>
            <td><a class="" href="<?=admin_url('admin.php?page=mwswp_copy_url')?>">Copy Remote File</a></td>
    </tr>
    <tr>
        <td><a class="" href="<?=admin_url('admin.php?page=mwswp_set_icon')?>">Favicon</a></td>
    </tr>
    <tr>
        <td><a class="" href="<?=admin_url('admin.php?page=mwswp_google_htmltag')?>">Google Accounts</a></td>
    </tr>
    <tr>
        <td><a class="" href="<?=admin_url('admin.php?page=mwswp_wc_utils')?>">WooCommerce</a></td>
    </tr>
    <tr>
        <td><a class="" href="<?=admin_url('admin.php?page=mwswp_phpinfo')?>">PHP Info</a></td>
    </tr>
</tbody>
  </table>
</div>