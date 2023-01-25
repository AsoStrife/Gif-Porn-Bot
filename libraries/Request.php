<?php

use PHPHtmlParser\Dom;
use Curl\Curl;

/**
 * @author Andrea Corriga
 * @date 21/02/2021 (dd-mm-YYYY)
 */
class Request {

	private $config; 

    // $items[array_rand($items)];
    private $urls = array(
        'pls pompini'       => 'http://porngif.it/index.php?k=pompini',
        'pls tette'         => 'http://porngif.it/index.php?k=tette',
        'pls cowgirl'       => 'http://porngif.it/index.php?k=cowgirl', 
        'pls missionario'   => 'http://porngif.it/index.php?k=missionario', 
        'pls culi'          => 'http://porngif.it/index.php?k=culi',
        'pls pecorina'      => 'http://porngif.it/index.php?k=a%20pecorina', 
        'pls sborrate'      => 'http://porngif.it/index.php?k=sborrate',
        'pls figa'          => 'http://porngif.it/index.php?k=micio'
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
		$gif = $this->get_gif($text);

        $data = array(
            'chat_id' 	=> $chatID,
            'animation' => $gif); 

        $curl = new Curl();
        return $curl->post($url, $data);
	}

	/**
	 * 
	 */
	public function get_gif($parameter = ""){
        $url = "";

        if($parameter == "" || $parameter == 'pls porn'){
            $url = $this->urls[array_rand($this->urls)];
        }
        else{
            $url = $this->urls[$parameter];
        }

        $dom = new Dom;
        $dom->loadFromUrl($url);

        $list_html = $dom->find('#list')[0]->innerHtml;

        $dom->loadStr($list_html);
        $imgs = $dom->find('img.big');

        $rand_int = rand(0, count($imgs) - 1);
        return 'http://porngif.it/' . $imgs[$rand_int]->src;
	}

}