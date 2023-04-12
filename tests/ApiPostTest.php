<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Tests\Generator\UrlGeneratorTest;

class ApiPostTest extends WebTestCase
{
    protected $router;

    public function testPostIndex(): void
    {

        $client = static::createClient();
        $client->request('GET', $this->getContainer()->get('router')->generate('api_posts_index'));
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
            $this->assertArrayHasKey('title', $post);
            $this->assertIsString($post['title']);
            $this->assertArrayHasKey('body', $post);
            $this->assertIsString($post['body']);
        }

    }

    public function testPostShowSuccess(): void
    {


        $client = static::createClient();
        $client->request('GET', $this->getContainer()->get('router')->generate('api_posts_show', ['id' => 1]));
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
        $this->assertArrayHasKey('title', $responseData['data']);
        $this->assertIsString($responseData['data']['title']);
        $this->assertArrayHasKey('body', $responseData['data']);
        $this->assertIsString($responseData['data']['body']);
        $this->assertArrayHasKey('user', $responseData['data']);
        $this->assertIsArray($responseData['data']['user']);
        // Check the third level of response
        $this->assertArrayHasKey('id', $responseData['data']['user']);
        $this->assertIsInt($responseData['data']['user']['id']);
        $this->assertArrayHasKey('name', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['name']);
        $this->assertArrayHasKey('username', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['username']);
        $this->assertArrayHasKey('email', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['email']);
        $this->assertArrayHasKey('phone', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['phone']);
        $this->assertArrayHasKey('website', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['website']);

    }

    public function testPostShowNotFound(): void
    {

        $client = static::createClient();
        $client->request('GET', $this->getContainer()->get('router')->generate('api_posts_show', ['id' => 9999999]));
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(["status" => "error", "error" => "Item not found"],
            $responseData
        );

    }


    public function testPostStoreSuccess(): void
    {

        $client = static::createClient();
        $client->request('POST', $this->getContainer()->get('router')->generate('api_posts_index'), [
            'title' => 'Test title',
            'body' => 'Test body',
            'userId' => 1
        ]);
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
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
        $this->assertArrayHasKey('title', $responseData['data']);
        $this->assertIsString($responseData['data']['title']);
        $this->assertArrayHasKey('body', $responseData['data']);
        $this->assertIsString($responseData['data']['body']);
        $this->assertArrayHasKey('user', $responseData['data']);
        $this->assertIsArray($responseData['data']['user']);
        // Check the third level of response
        $this->assertArrayHasKey('id', $responseData['data']['user']);
        $this->assertIsInt($responseData['data']['user']['id']);
        $this->assertArrayHasKey('name', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['name']);
        $this->assertArrayHasKey('username', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['username']);
        $this->assertArrayHasKey('email', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['email']);
        $this->assertArrayHasKey('phone', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['phone']);
        $this->assertArrayHasKey('website', $responseData['data']['user']);
        $this->assertIsString($responseData['data']['user']['website']);

    }

    public function testPostStoreWrongUser(): void
    {

        $userId = 9999999;
        $client = static::createClient();
        $client->request('POST', $this->getContainer()->get('router')->generate('api_posts_store'), [
            'title' => 'Lorem ipsum dolor sit amet',
            'body' => 'Suspendisse velit libero, maximus eget lacus nec, facilisis iaculis turpis. Nam laoreet vestibulum velit, et ultrices nunc sagittis sit amet. Vivamus vitae bibendum nulla. Donec id nunc venenatis ligula semper lacinia nec at metus. Integer venenatis ultricies quam ut semper. Fusce venenatis, ligula ac facilisis venenatis, nisl tortor finibus massa, eu eleifend neque lectus vitae felis. Proin eu elementum metus. Sed quam neque, maximus ac nisl vitae, molestie vehicula enim. Aenean fermentum vel erat in pretium. In justo quam, tempor at tristique vitae, fermentum ut sapien. Etiam vestibulum elit sit amet risus vestibulum, nec euismod felis tincidunt. Vestibulum tempor elit nisl, auctor facilisis metus facilisis id. Aenean et tincidunt lectus. Maecenas sodales odio diam, a aliquam mauris feugiat ut. Donec ut nulla quis eros cursus condimentum quis quis diam. Aliquam augue diam, venenatis id sapien dapibus, porttitor mattis massa.',
            'userId' => $userId
        ]);
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(
            [
                "status" => "fail",
                "error" => [
                    "userId" => [
                        "The user \"".$userId."\" does not exist."
                    ]
                ]
            ],
            $responseData
        );
    }

    public function testPostStoreEmptyTitle(): void
    {

        $client = static::createClient();
        $client->request('POST', $this->getContainer()->get('router')->generate('api_posts_store'), [
            'title' => '',
            'body' => 'Suspendisse velit libero, maximus eget lacus nec, facilisis iaculis turpis. Nam laoreet vestibulum velit, et ultrices nunc sagittis sit amet. Vivamus vitae bibendum nulla. Donec id nunc venenatis ligula semper lacinia nec at metus. Integer venenatis ultricies quam ut semper. Fusce venenatis, ligula ac facilisis venenatis, nisl tortor finibus massa, eu eleifend neque lectus vitae felis. Proin eu elementum metus. Sed quam neque, maximus ac nisl vitae, molestie vehicula enim. Aenean fermentum vel erat in pretium. In justo quam, tempor at tristique vitae, fermentum ut sapien. Etiam vestibulum elit sit amet risus vestibulum, nec euismod felis tincidunt. Vestibulum tempor elit nisl, auctor facilisis metus facilisis id. Aenean et tincidunt lectus. Maecenas sodales odio diam, a aliquam mauris feugiat ut. Donec ut nulla quis eros cursus condimentum quis quis diam. Aliquam augue diam, venenatis id sapien dapibus, porttitor mattis massa.',
            'userId' => 1
        ]);
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(
            [
                "status" => "fail",
                "error" => [
                    "title" => [
                        "This value is too short. It should have 3 characters or more."
                    ]
                ]
            ],
            $responseData
        );
    }

    public function testPostStoreLongTitle(): void
    {

        $client = static::createClient();
        $client->request('POST', $this->getContainer()->get('router')->generate('api_posts_store'), [
            'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut gravida urna ac odio cursus, nec finibus ex semper. Vestibulum malesuada vestibulum tellus non iaculis. Donec tellus magna, faucibus eu rhoncus sit amet, iaculis at lectus. Duis sollicitudin justo nec magna tempor, nec semper ex sodales. Duis quis ante ante. Nullam nec maximus risus. Cras laoreet mi vel rhoncus malesuada. Suspendisse convallis, mi quis fringilla sollicitudin, sapien diam sodales ipsum, vitae posuere augue nulla suscipit enim. Quisque sit amet vulputate justo. Duis iaculis arcu mauris, vel volutpat ante pharetra sed. Nulla eu neque eros. Etiam laoreet mauris sit amet tortor sagittis, sed rutrum eros pellentesque. Nulla eget nisl felis. Sed consectetur cursus mattis.',
            'body' => 'Suspendisse velit libero, maximus eget lacus nec, facilisis iaculis turpis. Nam laoreet vestibulum velit, et ultrices nunc sagittis sit amet. Vivamus vitae bibendum nulla. Donec id nunc venenatis ligula semper lacinia nec at metus. Integer venenatis ultricies quam ut semper. Fusce venenatis, ligula ac facilisis venenatis, nisl tortor finibus massa, eu eleifend neque lectus vitae felis. Proin eu elementum metus. Sed quam neque, maximus ac nisl vitae, molestie vehicula enim. Aenean fermentum vel erat in pretium. In justo quam, tempor at tristique vitae, fermentum ut sapien. Etiam vestibulum elit sit amet risus vestibulum, nec euismod felis tincidunt. Vestibulum tempor elit nisl, auctor facilisis metus facilisis id. Aenean et tincidunt lectus. Maecenas sodales odio diam, a aliquam mauris feugiat ut. Donec ut nulla quis eros cursus condimentum quis quis diam. Aliquam augue diam, venenatis id sapien dapibus, porttitor mattis massa.',
            'userId' => 1
        ]);
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(
            [
                "status" => "fail",
                "error" => [
                    "title" => [
                        "This value is too long. It should have 255 characters or less."
                    ]
                ]
            ],
            $responseData
        );
    }

    public function testPostStoreEmptyBody(): void
    {

        $client = static::createClient();
        $client->request('POST', $this->getContainer()->get('router')->generate('api_posts_store'), [
            'title' => 'Lorem ipsum dolor sit amet',
            'body' => '',
            'userId' => 1
        ]);
        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(
            [
                "status" => "fail",
                "error" => [
                    "body" => [
                        "This value is too short. It should have 3 characters or more."
                    ]
                ]
            ],
            $responseData
        );
    }


}
