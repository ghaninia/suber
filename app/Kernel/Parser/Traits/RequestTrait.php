<?php

namespace App\Kernel\Parser\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Kernel\Parser\Exceptions\NotHttpOkException;

trait RequestTrait
{

    private static $_response = [];

    private function response($url, $data): Response
    {

        $url = urldecode($url);

        $httpQuery = parse_url($url, PHP_URL_QUERY) ?? [];

        $scheme = parse_url($url , PHP_URL_SCHEME) ;
        $host = parse_url($url ,PHP_URL_HOST);
        $path = parse_url($url , PHP_URL_PATH ) ;
        $path = trim($path , "/") ;

        $url = sprintf("%s://%s" ,
            $scheme , implode("/" , [$host , $path ])
        );

        $data = array_merge($httpQuery, $data);

        return
            isset(self::$_response[$url]) ?
            self::$_response[$url] :
            self::$_response[$url] = Http::get($url, $data);

    }


    public function get($url, $data = []) : Response
    {

        $response = $this->response($url, $data);

        if (!$response->ok())
            throw new NotHttpOkException();

        return $response;
    }
}
