<?php
/**
 * @author Andrea Corriga
 * Set webhooks
 * If you want delete webhooks set url => null
 */
include('config/config.php');

$method = 'setWebhook';
$parameters = array('url' => $config['executeUrl']);
$url = $config['apiUrl'] . $method. '?' . http_build_query($parameters);
$handle = curl_init($url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($handle, CURLOPT_TIMEOUT, 60);
$result = curl_exec($handle);
print_r($result);