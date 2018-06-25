<?php

include_once("classes/TestinSDK.php");

$sdk = new TestinSDK(array(
    "sdk_server" => "http://127.0.0.1:8070",
    "cookie_name" => "my_testin_id"
));

$sdk->setDefaultVars(array(
    "version" => "A"
));

$variables = $sdk->getVars(array(
    "layerId" => 290504
));

$sdk->track("baidusp_convert", 1);

echo file_get_contents($variables["version"] . ".html");