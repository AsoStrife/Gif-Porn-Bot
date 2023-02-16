<?php 
    require_once('vendor/autoload.php');
    use PHPHtmlParser\Dom;

    $now = date('Y-m-d H:i:s');

    $url = "https://it.sex.com/gifs/pussy/";

    // if($parameter == "" || $parameter == 'pls porn'){
    //     $url = $this->urls[array_rand($this->urls)];
    // }
    // else{
    //     $url = $this->urls[$parameter];
    // }

    // error_log("\n[$now] Requested Gif with the following url: " . $url . "\n", 3, $this->log_path);

    $dom = new Dom;
    $dom->loadFromUrl($url);
    //$dom->loadFromFile("prova.html");

    $elements = $dom->find('.masonry_box'); 

    // error_log("\n[$now] .thumg-holder number of elements: " . count($elements) . "\n", 3, $this->log_path);

    if(count($elements) == 0)
        return ""; 

    $min = 0; 
    $max = count($elements); 

    $random_gif = random_int($min, $max); 

    // error_log("[$now] Random element index: " . $random_gif . "\n", 3, $this->log_path);

    $single_element = $elements[$random_gif]->find('a.image_wrapper');
    
    echo 'Random element: ' . $random_gif . "\n <br>"; 
    
    if(count($single_element) > 0){
        $href = $single_element[0]->getAttribute('href');

        // error_log("[$now] Final value: " . $value . "\n", 3, $this->log_path);
        echo "Href step 1: " . $href . "\n <br>";
        
        $newUrl = "https://it.sex.com" . $href;
        echo "New url: " . $newUrl . "\n <br>";

        $dom->loadFromUrl("https://it.sex.com" . $href);
        $elements = $dom->find('.image_frame'); 

        echo "Elementi da .image_frame: " . count($elements) . '<br>'; 

        $single_element = $elements[0]->find('img');

        echo "Elementi da single_element: " . count($single_element) . '<br>'; 

        $href = $single_element[0]->getAttribute('src');

        echo "src step 2: " . $href . "\n <br>";
        // return $value;
    }

    return ""; 