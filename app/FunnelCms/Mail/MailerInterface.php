<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 30/03/2016
 * Time: 17:15
 */

namespace FunnelCms\Mail;


interface MailerInterface
{
    /**
     * Send an email to the recipient.
     *
     * @param $template path to the template of the email
     * @param $data data for the template
     * @param $credentials to, from, subject and message
     * @return mixed
     */
    public function sendMessage($template, $data, $credentials);

    /**
     * Send an email to the recipient.
     *
     * @param $template path to the template of the email
     * @param $data data for the template
     * @param $credentials to, from, subject and message
     * @return mixed
     */
    public function sendNewsletter($template, $data, $credentials);

    /**
     * Returns the recipients of the list.
     *
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function getRecipients($limit, $offset);

    /**
     * Adds a recipient to the list.
     *
     * @param $recipient
     * @return mixed
     */
    public function addRecipient($recipient);

    /**
     * Removes a recipient from the list.
     *
     * @param $recipient
     * @return mixed
     */
    public function deleteRecipient($recipient);

    /**
     * Returns the number of recipients in the list.
     *
     * @return mixed
     */
    public function recipientsCount();

    /**
     * Validates the recipient.
     *
     * @param $recipient
     * @return mixed
     */
    public function validateRecipient($recipient);
}