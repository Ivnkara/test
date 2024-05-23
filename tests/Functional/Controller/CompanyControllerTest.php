<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpFoundation\Response;

class CompanyControllerTest extends WebTestCase
{
    private static $client;

    public static function setUpBeforeClass(): void
    {
        self::$client = static::createClient();

        self::getContainer()->get('doctrine')->getManager()->getConnection()->executeQuery('TRUNCATE TABLE company;');
        self::getContainer()->set('cache.app', new ArrayAdapter());
    }

    public function testIndex(): void
    {
        self::$client->request('GET', '/api/v1/company');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
    }

    public function testNew(): void
    {
        self::$client->request('POST', '/api/v1/company/new', [], [], [], json_encode([
            'name' => 'Test Company',
            'inn' => '123123123123',
            'address' => 'address company',
        ]));

        $this->assertEquals(Response::HTTP_CREATED, self::$client->getResponse()->getStatusCode());
    }

    public function testShow(): void
    {
        self::$client->request('GET', '/api/v1/company/1');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
    }

    public function testEdit(): void
    {
        self::$client->request('PUT', '/api/v1/company/1/edit', [], [], [], json_encode([
            'name' => 'Test new Company',
            'inn' => '123123123777',
            'address' => 'address new company',
        ]));

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
    }

    public function testDelete(): void
    {
        self::$client->request('DELETE', '/api/v1/company/1');

        $this->assertEquals(Response::HTTP_NO_CONTENT, self::$client->getResponse()->getStatusCode());
    }
}
