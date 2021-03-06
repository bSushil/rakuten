<?php
namespace Rakuten\Clients;

use Rakuten\HttpClient;
/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

/**
 * Http Client that use curl extension
 *
 * @package RakutenRws
 * @subpackage HttpClient
 */
class CurlHttpClient extends HttpClient
{
    protected
        $curlOptions = array();

    public function __construct($options = array())
    {
        $this->curlOptions = $options;
    }

    protected function getHandler()
    {
        $ch = curl_init();

        curl_setopt_array($ch, $this->curlOptions);
        if ($this->proxy !== null) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }

        curl_setopt($ch, CURLOPT_USERAGENT, 'RakutenWebService SDK for PHP-'.\Rakuten\Client::VERSION);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);


        return $ch;
    }

    protected function makeResponse($url, $params, $curl)
    {
        $rawResponse = curl_exec($curl);

        if ($rawResponse === false) {
            $msg = curl_error($curl);
            throw new \Rakuten\Exception('http reqeust error: '.$msg);
        }

        $parts = preg_split('/((?:\\r?\\n){2})/', $rawResponse, -1, PREG_SPLIT_DELIM_CAPTURE);
        for ($i = count($parts) - 3; $i >= 0; $i -= 2) {
            if (preg_match('/^http\//i', $parts[$i])) {
                $rawHeaders = $parts[$i];
                $contents = implode('', array_slice($parts, $i+2));
                break;
            }
        }

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $headers = array();
        foreach (preg_split('/\r?\n/', $rawHeaders) as $header) {
            if (!$header) {
                continue;
            }

            $token = explode(' ', $header);
            if (1 === strpos($token[0], 'HTTP/')) {
                $headers = array();
            }

            $headers[] = $header;
        }

        return new \Rakuten\HttpResponse(
            $url,
            $params,
            $code,
            $headers,
            $contents
        );
    }

    public function getCurlOptions($options)
    {
        return $this->curlOptions;
    }

    public function setCurlOptions($options)
    {
        $this->curlOptions = $options;
    }

    public function get($url, $params = array())
    {
        $requestUrl  = $url;
        if (count($params)) {
            $requestUrl .= false === strpos($requestUrl, '?') ? '?' : '&';
            $requestUrl .= http_build_query($params);
        }

        $userAgent = "RakutenApiSdk/2.0.0 (". php_uname("s")." ".php_uname("r")."; PHP ". phpversion() . ")";
        $defaults = array(
            CURLOPT_HEADER => 1,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT => $userAgent,
            CURLOPT_URL=>$requestUrl
        );

        $ch = $this->getHandler();
        curl_setopt_array($ch, $defaults);
        //curl_setopt($ch, CURLOPT_URL, $requestUrl);

        return $this->makeResponse($url, $params, $ch);
    }

    public function post($url, $params = array())
    {
        $ch = $this->getHandler();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        return $this->makeResponse($url, $params, $ch);
    }
}
