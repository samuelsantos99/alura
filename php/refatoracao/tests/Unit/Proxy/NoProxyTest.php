<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Unit\Proxy;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException;
use CViniciusSDias\GoogleCrawler\Proxy\NoProxy;
use CViniciusSDias\GoogleCrawler\Proxy\NoProxyAbstractFactory;
use PHPUnit\Framework\TestCase;

class NoProxyTest extends TestCase
{
    public function testUrlFromGoogleSuggestionMustThrowInvalidResultException()
    {
        $this->expectException(InvalidResultException::class);
        $noProxy = new NoProxyAbstractFactory();
        $invalidUrl = 'http://google.com/search?q=Test&num=100&ie=UTF-8&prmd=ivnsla&source=univ&tbm=nws&tbo=u&sa=X&ved=0ahUKEwiF5PS6w6vSAhWJqFQKHQ_wBDAQqAIIKw';
        $noProxy->createGoogleUrlParser()->parseUrl($invalidUrl);
    }

    public function testUrlMustBeCorrectlyParsed()
    {
        $noProxy = new NoProxyAbstractFactory();
        $validUrl = 'http://google.com//url?q=http://www.speedtest.net/pt/&sa=U&ved=0ahUKEwjYuPbkxqvSAhXFQZAKHdpyAxMQFggUMAA&usg=AFQjCNFR74JMZRVu3EUNUUHa7o_1ETZoiQ';
        $url = $noProxy->createGoogleUrlParser()->parseUrl($validUrl);
        static::assertEquals('http://www.speedtest.net/pt/', $url);
    }

    public function testTryingToGetHttpResponseFromInvalidUrlMustThrowException()
    {
        $this->expectException(InvalidUrlException::class);
        $noProxy = new NoProxyAbstractFactory();
        $noProxyHttpClient = $noProxy->createGoogleHttpClient();
        $noProxyHttpClient->getHttpResponse('teste');
    }
}
