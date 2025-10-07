<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Service\AuthSpotifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: "/track")]
class TrackController extends AbstractController
{
    private string $token;

    public function __construct(private readonly AuthSpotifyService $authSpotifyService)
    {
        $this->token = $this->authSpotifyService->auth();
        dd($this->token);
    }

    #[Route(path: "/", name: "index")]
    public function index()
    {
        return $this->render("base.html.twig", [
            "controller_name" => "TrackController"
        ]);
    }
}