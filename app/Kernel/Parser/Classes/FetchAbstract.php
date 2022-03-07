<?php

namespace App\Kernel\Parser\Classes;

use Carbon\Carbon;
use App\Models\Link;
use App\Models\Post;
use App\Models\Driver;
use voku\helper\HtmlDomParser;
use Illuminate\Http\Client\Response;
use App\Kernel\UploadCenter\PostFile;
use App\Kernel\Parser\Traits\RequestTrait;

abstract class FetchAbstract
{
    use RequestTrait;

    protected Driver $driver;

    public function __construct(protected Link $link)
    {
        $this->driver = $link->driver;
    }

    /**
     * fetch page link
     * @return Response
     */
    public function fetch(): Response
    {
        [$uri] = $this->URIGenerator($this->link->url);
        return $this->get($uri);
    }

    /**
     * Get imdb link from source site
     * @return string|null
     */
    abstract public function imdb(): ?string;

    /**
     * Download subtitles and save them
     * @param Post $post
     * @return void
     */
    abstract public function subtitles(Post $post): void;

    /**
     * Fetch the whole page of imdb site by link
     *
     * @param string $imdb
     * @return string
     *
     */
    private function fetchImdb(string $imdbUri): string
    {
        return file_get_contents($imdbUri);
    }

    /**
     * Get the name of the movie or series from the imdb site
     * @param HtmlDomParser $imdbDOM
     *
     * @return string
     */
    public function name(HtmlDomParser $imdbDOM): string
    {
        return $imdbDOM
            ->findOne('h1[data-testid="hero-title-block__title"]')
            ->innertext();
    }

    /**
     * Get the year of product production from imdb site
     * @param HtmlDomParser $imdbDOM
     *
     * @return int
     */
    public function productionYear(HtmlDomParser $imdbDOM): int
    {
        return (int) $imdbDOM
            ->findOne('ul[data-testid="hero-title-block__metadata"] a.ipc-link.ipc-link--baseAlt')
            ->innertext();
    }


    /**
     * Post index image related to the post from the imdb site
     * @param Post $post
     * @param HtmlDomParser $imdbDOM
     *
     * @return void
     */
    public function thumbnail(Post $post , HtmlDomParser $imdbDOM): void
    {
        $imageSrc =
            $imdbDOM
            ->findOne('img.ipc-image')
            ->getAttribute("src");

        $ext = pathinfo($imageSrc, PATHINFO_EXTENSION);
        $name = sprintf("%s.%s", $post->name, $ext);

        (new PostFile($post->production_year, $post->name))
            ->setFile(file_get_contents($imageSrc))
            ->setFileable($post)
            ->setOriginalName($name)
            ->append()
            ->upload();

    }

    /**
     *  Create a new post and add related information
     *  @return Post|bool
     */
    public function save() : Post|bool
    {

        $imdbUri = $this->imdb();

        if (is_null($imdbUri)) return false ;

        $imdbDOM = HtmlDomParser::str_get_html($this->fetchImdb($imdbUri));

        $post = $this->link->post()->create([
            "imdb" => $this->imdb(),
            "name" => $this->name($imdbDOM),
            "production_year" => $this->productionYear($imdbDOM),
        ]);

        $this->link->update([
            "is_visited" => TRUE,
            "visited_date" => Carbon::now()
        ]);

        $this->thumbnail($post , $imdbDOM);
        $this->subtitles($post);

        return $post ;
    }
}
