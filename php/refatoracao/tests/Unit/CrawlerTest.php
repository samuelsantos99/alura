<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Unit;

use CViniciusSDias\GoogleCrawler\Crawler;
use CViniciusSDias\GoogleCrawler\Exception\InvalidGoogleHtmlException;
use CViniciusSDias\GoogleCrawler\SearchTerm;
use CViniciusSDias\GoogleCrawler\SearchTermInterface;
use CViniciusSDias\GoogleCrawler\Proxy\GoogleProxyAbstractFactory;
use CViniciusSDias\GoogleCrawler\Proxy\HttpClient\GoogleHttpClient;
use CViniciusSDias\GoogleCrawler\Proxy\NoProxyAbstractFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CrawlerTest extends TestCase
{
    public function testTryingTGetResultsWithHttpOnGoogleDomainMustFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $domain = 'https://google.com';
        $crawler = new Crawler(new NoProxyAbstractFactory());
        $crawler->getResults(new SearchTerm(''), $domain);
    }

    public function testTryingToInstantiateACrawlerWithoutGoogleOnTheDomainMustFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $crawler = new Crawler(new NoProxyAbstractFactory());
        $searchTerm = new SearchTerm('Teste');
        $crawler->getResults($searchTerm, 'invalid-domain');
    }

    public function testTryingToParseInvalidHtmlMustThrowException()
    {
        $this->expectException(InvalidGoogleHtmlException::class);
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('__toString')
            ->willReturn('<html><head></head><body>Invalid HTML</body></html>');

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn($streamMock);

        $googleHttpClient = $this->createMock(GoogleHttpClient::class);
        $googleHttpClient->method('getHttpResponse')
            ->willReturn($responseMock);
        $searchTermMock = $this->createMock(SearchTermInterface::class);
        $searchTermMock
            ->method('__toString')
            ->willReturn('');

        $factory = $this->createStub(GoogleProxyAbstractFactory::class);
        $factory->method('createGoogleHttpClient')
            ->willReturn($googleHttpClient);

        $crawler = new Crawler($factory);
        $crawler->getResults($searchTermMock);
    }
}
