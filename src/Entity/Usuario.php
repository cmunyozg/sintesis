<?php

// src/Entity/Usuario.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 * @UniqueEntity(
 *     fields="email",
 *     message="Ya existe una cuenta con el email especificado."
 * )
 * @UniqueEntity(
 *     fields="alias",
 *     message="Ya existe una cuenta con el usuario especificado."
 * )
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 25,
     *      minMessage = "Introduzca al menos {{ limit }} caracteres.",
     *      maxMessage = "Introduzca menos de {{ limit }} caracteres.",
     *      allowEmptyString = false
     * )
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "Introduce un email válido."
     * )
     * @Assert\NotBlank(
     *     message = "Campo requerido."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $passwd;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(
     *     message = "Campo requerido."
     * )
     */
    private $fechaNacimiento;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaRegistro;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rol;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Suscripcion", mappedBy="usuario", orphanRemoval=true)
     */
    private $suscripciones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evento", mappedBy="usuario")
     */
    private $eventos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen;

    public function __construct()
    {
        $this->suscripciones = new ArrayCollection();
        $this->eventos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFechaRegistro(): ?\DateTimeInterface
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(\DateTimeInterface $fechaRegistro): self
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    public function getRol(): ?bool
    {
        return $this->rol;
    }

    public function setRol(bool $rol): self
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * @return Collection|Suscripcion[]
     */
    public function getSuscripciones(): Collection
    {
        return $this->suscripciones;
    }

    public function addSuscripcione(Suscripcion $suscripcione): self
    {
        if (!$this->suscripciones->contains($suscripcione)) {
            $this->suscripciones[] = $suscripcione;
            $suscripcione->setUsuario($this);
        }

        return $this;
    }

    public function removeSuscripcione(Suscripcion $suscripcione): self
    {
        if ($this->suscripciones->contains($suscripcione)) {
            $this->suscripciones->removeElement($suscripcione);
            // set the owning side to null (unless already changed)
            if ($suscripcione->getUsuario() === $this) {
                $suscripcione->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evento[]
     */
    public function getEventos(): Collection
    {
        return $this->eventos;
    }

    public function addEvento(Evento $evento): self
    {
        if (!$this->eventos->contains($evento)) {
            $this->eventos[] = $evento;
            $evento->setUsuario($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento): self
    {
        if ($this->eventos->contains($evento)) {
            $this->eventos->removeElement($evento);
            // set the owning side to null (unless already changed)
            if ($evento->getUsuario() === $this) {
                $evento->setUsuario(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->alias;
    }

    // UserInterface

    public function getRoles()
    {
        if ($this->rol == false) return array(
            'ROLE_USER'
        );
        else return array(
            'ROLE_ADMIN'
        );
    }

    public function getPassword()
    {
        return $this->getPasswd();
    }

    public function getSalt()
    {
        return;
    }

    public function getUsername()
    {
        return $this->getAlias();
    }
    public function eraseCredentials()
    {
        return;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }
}
