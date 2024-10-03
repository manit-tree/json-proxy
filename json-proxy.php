<?php
try {    
    $url = $_GET['url'];

    if (is_null($_GET['url'])) {
        throw new Exception('Bad URL');
    }


    $ch = curl_init();
    $timeout = 7; // set to zero for no timeout
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $content = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    if ($info['http_code'] >= 400) {
        throw new Exception('Bad error code (' . $info['http_code'] . ')');
    }

    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');

    echo $content;    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
    exit(1);
}