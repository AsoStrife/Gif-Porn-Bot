<?php
require_once('../vendor/autoload.php');
require_once('../vendor/pear/http_request2/HTTP/Request2.php');
//require_once 'HTTP/Request2.php'; // Only when installed with PEAR
use PHPHtmlParser\Dom;

/**
 * @author Andrea Corriga
 * @date 21/02/2021 (dd-mm-YYYY)
 */
class Request{

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

		try {

			$request = new HTTP_Request2($url);
			$request->setMethod(HTTP_Request2::METHOD_POST)
				->addPostParameter(array(
											'chat_id' 		=> $chatID,
											'text' 			=> $text,
										)); 
			$response = $request->send()->getBody();
			return $response; 
		} 
		catch (Exception $exc) {
			return $exc->getMessage();
		}
	}
	
	/**
	 * 
	 */
	public function send_gif($chatID, $text, $method = 'sendAnimation') {

		if($chatID == null)
			return null; 

	    $url = $this->config['apiUrl'] . $method;
		$gif = $this->get_gif($text);

		try {

			$request = new HTTP_Request2($url);
			$request->setMethod(HTTP_Request2::METHOD_POST)
				->addPostParameter(array(
											'chat_id' 	=> $chatID,
											'animation' => $gif,
										)); 
			$response = $request->send()->getBody();
			return $response; 
		} 
		catch (Exception $exc) {
			return $exc->getMessage();
		}
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
        /*
		try {
            /*
			$request = new HTTP_Request2("https://porngifs.com/ajax/scrolldown");
			$request->setMethod(HTTP_Request2::METHOD_POST)
				->addPostParameter(array(
											'loadcount' => rand(10, 9999)
										)); 

                                        
			$response = json_decode($request->send()->getBody(), 1);
			return "https://cdn.porngifs.com/img/" . $response[0]['id'];
            
            return "https://cdn.sex.com/images/pinporn/2021/08/20/25740761.gif?width=300";
		} 
		catch (Exception $exc) {
			return null;
		}
        */
	}

}