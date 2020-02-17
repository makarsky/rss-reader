<?php

namespace App\Controller;

use App\Service\RssWordCounterService;
use FeedIo\Feed;
use FeedIo\FeedIo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FeedController
 * @package App\Controller
 */
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

    /**
     * @var string
     */
    private $feedUrl;

    /**
     * FeedController constructor.
     * @param FeedIo $feedIo
     * @param RssWordCounterService $rssWordCounterService
     * @param string $feedUrl
     */
    public function __construct(FeedIo $feedIo, RssWordCounterService $rssWordCounterService, string $feedUrl)
    {
        $this->feedIo = $feedIo;
        $this->rssWordCounterService = $rssWordCounterService;
        $this->feedUrl = $feedUrl;
    }

    /**
     * @Route("/api/v1/feed", name="feed")
     */
    public function feedAction(): JsonResponse
    {
        // TODO: add other feeds from https://www.theregister.co.uk/Design/page/feeds.html

        $feed = $this->feedIo->read($this->feedUrl, new Feed())->getFeed();

        $frequentWords = $this->rssWordCounterService->getFrequentWords($feed);

        return $this->json([
            'feed' => $feed,
            'frequentWords' => $frequentWords,
        ]);
    }
}
