<?php


namespace FunnelCms\Helpers;


class Pagination implements PaginationInterface
{
    private $app;
    private $items;
    private $page;
    private $totalPages;

    /**
     * Pagination constructor.
     *
     * @param $app
     * @param $items
     * @param $page
     */
    public function __construct($app, $items, $page) {
        $this->app = $app;
        $this->items = $items;
        $this->page = $page;
    }

    /**
     * Checks if all attributes are correct and saves the result.
     * The result can be fetches through the getters.
     */
    public function execute() {
        $show = $this->app->config->get('app.pagination.items');

        // Checks if it is a natural numerical.
        // We do this first because otherwise it
        // could be possible that would contact the
        // database for nothing.
        if ( ! $this->page || ! ctype_digit((string) $this->page))
            $this->app->notFound();

        $totalItems = $this->items->count();

        if ($totalItems == 0) {
            $this->items = [];
        }
        else {
            $this->totalPages = ceil($totalItems / $show);

            if ($this->page > $this->totalPages)
                $this->app->notFound();

            $offset = ($this->page - 1) * $show;

            $this->items = $this->items->limit($show)->offset($offset)->get();
        }
    }

    /**
     * Gets total pages.
     *
     * @return mixed
     */
    public function getTotalPages() {
        return $this->totalPages;
    }

    /**
     * Gets items.
     *
     * @return mixed
     */
    public function getResult() {
        return $this->items;
    }
}