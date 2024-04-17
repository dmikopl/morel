<?php

namespace App\Service;

class MovieRecommendationService
{
    private array $movies;

    public function __construct(array $movies)
    {

        foreach ($movies as $movie) {
            if (!is_string($movie)) {
                throw new \InvalidArgumentException('Array must consist only of strings.');
            }
        }
        $this->movies = array_unique(array_map('trim', $movies));
    }

    public function randomRecommendation(): array
    {
        $recommendations = [];
        while (count($recommendations) < 3) {
            $tempRecommendations = [];
            $tempRecommendations = array_rand(array_flip($this->movies), 3);
            $recommendations = array_unique(array_merge($recommendations, $tempRecommendations));
        }
        return array_slice($recommendations, 0, 3);
    }

    public function wMoviesWithEvenLength(): array
    {
        $result = [];
        foreach ($this->movies as $movie) {
            $titleLength = mb_strlen(str_replace(' ', '', $movie));
            if (mb_substr($movie, 0, 1) === 'W' && $titleLength % 2 === 0) {
                $result[] = $movie;
            }
        }
        return $result;
    }

    public function multiWordMovies(): array
    {
        $result = [];
        foreach ($this->movies as $movie) {
            if (strpos($movie, ' ') !== false) {
                $result[] = $movie;
            }
        }
        return $result;
    }
}
