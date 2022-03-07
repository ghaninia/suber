<?php

namespace App\Kernel\Parser\Drivers\WorldSubtitle;

use App\Models\Post;
use App\Kernel\UploadCenter\SubtitleFile;
use App\Kernel\Parser\Classes\FetchSinglePageAbstract;
use App\Kernel\Services\Subtitle\SubtitleService;

class FetchSinglePageWorldSubtitle extends FetchSinglePageAbstract
{

    /**
     * Get imdb link from source site
     *
     * @return string
     */
    public function imdb(): string
    {
        $href =
            $this->fetch()
            ->findOne('.single-info .sub-row-6 a[title="IMDB"]')
            ->getAttribute("href");

        $href = urldecode($href);
        $href = trim($href);
        $href = strtolower($href);

        return $href;
    }

    /**
     *
     * @param Post $post
     * @return void
     */
    public function subtitles(Post $post): void
    {

        $subtitles =
            $this->fetch()
            ->find(".single-box-body ul li");

        foreach ($subtitles as $subtitle) {
            $subtitleLink = $subtitle->findOne(".new-link-3 a")->getAttribute("href");
            (new SubtitleService)->create($post, $subtitleLink);
        }
    }
}
