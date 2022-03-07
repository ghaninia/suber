<?php

namespace App\Kernel\Parser\Drivers\WorldSubtitle;

use App\Models\Link;
use voku\helper\HtmlDomParser;
use App\Kernel\Parser\Classes\FetchAbstract;
use App\Kernel\Parser\Classes\DriverAbstract;
use App\Kernel\Parser\Exceptions\ElementValueNotFoundException;

class WorldSubtitle extends DriverAbstract
{

    /**
     * Get the last page in the URL
     * @return int
     */
    public function getTheLatestPages(): int
    {

        [$uri] = $this->URIGenerator($this->driver->start_page_link) ;

        $response = $this->get($uri);

        $href =
            HtmlDomParser::str_get_html(
                $response->body()
            )
            ->findOne(".wp-pagenavi a.last")
            ->getAttribute("href");

        $href = trim($href, "/");
        preg_match('/[0-9]*$/', $href, $matchs);
        $match = last($matchs);

        return empty($match) ? (throw new ElementValueNotFoundException()) : $match;
    }


    /**
     * Get the current page and Next in the current location
     * @return array
     */
    public function getNextPaginatorLinks(): array
    {

        $response = $this->get($url = $this->url());

        $instance = HtmlDomParser::str_get_html($response->body());

        $nextPageURI = $instance->findOne(".wp-pagenavi .current+a.page")->getAttribute("href") ;

        return [
            $url ,
            empty($nextPageURI) ? null : $nextPageURI ,
        ] ;
    }


    /**
     * List of links on the current page
     * @return array
     */
    public function DOMcurrentPageAndGetLinks(): array
    {

        $response = $this->get($this->url());

        $elements =
            HtmlDomParser::str_get_html(
                $response->body()
            )
            ->find(".mybody .cat-post .cat-post-bt a") ;

        $links = [] ;

        foreach($elements as $element) {
            $links[] = $element->getAttribute("href") ;
        }

        return $links ;
    }


    /**
     * fetch all information on link
     * @param Link $link
     *
     * @return FetchAbstract
     */
    public function fetch(Link $link) : FetchAbstract
    {
        return (new FetchWorldSubtitle($link)) ;
    }

}
