<?php

namespace Core\Infrastructure\HttpClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

abstract class AbstractHttpClient
{
    public function __construct(private ClientInterface $client)
    {
    }

    abstract protected function getBaseUri(): string;

    public function get(string $uri, array $options = []): array
    {
        return $this->request('GET', $uri, $options);
    }

    public function post(string $uri, array $options = []): array
    {
        return $this->request('POST', $uri, $options);
    }

    public function put(string $uri, array $options = []): array
    {
        return $this->request('PUT', $uri, $options);
    }

    public function patch(string $uri, array $options = []): array
    {
        return $this->request('PATCH', $uri, $options);
    }

    public function delete(string $uri, array $options = []): array
    {
        return $this->request('DELETE', $uri, $options);
    }

    public function options(string $uri, array $options = []): array
    {
        return $this->request('OPTIONS', $uri, $options);
    }

    private function request(string $method, string $uri, array $options): array
    {
        try {
            $fullUri = $this->getBaseUri() . $uri;

            $response = $this->client->request($method, $fullUri, $options);

            return [
                'status' => $response->getStatusCode(),
                'headers' => $response->getHeaders(),
                'body' => json_decode($response->getBody()->getContents(), true),
            ];
        } catch (GuzzleException $e) {
            return [
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }
    }

}
