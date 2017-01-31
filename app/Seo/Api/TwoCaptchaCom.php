<?php

namespace App\Seo\Api;

use Curl\Curl;
use App\Exceptions\SeoException;

class TwoCaptchaCom
{
    const API_IN_URL = 'http://2captcha.com/in.php';
    const API_RES_URL = 'http://2captcha.com/res.php';
    
    
    
    /**
     * @param string $base64
     * @param int $timeout
     * @return string
     */
    public static function solveFromBase64($base64, $timeout = 30)
    {
        $captchaId = self::sendImg($base64);
        
        return self::getSolved($captchaId, $timeout);
    }
    
    /**
     * @param string $base64
     * @throws SeoException
     * @return int
     */
    protected static function sendImg($base64)
    {
        $data = [
            'key' => env('TWO_CAPTCHA_COM_API_KEY'),
            'method' => 'base64',
            'body' => $base64,
        ];
        
        $curl = new Curl();
        
        $curl->setURL(self::API_IN_URL);
        $curl->setOpt(CURLOPT_CUSTOMREQUEST, 'POST');
        $curl->setOpt(CURLOPT_POST, true);
        $curl->setOpt(CURLOPT_POSTFIELDS, $curl->buildPostData($data));
        
        $curl->exec();
        
        if (is_array($response = self::parseResponse($curl))) {
            return $response[1];
        }
        
        throw new SeoException('2captcha.com: ' . $response);
    }
    
    /**
     * @param int $captchaId
     * @param int $timeout
     * @throws SeoException
     * @return string
     */
    protected static function getSolved($captchaId, $timeout)
    {
        $waitBetweenGets = 5;
        
        for ($i = 0; $i < $timeout; $i += $waitBetweenGets) {
            
            sleep($waitBetweenGets);
            
            $curl = new Curl();
            
            $curl->setURL(self::API_RES_URL . '?key=' . env('TWO_CAPTCHA_COM_API_KEY') . '&action=get&id=' . $captchaId);
            
            $curl->exec();
            
            if (is_array($response = self::parseResponse($curl))) {
                return $response[1];
            }
        }
        
        throw new SeoException('2captcha.com: ' . $response);
    }
    
    /**
     * @param Curl $curl
     * @return array|string
     */
    protected static function parseResponse(Curl $curl)
    {
        if (stripos($curl->response, 'ok|') === 0) {
            $response = explode('|', $curl->response);
            
            if (isset($response[1])) {
                return $response;
            }
        }
        
        return $curl->response;
    }
    
}
