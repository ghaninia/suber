<?php

namespace App\Kernel\Parser\Classes;

use App\Kernel\Parser\Interfaces\DriverModelInterface;

abstract class DriverAbstract
{

    protected DriverModelInterface $driver;

    abstract public function getTheLatestPages(): int;

    abstract public function getNextPaginatorLinks(): array;

    abstract public function DOMcurrentPageAndGetLinks(): array;

    /**
     * Update the number of pagination links
     * @return void
     */
    public function reloadPaginator()
    {
        $this->driver->update([
            "current_count_pages" => $this->getTheLatestPages()
        ]);
    }

    /**
     * Update pagination list
     * @return void
     */
    public function reloadNextPaginatorLinks()
    {

        [$prev, $current, $next] = $this->getNextPaginatorLinks();

        $this->driver->update([
            "current_page_link" => $current,
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

            $this->driver->links()
                ->updateOrCreate([
                    "url" => $url
                ]);

        });

        $this->reloadNextPaginatorLinks();
    }
}
