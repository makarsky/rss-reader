<?php

namespace App\Service;

use FeedIo\FeedInterface;
use Symfony\Component\Finder\Finder;

class RssWordCounterService
{
    /**
     * @var string
     */
    private $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    protected function getExcludedWords(): array
    {
        $finder = new Finder();
        $finder = $finder->in($this->projectDir . '/src/Resources')->files()->name('most_common_words.json');

        foreach ($finder as $file) {
            return json_decode($file->getContents(), true);
        }

        throw new \Exception('most_common_words.json not found');
    }

    public function getFrequentWords(FeedInterface $feed, int $limit = 10): array
    {
        $excludedWords = $this->getExcludedWords();
        $words = [];
        $pattern = '/[A-Za-z]+[\'-]?[A-Za-z]+/';

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