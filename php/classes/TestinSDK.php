<?php

class TestinSDK
{

    private $sdk_server = "http://127.0.0.1:8070";

    private $clientId;

    private $cookie_name = "userid";

    private $cookie_age = 86400;

    private $defaultVars = array();

    /**
     * TestinSDK constructor.
     *
     * @param array $cfg
     */
    public function __construct(array $cfg = array())
    {
        $this->clientId = uniqid();

        if (array_key_exists("sdk_server", $cfg)) {
            $this->sdk_server = $cfg["sdk_server"];
        }

        if (array_key_exists($this->cookie_name, $_COOKIE)) {
            $this->clientId = $_COOKIE[$this->cookie_name];
        } else {
            # @todo cookie_domain
            setcookie($this->cookie_name, $this->clientId, time() + $this->cookie_age);
        }
    }


    /**
     * 设置默认的变量
     *
     * @param $defaultVars
     */
    function setDefaultVars($defaultVars)
    {
        $this->defaultVars = $defaultVars;
    }


    /**
     * 获取实验变量
     *
     * @param array $options
     * @return array|mixed
     */
    function getVars(array $options = array())
    {
        $get_variable_url = $this->sdk_server . "/abtest/javasdk/abapi/getVariables";

        $post_data = array(
            "clientID" => $this->clientId,
            # @todo remove layerId
            "layerID" => $options["layerId"]
        );

        $params = json_encode($post_data);

        $ch = curl_init();

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

        $response = curl_exec($ch);
        $result_to_return = $this->defaultVars;

        if (false === $response) {
            $this->log(curl_error($ch));
        } else {
            $decodedResponse = json_decode($response, true);
            if (is_null($decodedResponse)) {
                $this->log("can't decode sdk server response");
            } else if ($decodedResponse && $decodedResponse["code"] != 0) {
                $this->log($decodedResponse["msg"]);
            } else {
                $result_to_return = array_merge($result_to_return, $decodedResponse["data"]);
            }
        }
        curl_close($ch);

        return $result_to_return;
    }

    /**
     * 日志
     *
     * @param string $msg
     */
    function log($msg = "")
    {
        error_log($msg);
    }
}