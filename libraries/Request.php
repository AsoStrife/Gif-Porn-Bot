<?php

use PHPHtmlParser\Dom;
use Curl\Curl;

require_once('libraries/Config.php');
require_once('libraries/Keyboard.php');

class Request {

	private $chatID; 
    private $curl; 

    public function __construct($chatID) {
        $this->curl = new Curl();

        if(is_null($chatID) || $chatID == "")
            throw new Exception("ChatID is null in Request Constructor");
        
        $this->chatID = $chatID;
        
    }
    
	public function sendMessage($text) {
		if(is_null($text) || $text == "")
            throw new Exception("Text is null in sendMessage");

        $data = array(
            'chat_id'       => $this->chatID,
            'text'          => $text,
            'reply_markup'  => Keyboard::getKeyboard()
        ); 

        $this->curl->post(Config::sendMesssageUrl(), $data);
		
	}
	
	public function sendAnimation($animation) {
        if(is_null($animation) || $animation == "")
            throw new Exception("Animation url is null in sendAnimation");

        $data = array(
            'chat_id' 	    => $this->chatID,
            'animation'     => $animation, //"http://strifegifbot.azurewebsites.net/gif/pls%20figa/20701186.gif",
            'reply_markup'  => Keyboard::getKeyboard()
        ); 

        $this->curl->post(Config::sendAnimationUrl(), $data);
	}

    public function handleMessage($text){
        $categoryUrl = Config::getCategoryUrlFromText($text); 
        $category = Config::getCategoryKeyFromValue($categoryUrl);

        $gifUrl = $this->getRandomGifUrlFromProvider($categoryUrl);

        $animation = $this->getGifFromAzure($category, $gifUrl); 

        $this->sendAnimation($animation);
    }

	
	private function getRandomGifUrlFromProvider($categoryUrl = "") {
        
        $dom = new Dom;
        $dom->loadFromUrl($categoryUrl);
    
        $elements = $dom->find('.masonry_box'); 
    
        if(count($elements) == 0) {
            throw new Exception("No elements were found in getRandomGifUrlFromProvider");
        }

        $min = 0; 
        $max = count($elements) - 1; 
    
        $random_gif = random_int($min, $max); 
    
        $singleElement = $elements[$random_gif]->find('img');
            
        if(count($singleElement) == 0){
            throw new Exception("No singleElement were found in getRandomGifUrlFromProvider");
        }

        $gifUrl = $singleElement[0]->getAttribute('data-src');

        if(is_null($gifUrl) || $gifUrl == "") {
            throw new Exception("No gif was found in getRandomGifUrlFromProvider");
        }
        
        return $gifUrl; 
	}

    private function getGifFromAzure($category, $url) {
        $this->curl->post(Config::$azureService, [
            'category'  => $category,
            'url'       => $url,
        ]);

        if ($this->curl->error) {
            throw new Exception("Curl Error: " . $this->curl->errorMessage . " | Category: " . $category . " - Url: " . $url);
        } 

        return $this->curl->response; 
    }

}