<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 */
class Evento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "Introduzca al menos {{ limit }} caracteres.",
     *      maxMessage = "Introduzca menos de {{ limit }} caracteres.",
     *      allowEmptyString = false
     * )
     */
    private $titulo;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(
     *     message = "Campo requerido."
     * )
     * @CustomAssert\FechaInicio
     */
    private $fechaInicio;

    /**
     * @ORM\Column(type="date", nullable=true)
     * 
     * @Assert\Expression(
     *     "value > this.getFechaInicio() | value  == null",
     *     message="La fecha de fin debería ser posterior a la de inicio.")
     */
    private $fechaFin;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank(
     *     message = "Campo requerido."
     * )
     * 
     */
    private $hora;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     *     message = "Campo requerido."
     * )
     */
    private $ubicacion;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message = "Error al procesar la ubicación."
     * )
     */
    private $coordenadas;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *     message = "Campo requerido."
     * )
     * @Assert\Type(
     *     type="integer",
     *     message="Introduzca un núm. entero válido."
     * )
     */
    private $precio;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *     message = "Campo requerido."
     * )
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(
     *    message = "Introduzca una url válida",
     * )
     */
    private $web;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bloqueado;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mensajeModeracion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Suscripcion", mappedBy="evento", orphanRemoval=true)
     */
    private $suscripciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="eventos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", inversedBy="eventos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reporte", mappedBy="evento", orphanRemoval=true)
     * @Assert\NotBlank(
     *     message = "Campo requerido."
     * )
     */
    private $reportes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaPublicacion;




    public function __construct()
    {
        $this->suscripciones = new ArrayCollection();
        $this->reportes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(?\DateTimeInterface $fechaFin): self
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getUbicacion(): ?string
    {
        return $this->ubicacion;
    }

    public function setUbicacion(string $ubicacion): self
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    public function getCoordenadas(): ?string
    {
        return $this->coordenadas;
    }

    public function setCoordenadas(string $coordenadas): self
    {
        $this->coordenadas = $coordenadas;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
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

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(?string $web): self
    {
        $this->web = $web;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getBloqueado(): ?bool
    {
        return $this->bloqueado;
    }

    public function setBloqueado(bool $bloqueado): self
    {
        $this->bloqueado = $bloqueado;

        return $this;
    }

    public function getMensajeModeracion(): ?string
    {
        return $this->mensajeModeracion;
    }

    public function setMensajeModeracion(?string $mensajeModeracion): self
    {
        $this->mensajeModeracion = $mensajeModeracion;

        return $this;
    }

    /**
     * @return Collection|Suscripcion[]
     */
    public function getSuscripciones(): Collection
    {
        return $this->suscripciones;
    }

    public function addSuscripcion(Suscripcion $suscripcion): self
    {
        if (!$this->suscripciones->contains($suscripcion)) {
            $this->suscripciones[] = $suscripcion;
            $suscripcion->setEvento($this);
        }

        return $this;
    }

    public function removeSuscripcion(Suscripcion $suscripcion): self
    {
        if ($this->suscripciones->contains($suscripcion)) {
            $this->suscripciones->removeElement($suscripcion);
            // set the owning side to null (unless already changed)
            if ($suscripcion->getEvento() === $this) {
                $suscripcion->setEvento(null);
            }
        }

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection|Reporte[]
     */
    public function getReportes(): Collection
    {
        return $this->reportes;
    }

    public function addReporte(Reporte $reporte): self
    {
        if (!$this->reportes->contains($reporte)) {
            $this->reportes[] = $reporte;
            $reporte->setEvento($this);
        }

        return $this;
    }

    public function removeReporte(Reporte $reporte): self
    {
        if ($this->reportes->contains($reporte)) {
            $this->reportes->removeElement($reporte);
            // set the owning side to null (unless already changed)
            if ($reporte->getEvento() === $this) {
                $reporte->setEvento(null);
            }
        }

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fechaPublicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fechaPublicacion): self
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }
}
