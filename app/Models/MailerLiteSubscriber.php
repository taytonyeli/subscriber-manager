<?php

namespace App\Models;

class MailerLiteSubscriber
{
    public $id;
    public $email;
    public $fields;

    /**
     * create a subscriber
     *
     * @param string $email subscriber email
     * @param string $name subscriber name
     * @param string $country subscriber country
     * @return void
     **/
    public function __construct($email, $name, $country)
    {
        $this->email = $email;
        $this->fields = new MailerLiteSubscriberFields($name, $country);
    }

    /**
     * save subscriber in MailerLite
     *
     * @return array
     **/
    public function getAsArrayForAPI()
    {
        $data = (array) $this;
        $data["fields"] = (array) $data["fields"];
        return $data;
    }
}

class MailerLiteSubscriberFields
{
    public $name;
    public $country;

    /**
     * create subscriber's fields
     *
     * @param string $name subscriber name
     * @param string $country subscriber country
     * @return void
     **/
    public function __construct($name, $country)
    {
        $this->name = $name;
        $this->country = $country;
    }
}
