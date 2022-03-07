<?php

namespace App\Kernel\Parser\Traits;

use App\Models\Driver;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Kernel\Parser\Exceptions\NotHttpOkException;
use voku\helper\HtmlDomParser;

trait RequestTrait
{

    private static $RESPONSE_CACHE = [];

    /**
     * create uri query
     * @param string $uri | ex : /test/query/....
     * @param array $data / [ value : key , ... ]
     *
     * @return array
     */
    public function URIGenerator(string $uri = "" , array $data = [])
    {
        ### base url
        $baseUri = trim($this->driver->base_uri_host, "/");

        ### uri path
        $uriPath = urldecode($uri);
        $uriPath = parse_url($uriPath, PHP_URL_PATH);
        $uriPath = trim($uriPath, "/");

        ### uri Query
        $uriQuery = parse_url($uri, PHP_URL_QUERY) ?? [];

        $uriQuery = array_merge($uriQuery, $data);
        $uriQuery = http_build_query($uriQuery);


        $uriQueryStr = !! $uriQuery ? sprintf("?%s" , $uriQuery ) : "" ;

        ###
        $completelyURI = sprintf("%s/%s%s", $baseUri, $uriPath, $uriQueryStr);
        $completelyURI_PATH = sprintf("%s%s", $uriPath, $uriQueryStr);

        return [
            $completelyURI,
            $completelyURI_PATH,
            $baseUri,
            $uriPath,
            $uriQuery
        ];
    }

    /**
     * return response and http request
     * @param string completelyUri
     * @return Response|null
     */
    private function existsInstance($completelyUri): null|Response
    {
        return
            isset(self::$RESPONSE_CACHE[$completelyUri]) ?
            self::$RESPONSE_CACHE[$completelyUri] :
            null ;
    }


    /**
     * http get request
     * @param string $completelyUri
     * @param array $uriQuery
     *
     * @return Response
     */
    public function get(string $completelyUri , array $uriQuery = [] , $raw = false ): Response|HtmlDomParser
    {
        $response = $this->existsInstance($completelyUri) ?? Http::get($completelyUri,$uriQuery);

        if (!$response->ok())
            throw new NotHttpOkException();

        return $raw ? $response : HtmlDomParser::str_get_html($response->body());
    }
}
