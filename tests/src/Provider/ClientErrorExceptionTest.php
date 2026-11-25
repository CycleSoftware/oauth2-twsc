<?php

namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\ClientErrorException;
use PHPUnit\Framework\TestCase;

class ClientErrorExceptionTest extends TestCase
{
    public function testDefaultsWhenDataIsEmpty()
    {
        $exception = new ClientErrorException([]);

        $this->assertSame('Unknown error', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame('Unknown error', $exception->getMessageNL());
        $this->assertNull($exception->getReason());
        $this->assertNull($exception->getPrevious());
    }

    public function testAllFieldsAreMapped()
    {
        $exception = new ClientErrorException([
            'message' => 'Not found',
            'code' => 404,
            'message_nl' => 'Niet gevonden',
            'reason' => 'repair_not_found',
        ]);

        $this->assertSame('Not found', $exception->getMessage());
        $this->assertSame(404, $exception->getCode());
        $this->assertSame('Niet gevonden', $exception->getMessageNL());
        $this->assertSame('repair_not_found', $exception->getReason());
        $this->assertSame('repair_not_found', $exception->reason);
        $this->assertSame('Niet gevonden', $exception->msg_nl);
    }

    public function testMessageNlFallsBackToMessage()
    {
        $exception = new ClientErrorException(['message' => 'Server error']);

        $this->assertSame('Server error', $exception->getMessageNL());
    }

    public function testIsThrowableAsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Boom');
        $this->expectExceptionCode(500);

        throw new ClientErrorException(['message' => 'Boom', 'code' => 500]);
    }
}
