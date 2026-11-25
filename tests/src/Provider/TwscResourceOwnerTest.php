<?php

namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Provider\TwscResourceOwner;
use PHPUnit\Framework\TestCase;

class TwscResourceOwnerTest extends TestCase
{
    public function testImplementsResourceOwnerInterface()
    {
        $this->assertInstanceOf(ResourceOwnerInterface::class, new TwscResourceOwner([]));
    }

    public function testGettersReturnResponseValues()
    {
        $response = [
            'id' => 1234,
            'email' => 'john.smith@e.mail',
            'firstname' => 'John',
            'lastname' => 'Smith',
            'extra' => 'value',
        ];
        $owner = new TwscResourceOwner($response);

        $this->assertSame(1234, $owner->getId());
        $this->assertSame('john.smith@e.mail', $owner->getEmail());
        $this->assertSame('John', $owner->getFirstName());
        $this->assertSame('Smith', $owner->getLastName());
        $this->assertSame($response, $owner->toArray());
    }

    public function testGettersReturnNullForEmptyValues()
    {
        $owner = new TwscResourceOwner([
            'id' => 0,
            'email' => '',
            'firstname' => '',
            'lastname' => null,
        ]);

        $this->assertNull($owner->getId());
        $this->assertNull($owner->getEmail());
        $this->assertNull($owner->getFirstName());
        $this->assertNull($owner->getLastName());
    }
}
