<?php

namespace App\Service;

use Exception;
use FeedIo\Feed\ItemInterface;
use FeedIo\FeedInterface;
use phpDocumentor\Reflection\File;
use Symfony\Component\Finder\Finder;

/**
 * Class RssWordCounterService
 * @package App\Service
 */
class RssWordCounterService
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * RssWordCounterService constructor.
     * @param string $projectDir
     */
    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getExcludedWords(): array
    {
        $finder = new Finder();
        $finder = $finder->in($this->projectDir . '/src/Resources')->files()->name('most_common_words.json');

        /**
         * @var File $file
         */
        foreach ($finder as $file) {
            return json_decode($file->getContents(), true);
        }

        throw new Exception('most_common_words.json not found');
    }

    /**
     * @param FeedInterface $feed
     * @param int $limit
     * @return array
     * @throws Exception
     */
    public function getFrequentWords(FeedInterface $feed, int $limit = 10): array
    {
        $excludedWords = $this->getExcludedWords();
        $words = [];
        $pattern = '/[A-Za-z]+[\'-]?[A-Za-z]+/';

        /**
         * @var ItemInterface $item
         */
        foreach ($feed as $item) {
            $titleMatches = [];
            $descriptionMatches = [];
            preg_match_all($pattern, stripcslashes(strip_tags($item->getTitle())), $titleMatches);
            preg_match_all($pattern, stripcslashes(strip_tags($item->getDescription())), $descriptionMatches);
            $words = array_merge($words, $titleMatches[0], $descriptionMatches[0]);
        }
        $wordCounts = array_count_values($words);

        $filteredWordCounts = array_filter($wordCounts, function($key) use ($excludedWords) {
            return !in_array(strtolower($key), $excludedWords);
        }, ARRAY_FILTER_USE_KEY);

        arsort($filteredWordCounts);

        return array_slice($filteredWordCounts, 0, $limit);
    }
}