<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = ["ROLE_USER"];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pronostic", mappedBy="iduser", orphanRemoval=true)
     */
    private $pronostic;




    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($role)
    {
        $this->roles = $role;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }



    /**
     * @return Collection|Pronostic[]
     */
    public function getPronostic(): Collection
    {
        return $this->pronostic;
    }

    public function addPronostic(Pronostic $pronostic): self
    {
        if (!$this->pronostic->contains($pronostic)) {
            $this->pronostic[] = $pronostic;
            $pronostic->setIduser($this);
        }

        return $this;
    }

    public function removePronostic(Pronostic $pronostic): self
    {
        if ($this->pronostic->contains($pronostic)) {
            $this->pronostic->removeElement($pronostic);
            // set the owning side to null (unless already changed)
            if ($pronostic->getIduser() === $this) {
                $pronostic->setIduser(null);
            }
        }

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }


   public function eraseCredentials()
   {
   }

   /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function __toString()
    {
      return $this->username;
    }
}
