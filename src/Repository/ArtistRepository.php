<?php
namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }


    public function removeArtist(Artist $artist): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($artist);
        $entityManager->flush();
    }
}