<?php

$get_variable_url="http://127.0.0.1:8070/abtest/javasdk/abapi/getVariables";

$userid = uniqid();

if( $_COOKIE["userid"] ){
   $userid = $_COOKIE["userid"];
}else{
   setcookie("userid",$userid,time()+86400);
}

$post_data = array (
    "clientID" => $userid,
    "layerID" => "290504",
    "customLables" => array(
        "name" => "a"
    )
);

$params = json_encode($post_data);

$ch = curl_init($get_variable_url);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($params)
));

curl_setopt($ch, CURLOPT_URL, $get_variable_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

$res= json_decode(curl_exec($ch),true);
curl_close($ch);

echo file_get_contents($res["data"]["version"].".html");