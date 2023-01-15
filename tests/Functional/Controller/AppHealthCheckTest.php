<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class AppHealthCheckTest extends WebTestCase
{
    public function test_app_request_is_successful_response(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/app-health-check');

        $this->assertResponseIsSuccessful();
        $jsonResponse = json_decode( $client->getResponse()->getContent(), true );
        $this->assertArrayHasKey('status', $jsonResponse);
        $this->assertEquals('ok', $jsonResponse['status']);
    }
}
