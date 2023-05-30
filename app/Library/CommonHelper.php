<?php

/**
 * 通用函数帮助类
 */

namespace App\Library;

use Phalcon\Crypt;

/**
 * Class CommonHelper
 * @package App\Library
 * @author fyj
 */
class CommonHelper
{

    /**
     * 获取随机字符串，默认20位
     *
     * @param int $length
     * @param bool $symbols
     * @return string
     */
    public static function getRandstr($length = 20, $symbols = true)
    {
        $strings = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($symbols) {
            $strings .= '!@#$%^&*()-=';
        }

        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= $strings[mt_rand(0, strlen($strings) - 1)];
        }

        return $random;
    }

    /**
     * 调用类的方法，自动判断是否静态方法
     *
     * @param $class
     * @param $method
     * @param $arguments
     * @return false|mixed
     * @throws \ReflectionException
     */
    public static function callMethod($class, $method, $arguments)
    {
        $obj = new \ReflectionMethod($class, $method);
        $is_static = $obj->isStatic();
        if ($is_static) {
            return forward_static_call_array([$class, $method], $arguments);
        } else {
            if (!is_object($class)) {
                $class = new $class;
            }
            return call_user_func_array([$class, $method], $arguments);
        }
    }

    /**
     * 生成token
     *
     * @param array $origin
     * @param string $key
     * @return string
     */
    public static function encryptToken($origin, $key)
    {
        $crypt = new Crypt();
        $token = @$crypt->encryptBase64(json_encode($origin), $key);

        return $token;
    }

    /**
     * 解开token
     *
     * @param  $token
     * @param  $key
     * @return mixed
     */
    public static function decryptToken($token, $key)
    {
        $res = null;
        try {
            $crypt = new Crypt();
            $res = json_decode(@$crypt->decryptBase64($token, $key), true);
        } catch (\Exception $e) {
            $res = null;
        }

        return $res;
    }

    /**
     * 获取毫秒时间戳
     */
    public static function getMillisecond()
    {
        [$microsec, $sec] = explode(' ', microtime());

        return (float)sprintf('%.0f', ((float)$microsec + (float)$sec) * 1000);
    }


    /**
     * @param $xml
     * @return mixed
     */
    public static function xmlToArray($xml)
    {
        return json_decode(json_encode(@simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * @param $arr
     * @return string
     */
    public static function arrayToXml($arr)
    {
        $xml = '';
        foreach ($arr as $k => $v) {
            $xml .= sprintf('<%s><![CDATA[%s]]></%s>', $k, $v, $k);
        }

        return '<xml>' . $xml . '</xml>';
    }

    /**
     * @param $n
     * @return string
     */
    public static function intToAlphaBaseN($n)
    {

        $base = ['t', 'n', 'q', 'k',6, 'e', 'w', 'v', 'p', 'i', 2, 'z', 'g', 8, 'c', 'b', 4, 'a', 1, 'm', 'r', 7, 3, 10, 5, 'x', 'f',  9, 'y', 's', 'd', 'u', 'j', 'h',];
        $l=count($base);
        $s = '';
        for ($i = 1; $n >= 0 && $i < 10; $i++) {
            $s =  $base[($n % pow($l, $i) / pow($l, $i - 1))].$s;
            $n -= pow($l, $i);
        }
        return $s;
    }

    /**
     * @param $ip
     * @return bool
     */
    public static function isInternalIp($ip)
    {
        return in_array(substr($ip, 0, strpos($ip, '.')), ['127', '10', '172', '192']);
    }
}
