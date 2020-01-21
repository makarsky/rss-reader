<?php

namespace App\Controller;

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

    public function __construct(FeedIo $feedIo)
    {
        $this->feedIo = $feedIo;
    }

    /**
     * @Route("/api/v1/feed", name="feed")
     */
    public function feedAction(): JsonResponse
    {
        $url = 'https://www.theregister.co.uk/software/headlines.atom';

        $feed = $this->feedIo->read($url, new Feed())->getFeed();

        $frequentWords = null;

        return $this->json([
            'feed' => $feed,
            'frequentWords' => $frequentWords,
        ]);
    }
}
