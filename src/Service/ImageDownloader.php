<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImageDownloader
{
    private HttpClientInterface $httpClient;
    private string $saveDirectory;

    public function __construct(string $saveDirectory)
    {
        $this->httpClient = HttpClient::create();
        $this->saveDirectory = $saveDirectory;
    }

    /**
     * @param string $imageUrl
     * @param string|null $filename
     * @return string
     */
    public function downloadAndSaveImage(string $imageUrl, ?string $filename = null): string
    {
        try {
            $response = $this->httpClient->request('GET', $imageUrl);
            $imageContent = $response->getContent();

            if (!$filename) {
                $filename = uniqid('', true) . '.' . pathinfo($imageUrl, PATHINFO_EXTENSION);
            }

            if (!is_dir($this->saveDirectory)) {
                mkdir($this->saveDirectory, 0777, true);
            }

            $filePath = $this->saveDirectory . '/' . $filename;
            file_put_contents($filePath, $imageContent);

            return $filename;
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            throw new FileException('Failed to download the image: ' . $e->getMessage());
        }
    }
}