<?php

/**
 * @author Andrea Corriga
 * @date 21/02/2021 (dd-mm-YYYY)
 */
class Logs{

	private static $folder = "./";

	/**
	 *
	 */
	public static function save($text){
		$filename = date('Y-m-d') . 'logs.txt';

		$fp = fopen(self::$folder . $filename, 'a+');
		fwrite($fp, $text . "\r\n");
		fclose($fp);
	}
}