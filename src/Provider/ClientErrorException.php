<?php
namespace League\OAuth2\Client\Provider;


class ClientErrorException extends \Exception
{
    public $reason;
    public $msg_nl;

    public function __construct(array $data)
    {
        parent::__construct($data['message'], $data['code'], null);
        $this->reason = $data['reason'];
        $this->msg_nl = $data['message_nl'];
    }
}
