<?php

namespace App\Factory;

use FeedIo\Adapter\Http\Client as FeedIoHttpClient;
use FeedIo\FeedIo;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Psr18Client;

class FeedIoFactory
{
    public function __invoke(LoggerInterface $logger): FeedIo
    {
        return new FeedIo(new FeedIoHttpClient(new Psr18Client()), $logger);
    }
}
