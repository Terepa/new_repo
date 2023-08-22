<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChuckNorrisJokeHelper
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function getRandomJokes(): array
    {
        $url = 'https://51.83.236.141:15000/api/v2/items.items';

        $response = $this->client->request('POST', $url);
        $parsedResponse = $response->toArray();


        return [
            'id' => $parsedResponse['id'],
            'name' => $parsedResponse['name']
        ];
    }
}