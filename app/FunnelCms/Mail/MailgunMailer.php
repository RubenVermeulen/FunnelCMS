<?php


namespace FunnelCms\Mail;

use Mailgun\Mailgun;
use Mailgun\Connection\Exceptions\MissingEndpoint;
use Mailgun\Connection\Exceptions\MissingRequiredParameters;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * REMARK
 * When trying to set the subscribed key in the array do not use true or false.
 * It does not always work, instead use 1,0 or on,off.
 *
 * Class MailgunMailer
 * @package FunnelCms\Mail
 */

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
     * Address of the mailing list.
     *
     * @var
     */
    private $listAddress;

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

        $this->listAddress = $this->config->get('mail.list');
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
            'to' => $this->listAddress,
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
        return $this->mailer->get('lists/' . $this->listAddress . '/members', [
            'limit' => $limit,
            'skip' => $offset,
        ])->http_response_body->items;
    }

    /**
     * Returns the recipient.
     *
     * @param $address
     * @return Recipient
     * @throws \Exception
     */
    public function getRecipient($address) {
        $this->validateRecipient($address);

        try {
            $result = $this->mailer->get('lists/' . $this->listAddress . '/members/' . $address)
                ->http_response_body
                ->member;

            return new Recipient($result->address, $result->name, $result->subscribed);
        }
        catch (MissingEndpoint $e) {
            throw new \Exception('De ontvanger "' . $address . '" is niet aanwezig in de lijst.');
        }
        catch (\Exception $e) {
            throw new \Exception('We konden je aanvraag niet verwerken. Neem contact op met de webmaster.');
        }
    }

    /**
     * Updates a recipient.
     *
     * @param Recipient $recipient
     * @return mixed
     * @throws \Exception
     */
    public function updateRecipient(Recipient $recipient) {
        $this->validateRecipient($recipient->getAddress());

        try {
            $result = $this->mailer->put('lists/' . $this->listAddress . '/members/' . $recipient->getAddress(), [
                'subscribed' => ($recipient->getSubscribed() ? 1 : 0), // if statement is necessary because false does not work for some reason
                'name' => $recipient->getName(),
            ]);

            var_dump($result);
        }
        catch (MissingEndpoint $e) {
            throw new \Exception('De ontvanger "' . $recipient->getAddress() . '" is niet aanwezig in de lijst.');
        }
        catch (\Exception $e) {
            throw new \Exception('We konden je aanvraag niet verwerken. Neem contact op met de webmaster.');
        }
    }

    /**
     * Adds a recipient to the list.
     *
     * @param $address
     * @return mixed
     * @throws \Exception
     */
    public function addRecipient($address) {
        $this->validateRecipient($address);

        try {
            $this->mailer->post('lists/' . $this->listAddress . '/members', [
                'address' => $address,
                'subscribed' => 1,
            ]);
        }
        catch (MissingRequiredParameters $e) {
            throw new \Exception('De ontvanger "' . $address . '" is al aanwezig in de lijst.');
        }
        catch (\Exception $e) {
            throw new \Exception('We konden je aanvraag niet verwerken. Neem contact op met de webmaster.');
        }
    }

    /**
     * Removes a recipient from the list.
     *
     * @param $address
     * @return mixed
     * @throws \Exception
     */
    public function deleteRecipient($address) {
        $this->validateRecipient($address);

        try {
            $this->mailer->delete('lists/' . $this->listAddress . '/members/' . $address);
        }
        catch (MissingEndpoint $e) {
            throw new \Exception('De ontvanger "' . $address . '" is niet aanwezig in de lijst.');
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
        return $this->mailer->get('lists/' . $this->listAddress)
            ->http_response_body
            ->list
            ->members_count;
    }

    /**
     * Validates the recipient.
     *
     * @param $address
     * @return mixed
     * @throws \Exception
     */
    public function validateRecipient($address) {
        $result = $this->mailerValidate->get('address/validate', ['address' => $address]);

        if ( ! $result->http_response_body->is_valid)
            throw new \Exception('Geen geldig e-mailadres.');
    }
}