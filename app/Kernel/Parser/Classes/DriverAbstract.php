<?php

namespace App\Kernel\Parser\Classes;

use App\Kernel\Parser\Traits\RequestTrait;
use App\Kernel\Parser\Interfaces\DriverModelInterface;
use App\Models\Link;

abstract class DriverAbstract
{

    use RequestTrait;

    public function __construct(protected DriverModelInterface $driver)
    {
    }

    /**
     * Get the last page in the URL
     * @return int
     */
    abstract public function getTheLatestPages(): int;

    /**
     * Get the current page and Next in the current location
     * @return array
     */
    abstract public function getNextPaginatorLinks(): array;

    /**
     * List of links on the current page
     * @return array
     */
    abstract public function DOMcurrentPageAndGetLinks(): array;

    /**
     * Update the number of pagination links
     * If the number of pages is increased, the cursor is pulled back
     * @return void
     */
    public function reloadPaginator()
    {

        $latestCountPages = $this->driver->latest_count_pages;
        $latestCountPagesOnServer = $this->getTheLatestPages();

        if (is_null($latestCountPages))
            return $this->driver->update([
                "latest_count_pages" => $latestCountPagesOnServer,
            ]);

        $latestCountPages > $latestCountPagesOnServer ?:
            $this->driver->update([
                "latest_count_pages" => $latestCountPagesOnServer,
                "next_page_link" => $this->driver->base_url,
            ]);
    }

    /**
     * Update pagination list
     * @return void
     */
    public function reloadNextPaginatorLinks()
    {

        [$prev, $next] = $this->getNextPaginatorLinks();

        $this->driver->update([
            "previous_page_link" => $prev,
            "next_page_link" => $next,
        ]);
    }

    /**
     * Storing addresses in the database
     *
     * @return void
     */
    public function links()
    {
        $links = $this->DOMcurrentPageAndGetLinks();

        array_walk($links, function ($url) {

            Link::updateOrCreate([
                "driver_id" => $this->driver->id ,
                "url" => $url
            ]);
        });

        $this->reloadNextPaginatorLinks();
    }

    /**
     *
     * @return string
     */
    public function url(): string
    {
        $nextLink = $this->driver->next_page_link;

        return $nextLink ?? die();
    }
}
