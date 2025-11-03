<?php
namespace App\Factory;
use App\Entity\Artist;

class ArtistFactory
{
    public function createFromSpotifyData(array $data): Artist
    {
        $artist = new Artist();
        $artist->setSpotifyId($data['id'] ?? null);
        $artist->setName($data['name'] ?? null);
        $artist->setSpotifyUrl($data['external_urls']['spotify'] ?? null);
        $artist->setPictureLink($data['images'][0]['url'] ?? null);
        $artist->setType($data['type'] ?? null);
        $artist->setFollowers($data['followers']['total'] ?? null);

        return $artist;
    }

    public function createMultipleFromSpotifyData(array $dataArray): array
    {
        $artists = [];
        foreach ($dataArray as $data) {
            $artists[] = $this->createFromSpotifyData($data);
        }
        return $artists;
    }
}