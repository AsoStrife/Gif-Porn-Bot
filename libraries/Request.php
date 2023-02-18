<?php

use PHPHtmlParser\Dom;
use Curl\Curl;

/**
 * @author Andrea Corriga
 * @date 21/02/2021 (dd-mm-YYYY)
 */
class Request {

    private $azureService = "https://strifegifbot.azurewebsites.net/";

	private $config; 
    private $log_path = "/home/lzaslddj/gifbot.andreacorriga.com/error_log"; 

    // $items[array_rand($items)];
    private $baseUrl = "https://it.sex.com/gifs/"; 

    private $urls = array(
        'pls amatoriali'        => 'https://it.sex.com/gifs/amateur/',
        'pls anale'             => 'https://it.sex.com/gifs/anal/',
        'pls threesome'         => 'https://it.sex.com/gifs/threesome/',
        'pls asiatiche'         => 'https://it.sex.com/gifs/asian/',
        'pls bionde'            => 'https://it.sex.com/gifs/blonde/',
        'pls rosse'             => 'https://it.sex.com/gifs/redhead/',
        'pls brune'             => 'https://it.sex.com/gifs/brunette/',
        'pls ciccione'          => 'https://it.sex.com/gifs/bbw/',
        'pls figa'              => 'https://it.sex.com/gifs/pussy/',
        'pls squirt'            => 'https://it.sex.com/gifs/female-ejaculation/',
        'pls gay'               => 'https://it.sex.com/gifs/gay/',
        'pls gang bang'         => 'https://it.sex.com/gifs/gang-bang/',
        'pls lesbiche'          => 'https://it.sex.com/gifs/lesbian/',
        'pls masturbazione'     => 'https://it.sex.com/gifs/masturbation/',
        'pls orgia'             => 'https://it.sex.com/gifs/group-sex/',
        'pls pelose'            => 'https://it.sex.com/gifs/hairy/',
        'pls seghe'             => 'https://it.sex.com/gifs/handjob/',
        'pls sborrate'          => 'https://it.sex.com/gifs/cumshots/',
        'pls creampie'          => 'https://it.sex.com/gifs/creampie/',
        'pls trans'             => 'https://it.sex.com/gifs/shemale/',
        'pls tette'             => 'https://it.sex.com/gifs/big-tits/',
        'pls maschi'            => 'https://it.sex.com/gifs/solo-male/',
        'pls pompini'           => 'https://it.sex.com/gifs/blowjob/', 
        'pls cazzi'             => 'https://it.sex.com/gifs/penis/',
        'pls hardcore'          => 'https://it.sex.com/gifs/hardcore/'
    );

	public function __construct($config){
		$this->config = $config; 
	}

	/**
	 * 
	 */
	public function send($chatID, $text = '', $method = 'sendMessage') {

		if($chatID == null)
			return null; 

        $url = $this->config['apiUrl'] . $method;
			
        $data = array(
            'chat_id' => $chatID,
            'text' => $text); 


        $curl = new Curl();
        $curl->post($url, $data);
			

	}
	
	/**
	 * 
	 */
	public function send_gif($chatID, $text, $method = 'sendAnimation') {

        if($chatID == null)
			return null; 

        $url = $this->config['apiUrl'] . $method;

		$gifUrl = $this->get_random_gif_url($text);

        $gif = $this->post_to_azure($text, $gifUrl);

        $data = array(
            'chat_id' 	=> $chatID,
            'animation' => $gif
        ); 

        $curl = new Curl();
        return $curl->post($url, $data);
	}

	/**
	 * 
	 */
	public function get_random_gif_url($parameter = "") {
        $url = $this->urls[$parameter];
        
        $dom = new Dom;
        $dom->loadFromUrl($url);
    
        $elements = $dom->find('.masonry_box'); 
    
        if(count($elements) == 0)
            return null; 
    
        $min = 0; 
        $max = count($elements); 
    
        $random_gif = random_int($min, $max); 
    
        $single_element = $elements[$random_gif]->find('img');
            
        if(count($single_element) > 0){
            return $single_element[0]->getAttribute('data-src');
        }
    
        return null; 

	}

    private function post_to_azure($category, $url){
        $curl = new Curl();

        $curl->post($this->azureService, [
            'category' => $category,
            'url' => $url,
        ]);

        if ($curl->error) {
            echo 'Errore: ' . $curl->errorCode . ': ' . $curl->errorMessage;
        } 

        return $curl->response; 
    }

    public function getUrlsKeys() {
        return array_keys($this->urls);
    }

    private function getKeyboardsMatrix() {
        $array = $this->getUrlsKeys();
        array_unshift($array, 'pls porn');
        return array_chunk($array, 3);
    }

    public function test($chatID) {
        // Creazione del markup della tastiera
        $markup = array(
            'keyboard' => $this->getKeyboardsMatrix(),
            "resize_keyboard" => true,
            "one_time_keyboard" => false
        );

        $data = array(
            'chat_id' => $chatID,
            'text' => "Seleziona una gif",
            'reply_markup' => json_encode($markup)
        ); 
        $method = 'sendMessage';

        $url = $this->config['apiUrl'] . $method;
        $curl = new Curl();
        $curl->post($url, $data);

    }
}