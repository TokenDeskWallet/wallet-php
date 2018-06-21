<?php
namespace TokenDesk;

class TokenDesk
{
    public static $base_path = 'https://wallet.tokendesk.io';

    public static $auth_token = 'YOUR_AUTH_TOKEN';

    public static $project_url = '/api/v1/project';
    public static $place_order_url = '/api/v1/order';
    public static $calculator_url = '/api/v1/purchase-calculator';
    public static $payment_check_url = '/api/v1/order/get-status';


    public static function config($authentication)
    {
        if (isset($authentication['auth_token'])) {
            self::$auth_token = $authentication['auth_token'];
        }
    }


    public static function getProject($project_id){

        $params = array(
            'projectId' => $project_id
        );

        $response = self::request(self::$base_path.self::$project_url, 'GET', $params);

        if(isset($response)){
            return $response;
        }else{
            // error no response
        }
    }

    public static function createOrder($params = array()){

        $response = self::request(self::$base_path.self::$place_order_url, 'POST', $params);

        if(isset($response)){
            return $response;
        }else{
            // error no order created
        }
    }

    public static function getOrderStatus($params = array()){

        $response = self::request(self::$base_path.self::$payment_check_url, 'GET', $params);

        if(isset($response)){
            return $response;
        }else{
            // error no order created
        }
    }

    public static function purchaseCalculator($params){

        $response = self::request(self::$base_path.self::$calculator_url, 'GET', $params);

        if(isset($response)){
            return $response;
        }else{
            // error no order created
        }
    }

    private static function request($url, $method = 'POST', $params = array())
    {
        if (empty(self::$auth_token)) {
            // error auth token
        }

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer " . self::$auth_token."\r\n".
                    "Accept: application/json\r\n",
                'method'  => $method,
            ),
        );

        if($method=='POST'){
            $options["http"]["content"] = http_build_query($params);

        }else if($method=='GET'){
            $url = $url.'?'.http_build_query($params);
        }

        $context = stream_context_create($options);
        $result = file_get_contents($url, FALSE, $context);

        return json_decode($result);
    }


}