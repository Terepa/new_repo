<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SymfonyDocs
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
        $url = 'http://api.icndb.com/jokes/random/3?limitTo=[nerdy]&escape=javascript';

        $response = $this->client->request('GET', $url);
        $parsedResponse = $response->toArray();

        return $parsedResponse['value'];
    }
}