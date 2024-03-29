<?php 

require_once('vendor/autoload.php');

require_once('libraries/Log.php');
require_once('libraries/Config.php');
require_once('libraries/Request.php');
require_once('libraries/Message.php');

error_reporting(E_ALL);
ini_set('display_errors', 0);

$input = json_decode(file_get_contents('php://input'), true);

if(!isset($input)){
	header("location: " . Config::botTelegramUrl);
	exit;
} 

if(!isset($input['message']))
    exit; 

Log::message($input);

$message = new Message($input['message']);


$chat = isset($input['chat']) ? $input['chat'] : null;

$request = new Request($message->chatID, $message->threadID);

// Accepted strings
$acceptedCategories = Config::getAcceptedCategories();

$text = strtolower($message->text);

// Handle /start command
if($text == "/start" || $text == "/start@gifporn_bot") {
	$string = "Gif Porn Bot accetta i seguenti comandi:\n\n";

	foreach($acceptedCategories as $s){
		$string .=  "- " . $s . "\n"; 
	}

    $string .= "\n";
    $string .= "- Sito web: https://andreacorriga.com\n";
    $string .= "- Donazioni: http://paypal.me/AsoStrife";

	$request->sendMessage($string);
    $request->sendMessage("Scegli una categoria di GIF:", true); 
}

if($text == "/keyboard" || $text == "/keyboard@gifporn_bot") {
    $request->sendMessage("Scegli una categoria di GIF:", true); 
}

if($text == "/stats" || $text == "/stats@gifporn_bot") {
    $request->handleStats(); 
}

// Handle the received message
if(in_array($text, $acceptedCategories)){
    try {
        $request->handleMessage($text);
    }
    catch (Exception $e) {
        $request->sendMessage($e->getMessage());
    }
}