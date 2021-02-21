<?php
require_once('vendor/autoload.php');
require_once('vendor/pear/http_request2/HTTP/Request2.php');

/**
 * @author Andrea Corriga
 * @date 21/02/2021 (dd-mm-YYYY)
 */
class Request{

	private $config; 

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
	public function send_gif($chatID, $method = 'sendAnimation') {

		if($chatID == null)
			return null; 

	    $url = $this->config['apiUrl'] . $method;
		$gif = $this->get_gif();

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
	public function get_gif(){
		try {

			$request = new HTTP_Request2("https://porngifs.com/ajax/scrolldown");
			$request->setMethod(HTTP_Request2::METHOD_POST)
				->addPostParameter(array(
											'loadcount' => rand(10, 9999)
										)); 
			$response = json_decode($request->send()->getBody(), 1);
			return "https://cdn.porngifs.com/img/" . $response[0]['id'];
		} 
		catch (Exception $exc) {
			return null;
		}
	}

}