<?php

namespace Infrastructure\HttpClient;

use Tests\TestCase;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Mockery as m;

class AbstractHttpClientTest extends TestCase
{
    private $guzzleClientMock;
    private $clientMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->guzzleClientMock = m::mock(ClientInterface::class);
        $this->clientMock = new class($this->guzzleClientMock) extends \Core\Infrastructure\HttpClient\AbstractHttpClient {
            protected function getBaseUri(): string
            {
                return "http://example.com";
            }
        };
    }

    protected function tearDown(): void
    {
        m::close();
        parent::tearDown();
    }

    public static function httpMethodProvider()
    {
        return [
            ['get'],
            ['post'],
            ['put'],
            ['patch'],
            ['delete'],
            ['options'],
        ];
    }

    /**
     * @dataProvider httpMethodProvider
     */
    public function testHttpMethods($method)
    {
        $responseMock = new Response(200, [], json_encode(['success' => true]));

        $this->guzzleClientMock->shouldReceive('request')
            ->once()
            ->andReturn($responseMock);

        $response = $this->clientMock->{$method}('test');

        $this->assertEquals(200, $response['status']);
        $this->assertEquals(['success' => true], $response['body']);
    }

    public function testRequestHandlesGuzzleException()
    {
        $request = new \GuzzleHttp\Psr7\Request('GET', 'test');
        $response = new \GuzzleHttp\Psr7\Response(500);

        $exception = new \GuzzleHttp\Exception\RequestException("Error", $request, $response);

        $this->guzzleClientMock->shouldReceive('request')
            ->once()
            ->andThrow($exception);

        $response = $this->clientMock->get('test');

        $this->assertEquals(500, $response['status']);
        $this->assertEquals("Error", $response['error']);
    }
}
