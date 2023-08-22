<?php

namespace App\Controller;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly HttpClientInterface $client,
        private readonly ProductRepository $repository
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/products', name: 'products', methods: 'POST')]
    public function promotions()
    {
        $response = $this->client->request(
            'POST',
            'https://51.83.236.141:15000/api/v2/items.items',
            [


                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'GEmAGPsdz6Rgad9SE2qesg'
                ],

                'json' => [
//                    'filter' => ['code' => '003'],
                    'request' => ['compuid' => '53f98a26-041ecdf6-4cf71dcd-0474b2b3-b7c42fd6'],
                ],

        ]);

        $content = $response->toArray();

        $productsFromApi = array_map(
            static fn (array $record) => array_intersect_key($record, array_flip(['price', 'uuid', 'code'])),
            $content['result']['records'] ?? []
        );

        $products = $this->repository->findAll();

        foreach ($products as $product) {
            foreach ($productsFromApi as $index => $value) {
                if ($value['uuid'] === $product->getUuid()) {
                    unset($productsFromApi[$index]);
                }
            }
        }

        foreach ($productsFromApi as $record) {
            if ((float)$record['price'] >= 1) {
                $product = Product::fromResult($record);
                $this->entityManager->persist($product);
            }
        }

        $this->entityManager->flush();

        return new Response('Success save in DB',200, ['Content-Type' => 'application/json']);
    }
}