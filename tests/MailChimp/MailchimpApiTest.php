<?php

namespace App\Tests\MailChimp;

use App\Service\MailchimpApiClientFactory;
use PHPUnit\Framework\TestCase;

class MailchimpApiTest extends TestCase
{
    public function testExtractKeyAndServerValid(): void
    {
        $fullKey = "521sdf7f6ad5c80e0bba2b60rf02d-us12";
        $mailchimpApiClientFactory = new MailchimpApiClientFactory();

        $keyAndServer = $mailchimpApiClientFactory::extractKeyAndServer($fullKey);

        $this->assertSame(2, count($keyAndServer));
        $this->assertSame('521sdf7f6ad5c80e0bba2b60rf02d', $keyAndServer['key']);
        $this->assertSame('us12', $keyAndServer['server']);
    }
}
