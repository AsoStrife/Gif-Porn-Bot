<?php 
// URL dell'immagine GIF che si desidera scaricare
$url = 'https://cdn.sex.com/images/pinporn/2022/02/09/26698663.gif?width=300';

// Inizializza una nuova richiesta CURL
$ch = curl_init($url);

// Imposta le opzioni della richiesta CURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // restituisci il risultato come stringa
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // restituisci i dati binari (necessario per le immagini)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ignora gli eventuali errori di certificazione SSL (da usare solo in ambiente di sviluppo)

$header = array(
    'referer: https://it.sex.com/'
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

// Esegui la richiesta CURL e ottieni la risposta
$response = curl_exec($ch);

// Chiudi la connessione CURL
curl_close($ch);

// Controlla se la risposta è valida
if ($response === false) {
    die('Errore: ' . curl_error($ch));
}

// Scrivi i dati della risposta su un file (nella directory corrente)
$file = fopen('image.gif', 'w');
fwrite($file, $response);
fclose($file);