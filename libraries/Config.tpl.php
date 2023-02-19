<?php

class Config {
    
    // Bot Url 
    public static $botTelegramUrl = "https://t.me/gif_porn_bot";

    // Bot name
    public static $botName = 'Gif Porn Bot';

    // Base url of the bot
    public static $baseBotApiUrl = '';

    // API Token 
    public static $apiToken = '';
    // Do not touch
    public static $baseApiUrl = 'https://api.telegram.org/bot';

    // Loggin path. Currently not used
    public static $log_path = "";

    // Azure webserver that physically downloads gifs
    public static $azureService = "";

    // Gif Provider
    public static $gifBaseUrl = "https://it.sex.com/gifs/"; 
    
    // Random gif category with this command 
    public static $randomCategoryCommand = "pls porn"; 

    // Get the Telegram API URL
    public static function getApiUrl() {
        return self::$baseApiUrl . self::$apiToken . '/';
    }

    // Get the Bot API URL
    public static function getExecuteBotUrl() {
        return self::$baseBotApiUrl . 'index.php';
    }

    // sendMessage API URL
    public static function sendMesssageUrl() {
        return self::getApiUrl() . 'sendMessage';
    }

    // sendAnimation API URL
    public static function sendAnimationUrl() {
        return self::getApiUrl() . 'sendAnimation';
    }

    // Gif Provider Categories 
    public static $gifApi = array (
        'pls amatoriali' => 'https://it.sex.com/gifs/amateur/',
        'pls anale' => 'https://it.sex.com/gifs/anal/',
        'pls asiatiche' => 'https://it.sex.com/gifs/asian/',
        'pls ciccione' => 'https://it.sex.com/gifs/bbw/',
        'pls tette' => 'https://it.sex.com/gifs/big-tits/',
        'pls bionde' => 'https://it.sex.com/gifs/blonde/',
        'pls pompini' => 'https://it.sex.com/gifs/blowjob/',
        'pls brune' => 'https://it.sex.com/gifs/brunette/',
        'pls creampie' => 'https://it.sex.com/gifs/creampie/',
        'pls sborrate' => 'https://it.sex.com/gifs/cumshots/',
        'pls squirt' => 'https://it.sex.com/gifs/female-ejaculation/',
        'pls gang bang' => 'https://it.sex.com/gifs/gang-bang/',
        'pls gay' => 'https://it.sex.com/gifs/gay/',
        'pls orgia' => 'https://it.sex.com/gifs/group-sex/',
        'pls pelose' => 'https://it.sex.com/gifs/hairy/',
        'pls seghe' => 'https://it.sex.com/gifs/handjob/',
        'pls hardcore' => 'https://it.sex.com/gifs/hardcore/',
        'pls lesbiche' => 'https://it.sex.com/gifs/lesbian/',
        'pls masturbazione' => 'https://it.sex.com/gifs/masturbation/',
        'pls cazzi' => 'https://it.sex.com/gifs/penis/',
        'pls figa' => 'https://it.sex.com/gifs/pussy/',
        'pls rosse' => 'https://it.sex.com/gifs/redhead/',
        'pls trans' => 'https://it.sex.com/gifs/shemale/',
        'pls maschi' => 'https://it.sex.com/gifs/solo-male/',
        'pls threesome' => 'https://it.sex.com/gifs/threesome/'
    );

    // Get the provider categories array list
    public static function getGifApiCategories() {
        return array_keys(self::$gifApi);
    }

    // Get the provider categories array list + the random gif command
    public static function getAcceptedCategories() {
        $categories = self::getGifApiCategories();

        array_unshift($categories, self::$randomCategoryCommand);

        return $categories; 
    }

    // Get the gif url (value) from the url (key)
    public static function getCategoryUrlFromText($text){
        if($text == self::$randomCategoryCommand)
            return self::$gifApi[array_rand(self::$gifApi)];
        
        return self::$gifApi[$text];
    }

    // Get the gif category (key) from the URL (value)
    public static function getCategoryKeyFromValue($value) {
        $key = array_search($value, self::$gifApi);

        if ($key === false) {
            throw new Exception("No Key found in `getCategoryKeyFromValue` for the folowing value: " . $value); 
        } 
        
        return $key; 
    }
}