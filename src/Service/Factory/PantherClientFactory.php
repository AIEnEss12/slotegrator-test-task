<?php

namespace App\Service\Factory;

use Symfony\Component\Panther\Client;

class PantherClientFactory
{
    public function createClient(): Client
    {
        $tempDir = sys_get_temp_dir().'/chrome_profile_'.uniqid();

        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        chmod($tempDir, 0777);

        return Client::createChromeClient(
            null,
            [
                '--headless=new',
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--disable-blink-features=AutomationControlled',
                '--user-agent='. $this->getRandomUserAgent(),
                '--lang=en-US,en;q=0.9',
                '--disable-web-security',
                '--disable-popup-blocking',
                '--disable-infobars',
                '--remote-debugging-port=9222',
                '--user-data-dir='.$tempDir,
            ],
            [],
            'http://127.0.0.1:9080'
        );
    }

    private function getRandomUserAgent(): string
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15',
            'Mozilla/5.0 (X11; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/115.0'
        ];

        return $agents[array_rand($agents)];
    }
}