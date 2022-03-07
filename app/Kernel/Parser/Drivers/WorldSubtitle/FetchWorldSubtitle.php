<?php

namespace App\Kernel\Parser\Drivers\WorldSubtitle;

use App\Models\Post;
use voku\helper\HtmlDomParser;
use App\Kernel\Parser\Classes\FetchAbstract;

class FetchWorldSubtitle extends FetchAbstract
{

    public function imdb(): string
    {
        $text =
            HtmlDomParser::str_get_html(
                $this->fetch()->body()
            )
            ->findOne('.single-info .sub-row-6 a[title="IMDB"]')
            ->getAttribute("href");

        $text = urldecode($text);
        $text = trim($text);
        $text = strtolower($text);

        return $text;
    }


    public function subtitles(Post $post): void
    {
    }

}
