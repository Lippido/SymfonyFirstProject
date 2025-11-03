<?php

namespace App\Entity;

use App\Repository\ArtistRepository ;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?string $spotifyUrl = null;

    #[ORM\Column(nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?string $spotifyId = null;

    #[ORM\Column(nullable: true)]
    private ?string $pictureLink = null;

    #[ORM\Column(nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $followers = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favoriteTracks')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpotifyUrl(): ?string
    {
        return $this->spotifyUrl;
    }
    public function setSpotifyUrl(?string $spotifyUrl): self
    {
        $this->spotifyUrl = $spotifyUrl;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getSpotifyId(): ?string
    {
        return $this->spotifyId;
    }
    public function setSpotifyId(?string $spotifyId): self
    {
        $this->spotifyId = $spotifyId;

        return $this;
    }
    public function getPictureLink(): ?string
    {
        return $this->pictureLink;
    }
    public function setPictureLink(?string $pictureLink): self
    {
        $this->pictureLink = $pictureLink;

        return $this;
    }
    public function getType(): ?string
    {
        return $this->type;
    }
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getFollowers(): ?int
    {
        return $this->followers;
    }
    public function setFollowers(?int $followers): self
    {
        $this->followers = $followers;

        return $this;
    }
}