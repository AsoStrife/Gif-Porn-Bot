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
        'pls amateur'       => 'https://xgifer.com/amateur/',
        'pls anal'         => 'https://xgifer.com/anal/',
        'pls asian'       => 'https://xgifer.com/asian/', 
        'pls ass'   => 'https://xgifer.com/ass/', 
        'pls babes'          => 'https://xgifer.com/babes/',
        'pls bbw'      => 'https://xgifer.com/bbw/', 
        'pls bdsm'      => 'https://xgifer.com/bdsm/',
        'pls bigtette'          => 'https://xgifer.com/big-tits/'
        'pls blonde'          => 'https://xgifer.com/blonde/'
        'pls blowjob'          => 'https://xgifer.com/blowjob/'
        'pls brunette'          => 'https://xgifer.com/brunette/'
        'pls celebrity'          => 'https://xgifer.com/celebrity/'
        'pls college'          => 'https://xgifer.com/college/'
        'pls creampie'          => 'https://xgifer.com/creampie/'
        'pls cumshots'          => 'https://xgifer.com/cumshots/'
        'pls doublepene'          => 'https://xgifer.com/double-penetration/'
        'pls ebony'          => 'https://xgifer.com/ebony/'
        'pls emo'          => 'https://xgifer.com/emo/'
        'pls fisting'          => 'https://xgifer.com/fisting/'
        'pls footjob'          => 'https://xgifer.com/footjob/'
        'pls gangbang'          => 'https://xgifer.com/gang-bang/'
        'pls girlfriend'          => 'https://xgifer.com/girlfriend/'
        'pls groupsex'          => 'https://xgifer.com/group-sex/'
        'pls hairy'          => 'https://xgifer.com/hairy/'
        'pls handjob'          => 'https://xgifer.com/handjob/'
        'pls hentai'          => 'https://xgifer.com/hentai/'
        'pls hardcore'          => 'https://xgifer.com/hardcore/'
        'pls indian'          => 'https://xgifer.com/indian/'
        'pls interracial'          => 'https://xgifer.com/interracial/'
        'pls latina'          => 'https://xgifer.com/latina/'
        'pls lesbian'          => 'https://xgifer.com/lesbian/'
        'pls lingerie'          => 'https://xgifer.com/lingerie/'
        'pls masturbation'          => 'https://xgifer.com/masturbation/'
        'pls mature'          => 'https://xgifer.com/mature/'
        'pls milf'          => 'https://xgifer.com/milf/'
        'pls public'          => 'https://xgifer.com/public-sex/'
        'pls pussy'          => 'https://xgifer.com/pussy/'
        'pls redhead'          => 'https://xgifer.com/redhead/'
        'pls selfshot'          => 'https://xgifer.com/selfshot/'
        'pls cazzo'          => 'https://xgifer.com/solo-male/'
        'pls teen'          => 'https://xgifer.com/teen/'
        'pls threesome'          => 'https://xgifer.com/threesome/'
        'pls toys'          => 'https://xgifer.com/toys/'
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