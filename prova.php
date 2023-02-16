<?php 
    require_once('vendor/autoload.php');
    
    $curl = new Curl\Curl();

    $curl->post("https://strifegifbot.azurewebsites.net/", [
        'category' => "pls tette",
        'url' => "https://cdn.sex.com/images/pinporn/2020/09/12/23623413.gif?width=300",
    ]);

    echo $curl->response; 