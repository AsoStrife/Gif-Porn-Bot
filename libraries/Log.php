<?php 

require_once('libraries/Config.php');

class Log {

    private static function checkArray($string) {
        return is_array($string) ? json_encode($string) : $string;
    }
    
    public static function message($string) {
        $string = Log::checkArray($string);

        error_log($string, 0, Config::$log_path);
    }

    public static function alert($string) {
        $string = Log::checkArray($string);

        error_log($string, 1, Config::$log_path);
    }

    public static function critical($string) {
        $string = Log::checkArray($string);
        error_log($string, 2, Config::$log_path);
    }

    public static function error($string) {
        $string = Log::checkArray($string);

        error_log($string, 3, Config::$log_path);
    }

    public static function warning($string) {
        $string = Log::checkArray($string);

        error_log($string, 4, Config::$log_path);
    }

    
}