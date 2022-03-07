<?php

namespace App\Kernel\Parser\Classes;

use App\Models\Link;
use App\Models\Post;
use App\Models\Driver;
use Illuminate\Http\Client\Response;
use App\Kernel\Parser\Traits\RequestTrait;
use Carbon\Carbon;

abstract class FetchAbstract
{
    use RequestTrait;

    protected Driver $driver; ### required for trait

    public function __construct(protected Link $link)
    {
        $this->driver = $link->driver;
    }

    /**
     * fetch page link
     *
     * @return Response
     */
    public function fetch(): Response
    {
        [$uri] = $this->URIGenerator($this->link->url);
        return $this->get($uri);
    }

    abstract public function name(): string;

    abstract public function imdb(): ?string;

    abstract public function productionYear(): int;

    abstract public function subtitles(): array;

    abstract public function thumbnail(Post $post): void;

    public function save()
    {

        $post = $this->link->post()->create([
            "name" => $name = $this->name(),
            "imdb" => $this->imdb(),
            "production_year" => $productionYear = $this->productionYear(),
        ]);

        $this->link->update([
            "is_visited" => TRUE,
            "visited_date" => Carbon::now()
        ]);

        $this->thumbnail($post);
        $this->subtitles($post);
    }
}
