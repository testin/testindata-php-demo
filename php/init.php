<?php
$init_url="http://127.0.0.1:8070/abtest/javasdk/abapi/init";

$post_data = array ("appKey" => "TESTIN_jffc729f8-3191-453d-b4f6-1065a8c49978","cacheDirectory" => "/tmp/sdk-server");


$params = json_encode($post_data);

$ch = curl_init($init_url);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($params)
));

curl_setopt($ch, CURLOPT_URL, $init_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

print_r(curl_exec($ch));
curl_close($ch);
