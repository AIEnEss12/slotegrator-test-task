<?php

namespace App\Service;

use App\DataObject\ProductDataObject;
use App\Service\Factory\PantherClientFactory;
use Symfony\Component\Panther\Client;

class AlzaParser
{
    private Client $client;

    public function __construct(
        private PantherClientFactory $clientFactory
    ) {
        $this->client = $this->clientFactory->createClient();
    }

    public function parseProduct(string $url): ProductDataObject
    {
        try {
            $this->client->request('GET', $url);

            $this->client->waitFor('.price-box');
            $this->client->getMouse()->mouseMoveTo(
                '.price-box',
                rand(-10, 10),
                rand(-10, 10)
            );

            usleep(random_int(500000, 2000000));

            $scrollAmount = rand(100, 500);
            $this->client->executeScript('window.scrollBy(0, '.$scrollAmount.')');

            usleep(random_int(1000000, 3000000));

            $crawler = $this->client->getCrawler();
            $name = $crawler->filter('h1')->text();

            $description = $crawler->filter('div#detailText span')->text();

            $price = $crawler->filter('.price-box__price')->text();
            $price = preg_replace('/[^\d.,]/', '', $price);
            $price = (float) str_replace(',', '.', $price);

            $imageSrc = $crawler->filter('div.galleryComponent img')->first()->attr('src');

            $parsedUrl = parse_url($imageSrc);
            $imageSrc = isset($parsedUrl['scheme'])
                ? $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path']
                : $imageSrc;

            return new ProductDataObject($name, $price, $imageSrc, $description);
        } catch (\Exception $e) {
            throw $e;
        } finally {
            if (isset($this->client)) {
                $this->client->quit();
            }
        }
    }
}
