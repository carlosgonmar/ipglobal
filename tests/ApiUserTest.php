<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Tests\Generator\UrlGeneratorTest;

class ApiUserTest extends WebTestCase
{
    protected $router;

    public function testPostIndex(): void
    {

        $client = static::createClient();
        $client->request('GET', $this->getContainer()->get('router')->generate('api_users_index'));
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertCount(2, $responseData);
        // Check the first level of response
        $this->assertArrayHasKey('status', $responseData);
        $this->assertEquals($responseData['status'], 'success');
        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        foreach ($responseData['data'] as $post) {
            $this->assertArrayHasKey('id', $post);
            $this->assertIsInt($post['id']);
            $this->assertArrayHasKey('name', $post);
            $this->assertIsString($post['name']);
            $this->assertArrayHasKey('username', $post);
            $this->assertIsString($post['username']);
            $this->assertArrayHasKey('email', $post);
            $this->assertIsString($post['email']);
            $this->assertArrayHasKey('phone', $post);
            $this->assertIsString($post['phone']);
            $this->assertArrayHasKey('website', $post);
            $this->assertIsString($post['website']);
        }

    }

    public function testPostShowSuccess(): void
    {


        $client = static::createClient();
        $client->request('GET', $this->getContainer()->get('router')->generate('api_users_show', ['id' => 1]));
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertCount(2, $responseData);
        // Check the first level of response
        $this->assertArrayHasKey('status', $responseData);
        $this->assertEquals($responseData['status'], 'success');
        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        // Check the second level of response
        $this->assertArrayHasKey('id', $responseData['data']);
        $this->assertIsInt($responseData['data']['id']);
        $this->assertArrayHasKey('name', $responseData['data']);
        $this->assertIsString($responseData['data']['name']);
        $this->assertArrayHasKey('username', $responseData['data']);
        $this->assertIsString($responseData['data']['username']);
        $this->assertArrayHasKey('email', $responseData['data']);
        $this->assertIsString($responseData['data']['email']);
        $this->assertArrayHasKey('phone', $responseData['data']);
        $this->assertIsString($responseData['data']['phone']);
        $this->assertArrayHasKey('website', $responseData['data']);
        $this->assertIsString($responseData['data']['website']);

    }

    public function testPostShowNotFound(): void
    {

        $client = static::createClient();
        $client->request('GET', $this->getContainer()->get('router')->generate('api_users_show', ['id' => 9999999]));
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(["status" => "error", "error" => "Item not found"],
            $responseData
        );

    }

}
