<?php

/**
 * Class TestinSDK
 */
class TestinSDK
{
    private $sdk_server = "http://127.0.0.1:8070";

    private $clientId;

    private $curl_timeout_ms = 200;

    private $curl_connection_timeout_ms = 200;

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
        if (array_key_exists("clientId", $cfg)) {
            $this->clientId = $cfg["clientId"];
        } else {
            $this->clientId = uniqid();
        }

        if (array_key_exists("sdk_server", $cfg)) {
            $this->sdk_server = $cfg["sdk_server"];
        }

        if (array_key_exists("curl_timeout_ms", $cfg)) {
            $this->curl_timeout_ms = $cfg["curl_timeout_ms"];
        }

        if (array_key_exists("curl_connection_timeout_ms", $cfg)) {
            $this->curl_connection_timeout_ms = $cfg["curl_connection_timeout_ms"];
        }

        if (array_key_exists("cookie_name", $cfg)) {
            $this->cookie_name = $cfg["cookie_name"];
        }

        if (array_key_exists("cookie_age", $cfg)) {
            $this->cookie_age = $cfg["cookie_age"];
        }

        if (array_key_exists($this->cookie_name, $_COOKIE)) {
            $this->clientId = $_COOKIE[$this->cookie_name];
        } else {
            # @todo cookie_domain
            setcookie($this->cookie_name, $this->clientId, time() + $this->cookie_age);
        }
    }


    /**
     * 设置默认变量，当网络出现异常或者实验未正常开启时生效
     *
     * @param $defaultVars
     */
    function setDefaultVars($defaultVars)
    {
        $this->defaultVars = $defaultVars;
    }

    /**
     * 封装 curl post JSON 数据的逻辑，不包含任何业务逻辑
     *
     * @param $url
     * @param $data
     *
     * @return resource
     */
    private function post($url, $data)
    {
        $params = json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params)
        ));

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $this->curl_timeout_ms);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->curl_connection_timeout_ms);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        return $ch;
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

        $ch = $this->post($get_variable_url, $post_data);

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
     * 打点数据
     *
     * @param $metric_name
     * @param int $metric_value
     */
    function track($metric_name, $metric_value = 1)
    {
        $track_url = $this->sdk_server . "/abtest/javasdk/abapi/track";

        $post_data = array(
            "clientID" => $this->clientId,
            "trackName" => $metric_name
        );

        $ch = $this->post($track_url, $post_data);

        $response = curl_exec($ch);

        if (false === $response) {
            $this->log(curl_error($ch));
        } else {
            $decodedResponse = json_decode($response, true);
            if (is_null($decodedResponse)) {
                $this->log("can't decode sdk server response");
            } else if ($decodedResponse && $decodedResponse["code"] != 0) {
                $this->log($decodedResponse["msg"]);
            }
        }
        curl_close($ch);

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