<?php

namespace App\Tests;

use App\DataObject\ProductDataObject;
use App\Service\AlzaParser;
use App\Service\Factory\PantherClientFactory;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCase;

class AlzaParserTest extends PantherTestCase
{
    public function testParseProduct(): void
    {
        $client = self::createPantherClient([
            'browser_arguments' => [
                '--headless=new',
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--disable-blink-features=AutomationControlled',
                '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                '--lang=en-US,en;q=0.9',
                '--disable-web-security',
                '--disable-popup-blocking',
                '--disable-infobars',
                '--remote-debugging-port=9222',
                '--user-data-dir='.sys_get_temp_dir().'/chrome_profile_'.uniqid(),
            ]
        ]);

        $mockClientFactory = $this->createMock(PantherClientFactory::class);
        $mockClientFactory->method('createClient')->willReturn($client);

        $parser = new AlzaParser($mockClientFactory);

        $result = $parser->parseProduct('https://www.alza.cz/EN/macbook-pro-14-m4-pro-sk-2024-space-black-d12663046.htm');

        $this->assertInstanceOf(ProductDataObject::class, $result);
        $this->assertEquals('MacBook Pro 14" M4 PRO SK 2024 Space Black', $result->getName());
    }
}