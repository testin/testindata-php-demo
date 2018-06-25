<?php

include_once("classes/TestinSDK.php");

$sdk = new TestinSDK();

$sdk->setDefaultVars(array(
    "version" => "A"
));

$variables = $sdk->getVars(array(
    "layerId" => 290504
));

$sdk->track("baidusp_convert", 1);

echo file_get_contents($variables["version"] . ".html");