<?php

namespace App\Controller;

use App\Service\RssWordCounterService;
use FeedIo\Feed;
use FeedIo\FeedIo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    /**
     * @type FeedIo
     */
    private $feedIo;

    /**
     * @var RssWordCounterService
     */
    private $rssWordCounterService;

    public function __construct(FeedIo $feedIo, RssWordCounterService $rssWordCounterService)
    {
        $this->feedIo = $feedIo;
        $this->rssWordCounterService = $rssWordCounterService;
    }

    /**
     * @Route("/api/v1/feed", name="feed")
     */
    public function feedAction(): JsonResponse
    {
        $url = 'https://www.theregister.co.uk/software/headlines.atom';

        $feed = $this->feedIo->read($url, new Feed())->getFeed();

        $frequentWords = $this->rssWordCounterService->getFrequentWords($feed);

        return $this->json([
            'feed' => $feed,
            'frequentWords' => $frequentWords,
        ]);
    }
}
