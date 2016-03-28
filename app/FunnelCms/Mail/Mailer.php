<?php

namespace FunnelCms\Mail;

use \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Mailer 
{
    /**
     * Contains the config set in the config file.
     *
     * @var
     */
    protected $config;

    /**
     * Makes views accessible.
     *
     * @var
     */
    protected $view;

    /**
     * Instance of the used mailer.
     *
     * @var
     */
    protected $mailer;

    /**
     * Create a mailer instance.
     * The mailer parameter as a instance of the mailer we are using.
     *
     * @param $view
     * @param $mailer
     */
    public function __construct($config, $view, $mailer) {
        $this->config = $config;
        $this->view = $view;
        $this->mailer = $mailer;
    }

    /**
     * Send the email.
     *
     * @param $template
     * @param $data
     * @param $callback
     */
    public function send($template, $data, $credentials = []) {
        /*
         * Send data to view.
         */
        $this->view->appendData($data);

        /*
         * Send the email.
         */
        $this->mailer->sendMessage($this->config->get('mail.domain'), [
            'from' => $this->config->get('mail.from.noreply'),
            'to' => $credentials['to'],
            'subject' => $credentials['subject'],
            'html' => $this->view->render($template),
        ]);
    }

    /**
     * Sends newsletter.
     *
     * @param $template
     * @param $data
     * @param array $credentials
     * @throws \TijsVerkoyen\CssToInlineStyles\Exception
     */
    public function sendNewsletter($template, $data, $credentials = []) {

        $html = $this->view->render($template, $data);
        $css = file_get_contents('https://www.fleeshuttle.be/admin/newsletter/foundation.css');

        $cssToInlineStyles = new CssToInlineStyles($html, $css);

        $this->mailer->sendMessage($this->config->get('mail.domain'), [
            'from' => $this->config->get('mail.from.newsletter'),
            'to' => $credentials['to'],
            'subject' => $credentials['subject'],
            'html' => $cssToInlineStyles->convert(),
        ]);
    }
}