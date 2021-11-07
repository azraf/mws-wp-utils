<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!function_exists('mwswputil_get_config')){
    function mwswputil_get_config()
    {
        $config_file = __DIR__ . '/config.json';
        $config_string = file_get_contents($config_file);

        return json_decode($config_string,true);
    }
}
?>