<?php 
require_once('vendor/autoload.php');

$serviceUrl = "https://strifegifbot.azurewebsites.net/";

$basepath = 'gif/';

$category = $_POST['category'];
$url = $_POST['url'];
$filename = basename(strtok($url, '?'));

if(!isset($category)){
    echo "Categoria assente";
    exit;
}
if(!isset($url)){
    echo "URL assente";
    exit;
}

$fullpath = $basepath . $category . '/';

if (!is_dir($fullpath)) {
    mkdir($fullpath, 0777, true);
}

$curl = new Curl\Curl();

$curl->setHeader('referer', 'https://it.sex.com/');
$curl->get($url);

// Controlla se la richiesta è stata eseguita con successo
if ($curl->error) {
    echo 'Errore: ' . $curl->errorCode . ': ' . $curl->errorMessage;
} 
else {
    // Salva l'immagine nel file system del tuo server
    $imagePath = $fullpath . $filename;
    file_put_contents($imagePath, $curl->response);
    echo $serviceUrl . $imagePath;
}