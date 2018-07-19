<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $team1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $score1;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $team2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $score2;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pronostic", mappedBy="idgame", orphanRemoval=true)
     */
    private $Pronostic;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan("today UTC")
     */
    private $date;

    public function __construct()
    {
        $this->Pronostic = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTeam1(): ?string
    {
        return $this->team1;
    }

    public function setTeam1(string $team1): self
    {
        $this->team1 = $team1;

        return $this;
    }

    public function getScore1(): ?int
    {
        return $this->score1;
    }

    public function setScore1(?int $score1): self
    {
        $this->score1 = $score1;

        return $this;
    }

    public function getTeam2(): ?string
    {
        return $this->team2;
    }

    public function setTeam2(string $team2): self
    {
        $this->team2 = $team2;

        return $this;
    }

    public function getScore2(): ?int
    {
        return $this->score2;
    }

    public function setScore2(?int $score2): self
    {
        $this->score2 = $score2;

        return $this;
    }

    /**
     * @return Collection|Pronostic[]
     */
    public function getPronostic(): Collection
    {
        return $this->Pronostic;
    }

    public function addPronostic(Pronostic $pronostic): self
    {
        if (!$this->Pronostic->contains($pronostic)) {
            $this->Pronostic[] = $pronostic;
            $pronostic->setIdgame($this);
        }

        return $this;
    }

    public function removePronostic(Pronostic $pronostic): self
    {
        if ($this->Pronostic->contains($pronostic)) {
            $this->Pronostic->removeElement($pronostic);
            // set the owning side to null (unless already changed)
            if ($pronostic->getIdgame() === $this) {
                $pronostic->setIdgame(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
      return $this->team1 .' - '. $this->team2;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
