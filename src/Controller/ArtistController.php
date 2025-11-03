<?php
// src/Controller/TrackController.php
namespace App\Controller;


use App\Service\RequestService;
use App\Entity\Artist;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route(path: "/artist")]
class ArtistController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private RequestService $requestService,
        private EntityManagerInterface $entityManager,
    ) {
        
    }


    #[Route(path: "/{search?}", name: "search_artists")]
    public function search(?string $search)
    {
        return $this->render("artist/artist-list.html.twig", parameters: [
            "artists" => $this->requestService->requestSearchArtist($search ?: 'ado'),
            "search" => $search,
        ]);
    }


    #[Route(path: "/show/{id}", name: "artist_show", methods: ["GET"])]
    public function show(string $id)
    {
        return $this->render("artist/artist-item.html.twig", [
            "artist" => $this->requestService->requestArtist($id),
        ]);
    }

    #[Route(path:"/like/list", name:"all_liked_artists", methods: ["GET"])]
    public function allLikedArtists()
    {
        /** @var User|null $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $artists = $user->getFavoriteArtists();
        return $this->render("artist/artist-list.html.twig", [
            "artists" => $artists,
        ]);
    }

    #[Route(path:"/like/{idartist}", name:"artist_like", methods: ["GET"])]
    public function like(string $idartist, Request $request)
    {
        /** @var User|null $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $artist = $this->entityManager->getRepository(Artist::class)->findOneBy(['spotifyId' => $idartist]);
        if (!$artist) {
            $artist = $this->requestService->requestArtist($idartist);
            if ($artist instanceof Artist) {
                $this->entityManager->persist($artist);
            }
        }

        if ($artist) {
            // toggle favorite for authenticated user
            if ($user->getFavoriteArtists()->contains($artist)) {
                $user->removeFavoriteArtist($artist);
            } else {
                $user->addFavoriteArtist($artist);
            }
            $this->entityManager->flush();
        }

        $route = $request->headers->get('referer');
        return $this->redirect($route ?: '/');
    }
}