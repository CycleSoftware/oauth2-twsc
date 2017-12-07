<?php

namespace League\OAuth2\Client\Provider;


class ClientErrorException extends \Exception
{
    public $reason;
    public $msg_nl;

    public function __construct(array $data)
    {
        if (!isset($data['message'])) {
            $data['message'] = 'Unknown error';
        }
        if (!isset($data['code'])) {
            $data['code'] = 0;
        }
        if (!isset($data['message_nl'])) {
            $data['message_nl'] = $data['message'];
        }
        if (!isset($data['reason'])) {
            $data['reason'] = null;
        }
        parent::__construct($data['message'], $data['code'], null);
        $this->reason = $data['reason'];
        $this->msg_nl = $data['message_nl'];
    }

    /**
     * Returns reason of ClientErrorException if available
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Returns message in NL if available
     * @return string|null
     */
    public function getMessageNL()
    {
        return $this->msg_nl;
    }
}
