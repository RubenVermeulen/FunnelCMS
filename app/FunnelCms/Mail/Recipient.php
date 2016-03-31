<?php


namespace FunnelCms\Mail;


class Recipient
{
    private $address;
    private $name;
    private $subscribed;

    /**
     * Recipient constructor.
     *
     * @param $email
     * @param $name
     * @param $subscribed
     */
    public function __construct($email, $name, $subscribed) {
        $this->address = $email;
        $this->name = $name;
        $this->subscribed = $subscribed;
    }

    /**
     * @return mixed
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSubscribed() {
        return $this->subscribed;
    }

    /**
     * @param mixed $subscribed
     * @throws \Exception
     */
    public function setSubscribed($subscribed) {
        if ( ! is_bool($subscribed))
            throw new \Exception('The parameter "subscribed" has to a boolean.');

        $this->subscribed = $subscribed;
    }
}