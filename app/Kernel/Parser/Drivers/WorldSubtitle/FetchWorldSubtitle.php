<?php

namespace App\Kernel\Parser\Drivers\WorldSubtitle;


use App\Models\Post;
use voku\helper\HtmlDomParser;
use App\Kernel\UploadCenter\PostFile;
use App\Kernel\Parser\Classes\FetchAbstract;

class FetchWorldSubtitle extends FetchAbstract
{

    public function name(): string
    {

        // دانلود زیرنویس فارسی فیلم Blacklight 2022
        $text =
            HtmlDomParser::str_get_html(
                $this->fetch()->body()
            )
            ->findOne(".titel-box a")
            ->innertext();

        $text = str_replace("دانلود زیرنویس فارسی فیلم", "", $text);
        $text = preg_replace(config("system.pattern.year"), "", $text);

        return trim($text);
    }

    public function imdb(): ?string
    {
        $text =
            HtmlDomParser::str_get_html(
                $this->fetch()->body()
            )
            ->findOne(".single-info-titel a[title=IMDB]")
            ->getAttribute("href");

        $text = urldecode($text);
        $text = trim($text);
        $text = strtolower($text);
        return $text;
    }

    public function productionYear(): int
    {
        $text =
            HtmlDomParser::str_get_html(
                $this->fetch()->body()
            )
            ->findOne(".titel-box a")
            ->innertext();

        $text = preg_match(config("system.pattern.year"), $text, $year);

        return intval(@last($year));
    }

    public function subtitles(): array
    {
        return [];
    }

    public function thumbnail(Post $post): void
    {
        $attachment =
            HtmlDomParser::str_get_html(
                $this->fetch()->body()
            )
            ->findOne(".single-tmp noscript img")
            ->getAttribute("src");

        dispatch(function () use ($post, $attachment) {
            (new PostFile($post->production_year, $post->name))
                ->setFile(file_get_contents($attachment))
                ->setFileable($post)
                ->setOriginalName(basename($attachment))
                ->append()
                ->upload();
        });
    }
}
