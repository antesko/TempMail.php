<?php

/**
 * Created by: Antesko <https://github.com/antesko>
 * Date: 21.6.2016.
 */
class TempMail {

    private $md5address;
    // Format is set to private because of trouble with repetitive calls to temp-mail server
    private $format = 'json';

    public $name;
    public $domain;
    public $address;


    public function __construct ($name = null, $domain = null) {
        // If name is not provided, generate a random one
        $this->name = $name ? $name : generateRandomString();

        $domains = json_decode(self::getDomains());

        // If domain is not provided, or not valid, pick random one
        if (!$domain || !in_array($domain, $domains))
            $this->domain = $domains[ rand(0, count($domains) - 1) ];
        else
            $this->domain = $domain;

        // Create the email address
        $this->address = $this->name . $this->domain;

        // Create MD5 hash of the address
        $this->md5address = md5($this->address);
    }

    /**
     * Gets all emails for this mailbox
     * If $raw is false, function returns an array of objects. If $raw is 'raw',
     * it returns raw json result from the Temp Mail API
     * @param bool|string $raw
     * @return array
     */
    public function getEmails ($raw = false) {

        $emails = file_get_contents('http://api.temp-mail.ru/request/mail/id/' . $this->md5address . '/format/json');

        // Email list empty
        if (empty($emails))
            return json_encode(['message' => 'email list is empty']);

        return $raw == 'raw' ? $emails : json_decode($emails);
    }

    /**
     * Gets all source messages for this mailbox
     * If $raw is false, function returns an array of objects. If $raw is 'raw',
     * it returns raw json result from the Temp Mail API
     * @param bool|string $raw
     * @return array
     */
    public function getSources ($raw = false) {
        $sources = file_get_contents('http://api.temp-mail.ru/request/source/id/' . $this->md5address . '/format/json');

        // Sources list empty
        if (empty($sources))
            return json_encode(['message' => 'source list is empty']);

        return $raw == 'raw' ? $sources : json_decode($sources);
    }

    /**
     * Deletes a message by it's ID
     * @param string $messageID
     * @return string
     */
    public function deleteMessage ($messageID) {
        return file_get_contents('http://api.temp-mail.ru/request/delete/id/' . $messageID . '/format/' . $this->format);
    }

    /**
     * Gets the list of available email domains
     * @param string $format
     * @return array
     */
    public static function getDomains ($format = 'json') {
        $domains = file_get_contents('http://api.temp-mail.ru/request/domains/format/' . $format);

        return $domains ? $domains : json_encode(['message' => 'domains list is empty']);
    }
}

/**
 * HELPER FUNCTIONS
 */

/**
 * Generates random string
 * @param int $length
 * @return string
 */
function generateRandomString ($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[ rand(0, $charactersLength - 1) ];
    }

    return $randomString;
}