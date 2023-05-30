<?php

namespace App\Library;

/**
 * Class JwtToken
 */
class JwtToken
{
    /**
     * @var string
     */
    protected static $alg = 'HS256';

    /**
     * @var array
     */
    protected static $algos = [
        'HS256' => 'sha256',
    ];

    /**
     * @param array $payload
     * @param string $key
     * @return string
     */
    public static function encode(array $payload, string $key)
    {
        $default = [
            'iss' => 'jwt',
            'iat' => time(),
        ];

        $header = self::base64UrlEncode(json_encode(['alg' => self::$alg, 'typ' => 'JWT'], JSON_UNESCAPED_UNICODE));
        $payload = self::base64UrlEncode(json_encode(array_merge($default, $payload)));
        $sign = self::signature($header . '.' . $payload, $key, self::$alg);

        return sprintf("%s.%s.%s", $header, $payload, $sign);
    }

    /**
     * @param string $token
     * @param string $key
     * @return bool|mixed
     */
    public static function decode(string $token, string $key)
    {
        if (strtolower(substr($token, 0, 7)) == 'bearer ') {
            $token = substr($token, 7);
        }

        $tokens = explode('.', $token);
        if (count($tokens) != 3) {
            return false;
        }

        $header = json_decode(self::base64UrlDecode($tokens[0]), true);
        if (!isset($header['alg']) || !isset(self::$algos[$header['alg']])) {
            return false;
        }

        if (self::signature($tokens[0] . '.' . $tokens[1], $key, $header['alg']) !== $tokens[2]) {
            return false;
        }

        return json_decode(self::base64UrlDecode($tokens[1]), true) ?: false;
    }

    /**
     * base64UrlEncode
     * @param string $input 需要编码的字符串
     * @return string
     */
    private static function base64UrlEncode(string $input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * base64UrlEncode
     * @param string $input 需要解码的字符串
     * @return bool|string
     */
    private static function base64UrlDecode(string $input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $addlen = 4 - $remainder;
            $input .= str_repeat('=', $addlen);
        }

        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * HMACSHA256签名
     *
     * @param string $input
     * @param string $key
     * @param string $alg
     * @return string|false
     */
    private static function signature(string $input, string $key, string $alg)
    {
        return self::base64UrlEncode(hash_hmac(self::$algos[$alg], $input, $key, true));
    }
}
