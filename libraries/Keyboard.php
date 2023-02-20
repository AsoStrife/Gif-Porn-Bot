<?php 

require_once('libraries/Config.php');

class Keyboard {

    private static function getKeyboardsMatrix() {
        $categories = Config::getAcceptedCategories();

        return array_chunk($categories, 3);
    }

    public static function getKeyboard() {
        // Creazione del markup della tastiera
        $markup = array(
            'keyboard' => Keyboard::getKeyboardsMatrix(),
            "resize_keyboard" => true,
            "one_time_keyboard" => false,
            
        );

        return json_encode($markup);
    }
}