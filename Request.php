<?php

namespace esia;


/**
 * Class Request
 * @package esia
 */
class Request
{
    /**
     * Url for calling request
     *
     * @var
     */
    public $url;

    /**
     * Token for "Authorization" header
     *
     * @var
     */
    public $token;

    /**
     * @param $url
     * @param $token
     */
    function __construct($url, $token)
    {
        $this->url = $url;
        $this->token = $token;
    }

    /**
     * Call given method and return json decoded response
     *
     * if $withScheme equals false:
     * ````
     *     $request->url = 'https://esia-portal1.test.gosuslugi.ru/';
     *     $response = $request->call('/aas/oauth2/te');
     * ````
     * It will call https://esia-portal1.test.gosuslugi.ru/aas/oauth2/te
     *
     * if $withScheme equals true:
     * ````
     *     $request->call(https://esia-portal1.test.gosuslugi.ru/aas/oauth2/te, true);
     * ````
     * * It will call also https://esia-portal1.test.gosuslugi.ru/aas/oauth2/te
     *
     * @param string $method url
     * @param bool $withScheme if we need request with scheme
     * @return mixed
     */
    public function call($method, $withScheme = false)
    {

        $ch = $this->prepareAuthCurl();

        $url = $withScheme ? $method : $this->url . $method;
        curl_setopt($ch, CURLOPT_URL, $url);

        return json_decode(curl_exec($ch));
    }

    /**
     * Prepare curl resource with "Authorization" header
     *
     * @return resource
     */
    protected function prepareAuthCurl()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->token]);

        return $ch;
    }


}