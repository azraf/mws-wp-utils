<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include_once __DIR__ .'/vendor/autoload.php';

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

use Noodlehaus\Config;
use Noodlehaus\Parser\Json;
use Noodlehaus\Parser\Serialize;
use Noodlehaus\Parser\ParserInterface;

class MwsWpUtilConfig {
    private $_config_file = __DIR__ . '/config.json';
    public $config;

    public function __construct($initialize=true)
    {
        if($initialize){
            $this->initialize($this->_config_file);
        }
    }

    public function initialize($values, ParserInterface $parser = null, $string = false)
    {
        $this->config = new Config($values, $parser, $string);
    }

    public function save(){
        $this->config->toFile($this->_config_file);
    }

    public function saveReload(){
        $this->config->toFile($this->_config_file);
        $this->initialize($this->_config_file);
    }

    public function config_values($do_initialize=false){
        if($do_initialize){
            $this->initialize($this->_config_file);
        }
        return $this->config->all();
    }

    /**
     * to set config at default values
     * initialize the config with false param
     * $mws_wputil_config = new MwsWpUtilConfig(false);
     * $mws_wputil_config->set_default_values();
     * 
     */
    public function set_default_values(){
        $default_data = serialize([
            'module_settings' => [
                'copy_file'   => 'on',
                'favicon' => 'on',
                'google_htmltag' => 'on',
                'woocommerce' => 'on',
                'phpinfo' => 'on',
                'head_script' => 'off', // upcoming
                'footer_script' => 'off' // upcoming
            ],
            'set_favicon' => 'on',
            'google_htmltag_option' => 'off',
            'google_htmltag_content' => ''
            ]);

        $serialize = new Serialize;
        $this->initialize($default_data, $serialize, true);
        $this->config->toFile($this->_config_file);
    }
        
}


?>