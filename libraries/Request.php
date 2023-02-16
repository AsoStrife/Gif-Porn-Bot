<?php

use PHPHtmlParser\Dom;
use Curl\Curl;

/**
 * @author Andrea Corriga
 * @date 21/02/2021 (dd-mm-YYYY)
 */
class Request {

	private $config; 
    private $log_path = "/home/lzaslddj/gifbot.andreacorriga.com/error_log"; 

    // $items[array_rand($items)];
    private $baseUrl = "https://it.sex.com/pin/64935004/"; 

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

    public function getUrls(){
        return array_keys($this->urls);
    }
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
		$gif = $this->get_gif($text);
        $gif = str_replace(".webp", ".gif", $gif);

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
	public function get_gif($parameter = "") {
        $now = date('Y-m-d H:i:s');

        $url = "";

        if($parameter == "" || $parameter == 'pls porn'){
            $url = $this->urls[array_rand($this->urls)];
        }
        else{
            $url = $this->urls[$parameter];
        }

        error_log("\n[$now] Requested Gif with the following url: " . $url . "\n", 3, $this->log_path);

        $dom = new Dom;
        $dom->loadFromUrl($url);

        $elements = $dom->find('.masonry_box'); 

        error_log("\n[$now] .thumg-holder number of elements: " . count($elements) . "\n", 3, $this->log_path);

        if(count($elements) == 0)
            return ""; 

        $min = 0; 
        $max = count($elements); 

        $random_gif = random_int($min, $max); 

        error_log("[$now] Random element index: " . $random_gif . "\n", 3, $this->log_path);

        $single_element = $elements[$random_gif]->find('img');

        if(count($single_element) > 0){
            $value = $single_element[0]->getAttribute('data-src');

            error_log("[$now] Final value: " . $value . "\n", 3, $this->log_path);

            return $value;
        }

        return ""; 

	}

}