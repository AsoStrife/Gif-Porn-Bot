<?php 

/**
 * @author Andrea Corriga
 * @date 21/02/2021 (dd-mm-YYYY)
 */

require_once('vendor/autoload.php');
require_once('config/config.php');
require_once('libraries/Request.php');
require_once('libraries/Message.php');
//require_once('libraries/Log.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);


$input = json_decode(file_get_contents('php://input'), true);

if(!isset($input)){
	header("location: https://t.me/gif_porn_bot");
	exit;
} 

$message = new Message($input['message']);
$chat = isset($input['chat']) ? $input['chat'] : null;
$request = new Request($config);

/* Don't need logs
$log = new Logs();
$input = file_get_contents('php://input');
$log->save($input);
*/

// Accepted strings
$accepted_strings = $request->getUrls();

$text = strtolower($message->text);

if($text == "/start"){
	$string = "Gif Porn Bot. Before go to horny jail, just take 3 seconds to understand how this bot works.\n\nType:\n ";

	foreach($accepted_strings as $s){
		$string .=  "- " . $s . "\n"; 
	}

	$string .= "\n Now, go to horny jail. Bonk. \n @AsoStrife, https://andreacorriga.com";
	
	$request->send($message->chatID, $string); 
}

if($text == "/info"){
    $string = "AsoStrife Gif Porn Bot. Before go to horny jail, just take 3 seconds to understand how this bot works.\n\nType:\n";

	foreach($accepted_strings as $s){
		$string .=  "- " . $s . "\n"; 
	}

	$string .= "
            \nTo make your day. Thanks the humble @AsoStrife for this bot. \n\n
		- Website: https://andreacorriga.com
		- Donations: http://paypal.me/AsoStrife";

	$request->send($message->chatID, $string); 
}

// Send Porn Gif if message is in array
if(in_array($text, $accepted_strings))
    $response = $request->send_gif($message->chatID, $text);
