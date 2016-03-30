<?php


namespace FunnelCms\Helpers;

use FunnelCms\Mail\MailerInterface;

class PaginationMailgun implements PaginationInterface
{
    private $app;
    private $mailer;
    private $page;
    private $totalPages;
    private $result;

    /**
     * Pagination constructor.
     *
     * @param $app
     * @param $mailer
     * @param $page
     */
    public function __construct($app, MailerInterface $mailer, $page) {
        $this->app = $app;
        $this->mailer = $mailer;
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

        $this->totalPages = ceil($this->mailer->recipientsCount() / $show);

        if ($this->page > $this->totalPages)
            $this->app->notFound();

        $offset = ($this->page - 1) * $show;


        $this->result = $this->mailer->getRecipients($show, $offset);
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
        return $this->result;
    }


}