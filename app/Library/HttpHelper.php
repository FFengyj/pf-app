<?php

/**
 * HTTP请求类
 */

namespace App\Library;

/**
 * Class HttpHelper
 * @package App\Library
 * @author fyj
 */
class HttpHelper
{
    /**
     * 发送json请求数据
     *
     * @param $url
     * @param $send_data
     * @param array $headers
     * @param array $curl_options
     * @return mixed
     */
    public static function postJson($url, $send_data,$headers = [],$curl_options = [])
    {

        //数据处理
        $data = is_array($send_data) ? \json_encode($send_data) : $send_data;

        $headers = array_merge(
            [
                'Content-Type:  application/json; charset=UTF-8',
                'Content-Length: ' . strlen($data),
            ],$headers
        );

        $curl_options[CURLOPT_POST] = 1; //Post

        return self::request($url,$data,$headers,$curl_options);

    }

    /**
     * post 请求
     *
     * @param $url
     * @param array $send_data
     * @param array $headers
     * @param array $curl_options
     * @return mixed
     */
    public static function post($url, $send_data = [],$headers = [],$curl_options = [])
    {

        $curl_options[CURLOPT_POST] = 1;
        return self::request($url,$send_data,$headers,$curl_options);
    }


    /**
     * get 请求
     *
     * @param $url
     * @param array $send_data
     * @param array $headers
     * @param array $curl_options
     * @return bool|string
     */
    public static function get($url, $send_data = [],$headers = [],$curl_options = [])
    {
        if($send_data){
            $url  = $url . (strpos($url,"?") !== false ? "&" : "?") . http_build_query($send_data);
        }

        $curl_options[CURLOPT_HTTPGET]  = 1;
        return self::request($url,'',$headers,$curl_options);
    }



    private static function request($url, $send_data,$headers = [],$curl_options = [])
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);

        $default_options = [
            CURLOPT_FOLLOWLOCATION => 1,   //使用自动跳转
            CURLOPT_TIMEOUT        => 30,  //超时
            CURLOPT_RETURNTRANSFER => 1,   //获取的信息以文件流的形式返回
            CURLOPT_HEADER         => 0
        ];

        $curl_options = $curl_options + $default_options;
        curl_setopt_array($curl,$curl_options);

        if($send_data){
            curl_setopt($curl, CURLOPT_POSTFIELDS,$send_data);
        }

        $result = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        switch($http_status){
            case 404:
                throw new \Exception('Not Found',404);
                break;
        }

        $err_no = curl_errno($curl);
        $err_msg = curl_error($curl);

        curl_close($curl);

        if($err_no){
            throw new \Exception($err_msg,$err_no);
        }

        return $result;
    }

    /**
     * @param $url
     * @param $filename
     * @param int $timeout
     */
    public static function download($url,$filename,$timeout = 180)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $fp = fopen ($filename, 'w+');

        $options = [
            CURLOPT_FOLLOWLOCATION => 1,   //使用自动跳转
            CURLOPT_TIMEOUT        => $timeout,  //超时
            CURLOPT_HEADER         => 0,
            CURLOPT_NOBODY         => 0,
        ];

        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_setopt_array($curl,$options);

        curl_exec($curl);
        curl_close($curl);
        fclose($fp);

    }

}
