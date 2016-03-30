<?php


namespace FunnelCms\Mail;


use Mailgun\Mailgun;
use Mailgun\Connection\Exceptions\MissingEndpoint;
use Mailgun\Connection\Exceptions\MissingRequiredParameters;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class MailgunMailer implements MailerInterface
{
    /**
     * Contains the config set in the config file.
     *
     * @var
     */
    private $config;

    /**
     * Makes views accessible.
     *
     * @var
     */
    private $view;

    /**
     * Instance of the used mailer.
     *
     * @var
     */
    private $mailer;

    /**
     * Instance of the used mailer.
     *
     * @var
     */
    private $mailerValidate;

    /**
     * Create a mailer instance.
     * The mailer parameter as a instance of the mailer we are using.
     *
     * @param $config
     * @param $view
     * @param Mailgun $mailer
     * @param Mailgun $mailerValidate
     */
    public function __construct($config, $view, Mailgun $mailer, Mailgun $mailerValidate) {
        $this->config = $config;
        $this->view = $view;
        $this->mailer = $mailer;
        $this->mailerValidate = $mailerValidate;
    }

    /**
     * Send an email to the recipient.
     *
     * @param $template path to the template of the email
     * @param $data data for the template
     * @param $credentials to, from, subject and message
     * @return mixed
     */
    public function sendMessage($template, $data, $credentials) {
        $this->view->appendData($data);

        $this->mailer->sendMessage($this->config->get('mail.domain'), [
            'from' => $credentials['from'],
            'to' => $credentials['to'],
            'subject' => $credentials['subject'],
            'html' => $this->view->render($template),
        ]);
    }

    /**
     * Send an email to the recipient.
     *
     * @param $template path to the template of the email
     * @param $data data for the template
     * @param $credentials to, from, subject and message
     * @return mixed
     */
    public function sendNewsletter($template, $data, $credentials) {
        $this->view->appendData($data);

        $html = $this->view->render($template);
        $css = file_get_contents($this->config->get('app.assetUrl') . '/css/foundation.css');

        $cssToInlineStyles = new CssToInlineStyles($html, $css);

        $this->mailer->sendMessage($this->config->get('mail.domain'), [
            'from' => $this->config->get('mail.from.newsletter'),
            'to' => $credentials['to'],
            'subject' => $credentials['subject'],
            'html' => $cssToInlineStyles->convert(),
        ]);
    }

    /**
     * Returns the recipients of the list.
     *
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function getRecipients($limit, $offset) {
        return $this->mailer->get('lists/' . $this->config->get('mail.list') . '/members', [
            'limit' => $limit,
            'skip' => $offset,
        ])->http_response_body->items;
    }

    /**
     * Adds a recipient to the list.
     *
     * @param $recipient
     * @return mixed
     * @throws \Exception
     */
    public function addRecipient($recipient) {
        $this->validateRecipient($recipient);

        try {
            return $this->mailer->post('lists/' . $this->config->get('mail.list') . '/members', [
                'address' => $recipient,
                'subscribed' => true,
            ]);
        }
        catch (MissingRequiredParameters $e) {
            throw new \Exception('Het e-mailadres is al aanwezig in de lijst.');
        }
        catch (\Exception $e) {
            throw new \Exception('We konden je aanvraag niet verwerken. Neem contact op met de webmaster.');
        }
    }

    /**
     * Removes a recipient from the list.
     *
     * @param $recipient
     * @return mixed
     * @throws \Exception
     */
    public function deleteRecipient($recipient) {
        $this->validateRecipient($recipient);

        try {
            $this->mailer->delete('lists/' . $this->config->get('mail.list') . '/members/' . $recipient);
        }
        catch (MissingEndpoint $e) {
            throw new \Exception('Het e-mailadres is niet aanwezig in de lijst.');
        }
        catch (\Exception $e) {
            throw new \Exception('We konden je aanvraag niet verwerken. Neem contact op met de webmaster.');
        }

    }

    /**
     * Returns the number of recipients in the list.
     *
     * @return mixed
     */
    public function recipientsCount() {
        return $this->mailer->get('lists/' . $this->config->get('mail.list'))
            ->http_response_body
            ->list
            ->members_count;
    }

    /**
     * Validates the recipient.
     *
     * @param $recipient
     * @return mixed
     * @throws \Exception
     */
    public function validateRecipient($recipient) {
        $result = $this->mailerValidate->get('address/validate', ['address' => $recipient]);

        if ( ! $result->http_response_body->is_valid)
            throw new \Exception('Geen geldig e-mailadres.');
    }
}