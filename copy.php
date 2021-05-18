<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!function_exists('mws_remoteCopy')){
  function mws_remoteCopy($file,$newfile){
    $context = stream_context_create(array(
      'http' => array(
          'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
      ),
      ));
    if ( copy($file, $newfile, $context) ) {
      echo "Copy success!";
    }else{
        echo "Copy failed.";
    }
  }
}

$mws_util_plugin_url = plugin_dir_url( __FILE__ ) ;

if(isset($_POST['url'])){
  if ( current_user_can( 'manage_options' ) ) {
    if ( check_admin_referer( 'mws_remote_copy' ) ) {
    if(!empty($_POST['save_name'])){
      $fileName = mws_sanitize_items(trim($_POST['save_name']));
    } else {
      $fileName = mws_sanitize_items(basename($_POST['url'])); 
    }

    $url = mws_sanitize_items(trim($_POST['url']));

    if(!empty($_POST['save'])){
      
      switch($_POST['save']){
        
        case 'plugin_dir':
          $saveDir = __DIR__ . '/downloads/';
          break;

        case 'ai1backup':
          $saveDir = dirname(dirname(__DIR__)) . '/ai1wm-backups/';
          break;

        case 'custom':
            $wp_dir = dirname(dirname(dirname(dirname(__FILE__))));
            $ltrim_path = ltrim($_POST['save_path'], '/\\');
            $part_path = rtrim($ltrim_path, '/\\');
            $custom_path = trim($part_path);
            if(!empty($custom_path)){
              $tail =  $custom_path . '/';
            } else {
              $tail =   '';
            }
            $saveDir = $wp_dir . '/' . $tail;
            break;

        default:
          $saveDir = false;
          break;
      }


      if (!is_dir($saveDir)) {
        if(mkdir( $saveDir, 0755, true)){
          _d($saveDir . 'Directory CREATED');
        } else {
          _d( 'FAILED to create directory ::: '.$saveDir ,'saveDir');
        }
      }
      $savepath = $saveDir . $fileName;

      mws_remoteCopy($url,$savepath);
    }
    }
  } else {
    echo "You dont have sufficient privilege to perform this action!";
  } // current_user_can method END
}
?>
<div>
  <h3>Copy Remote File</h3>
  <?php
    if ( current_user_can( 'manage_options' ) ) {
    ?>
    <form method="post" action="">
        <p></p>
        <div>
          Copy from Url :<br /> <input type="text" name="url" class="large-text" placeholder="Remote file URL" />
          <br />
          <br />
          Save File Name :<br />  <input type="text" name="save_name" class="regular-text" id="save_name" placeholder="Leave blank for original file name" value="" />
          &nbsp;&nbsp;<span class="decription"> Leave this field blank to save as original file name.</span>
          <br />
          <br />
        
        <div><h4>Save in:</h4>
          <input type="radio" id="saveChoice1" name="save" value="plugin_dir">
          <label for="saveChoice1">Plugin Directory *1</label>
          <br />

          <input type="radio" id="saveChoice2" name="save" value="ai1backup">
          <label for="saveChoice2">All in 1 Backup Directory</label>
          <br />

          <input type="radio" id="saveChoice3" name="save" value="custom" checked>
          <label for="saveChoice3">Custom Directory</label>
        </div>
            <br />
  <div>
      <span class="decription">If Plugin directory selected, download location will be: <?php echo __DIR__ . '/downloads/'; ?> </span><br />
      <span class="decription">and that directory URL: <a href="<?php echo $mws_util_plugin_url . 'downloads/';?>"><?php echo $mws_util_plugin_url . 'downloads/';?></a>.</span>
  </div>
          <br />
          <br />
          <div id="custom_path" style="visibility:visible;">
          Save Path : <input type="text" name="save_path" id="save_path" class="large-text" placeholder="Leave it blank to copy file in your wp root directory" />
              &nbsp;&nbsp;<span class="decription">This path is relative to WordPress installation Directory.</span>
          </div>
          <br />
        </div>
        <?php wp_nonce_field( 'mws_remote_copy');?>
        <?php  submit_button(); ?>
    </form>
    <?php
    }
    ?>
</div>

<script>
    jQuery(document).ready(function( $ ) {
      $('input[name="save"]').on('click', function() {
        if ($(this).val() === 'custom') {
            $("#custom_path").css("visibility", "visible");
            $('#save_path').removeProp("disabled");
        } else {
            $('#save_path').prop("disabled", "disabled");
            $("#custom_path").css("visibility", "hidden");
        }
      });
    });
</script>