<?php
// src/Controller/TrackController.php
namespace App\Controller;


use App\Service\RequestService;
use App\Entity\Track;
use Doctrine\ORM\EntityManagerInterface;
use Src\Form\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route(path: "/track")]
class TrackController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private RequestService $requestService,
        private EntityManagerInterface $entityManager,
    ) {
        
    }


    #[Route(path: "/{search?}", name: "search_tracks")]
    public function search(?string $search)
    {
        return $this->render("track/track-list.html.twig", parameters: [
            "tracks" => $this->requestService->requestSearchTrack($search ?: 'ado'),
            "search" => $search,
        ]);
    }


    #[Route(path: "/show/{id}", name: "track_show", methods: ["GET"])]
    public function show(string $id)
    {
        return $this->render("track/track-item.html.twig", [
            "track" => $this->requestService->requestTrack($id),
        ]);
    }

    #[Route(path:"/like/list", name:"all_liked_track", methods: ["GET"])]
    public function allLikedTracks()
    {
        /** @var User|null $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $tracks = $user->getFavoriteTracks();
        return $this->render("track/track-list.html.twig", [
            "tracks" => $tracks,
        ]);
    }

    #[Route(path:"/like/{idtrack}", name:"track_like", methods: ["GET"])]
    public function like(string $idtrack, Request $request)
    {
        /** @var User|null $user */
        $user  = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $track = $this->entityManager->getRepository(Track::class)->findOneBy(['spotifyId' => $idtrack]);
        if (!$track) {
            $track = $this->requestService->requestTrack($idtrack);
            $this->entityManager->persist($track);
        }

        if ($track) {
            // toggle favorite for authenticated user
            if ($user->getFavoriteTracks()->contains($track)) {
                $user->removeFavoriteTrack($track);
            } else {
                $user->addFavoriteTrack($track);
            }
            $this->entityManager->flush();
        }

        $route = $request->headers->get('referer');
        return $this->redirect($route ?: '/');
    }
}