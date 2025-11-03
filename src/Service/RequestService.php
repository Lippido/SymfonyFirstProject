<?php
namespace App\Service;


use App\Entity\Artist;
use App\Factory\ArtistFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Factory\TrackFactory;
use App\Entity\Track;

class RequestService
{
    private $token;

    public function __construct(
        private HttpClientInterface $httpClient, 
        private readonly AuthSpotifyService $authSpotifyService,
        private readonly TrackFactory $trackFactory,
        private readonly ArtistFactory $artistFactory,
    )
    {
        $this->token = $this->authSpotifyService->auth();
    }

    public function requestSearchTrack(string $name): array
    {
        $result = $this->httpClient->request("GET", "https://api.spotify.com/v1/search?query=$name&type=track&locale=fr-FR", [
            "headers" => [
                "Authorization" => ("Bearer " . $this->token),
            ]
        ]);
       return $this->trackFactory->createMultipleFromSpotifyData($result->toArray()['tracks']['items']);
    }

    public function requestTrack(string $id): Track
    {
        $result = $this->httpClient->request("GET", "https://api.spotify.com/v1/tracks/$id", [
            "headers" => [
                "Authorization" => ("Bearer " . $this->token),
            ]
        ]);
        return $this->trackFactory->createFromSpotifyData($result->toArray());
    }

    public function requestSearchArtist(string $name)
    {
        $result = $this->httpClient->request("GET", "https://api.spotify.com/v1/search?q=$name&type=artist", [
            "headers" => [
                "Authorization" => ("Bearer " . $this->token),
            ]
        ]);
        return $this->artistFactory->createMultipleFromSpotifyData($result->toArray()['artists']['items']);
    }

    public function requestArtist(string $name): Artist
    {
        $result = $this->httpClient->request("GET", "https://api.spotify.com/v1/artists/$name", [
            "headers" => [
                "Authorization" => ("Bearer " . $this->token),
            ]
        ]);
        return $this->artistFactory->createFromSpotifyData($result->toArray());
    }   
}