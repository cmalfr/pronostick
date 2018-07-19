<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PronosticRepository")
 */
class Pronostic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $pscore1;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $pscore2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="Pronostic")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idgame;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pronostic")
     * @ORM\JoinColumn(nullable=false)
     */
    private $iduser;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $result;

    public function getId()
    {
        return $this->id;
    }

    public function getPscore1(): ?int
    {
        return $this->pscore1;
    }

    public function setPscore1(int $pscore1): self
    {
        $this->pscore1 = $pscore1;

        return $this;
    }

    public function getPscore2(): ?int
    {
        return $this->pscore2;
    }

    public function setPscore2(int $pscore2): self
    {
        $this->pscore2 = $pscore2;

        return $this;
    }

    public function getIdgame(): ?Game
    {
        return $this->idgame;
    }

    public function setIdgame(?Game $idgame): self
    {
        $this->idgame = $idgame;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getResult(): ?bool
    {
        return $this->result;
    }

    public function setResult(?bool $result): self
    {
        $this->result = $result;

        return $this;
    }
}
