<?php

namespace App\Entity;

use App\Repository\RestauranteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestauranteRepository::class)
 */
class Restaurante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logoUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $destacado; // false -> 0 true->1 -> No da igual, porque va a  meter false

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valoracionMedia; // 0,0-->> null

    /**
     * @ORM\OneToMany(targetEntity=Pedido::class, mappedBy="restaurante", orphanRemoval=true)
     */
    private $pedidos;

    /**
     * @ORM\ManyToMany(targetEntity=Municipios::class)
     */
    private $municipiosReparto;

    /**
     * @ORM\ManyToMany(targetEntity=Categorias::class)
     */
    private $categorias;

    /**
     * @ORM\OneToMany(targetEntity=Comentario::class, mappedBy="restaurante", orphanRemoval=true)
     */
    private $comentarios;

    /**
     * @ORM\OneToMany(targetEntity=Plato::class, mappedBy="restaurante", orphanRemoval=true)
     */
    private $platos;

    /**
     * @ORM\OneToMany(targetEntity=HorarioRestaurante::class, mappedBy="restaurante", orphanRemoval=true)
     */
    private $horarios;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
        $this->municipiosReparto = new ArrayCollection();
        $this->categorias = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->platos = new ArrayCollection();
        $this->horarios = new ArrayCollection();
        //$this->valoracionMedia = 0.0;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl(string $logoUrl): self
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }

    public function getImagenUrl(): ?string
    {
        return $this->imagenUrl;
    }

    public function setImagenUrl(?string $imagenUrl): self
    {
        $this->imagenUrl = $imagenUrl;

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

    public function getDestacado(): ?bool
    {
        return $this->destacado;
    }

    public function setDestacado(bool $destacado): self
    {
        $this->destacado = $destacado;

        return $this;
    }

    public function getValoracionMedia(): ?float
    {
        return $this->valoracionMedia;
    }

    public function setValoracionMedia(?float $valoracionMedia): self
    {
        $this->valoracionMedia = $valoracionMedia ?? 0.0;

        return $this;
    }

    /**
     * @return Collection|Pedido[]
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedido $pedido): self
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos[] = $pedido;
            $pedido->setRestaurante($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): self
    {
        if ($this->pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getRestaurante() === $this) {
                $pedido->setRestaurante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Municipios[]
     */
    public function getMunicipiosReparto(): Collection
    {
        return $this->municipiosReparto;
    }

    public function addMunicipiosReparto(Municipios $municipiosReparto): self
    {
        if (!$this->municipiosReparto->contains($municipiosReparto)) {
            $this->municipiosReparto[] = $municipiosReparto;
        }

        return $this;
    }

    public function removeMunicipiosReparto(Municipios $municipiosReparto): self
    {
        $this->municipiosReparto->removeElement($municipiosReparto);

        return $this;
    }

    /**
     * @return Collection|Categorias[]
     */
    public function getCategorias(): Collection
    {
        return $this->categorias;
    }

    public function addCategoria(Categorias $categoria): self
    {
        if (!$this->categorias->contains($categoria)) {
            $this->categorias[] = $categoria;
        }

        return $this;
    }

    public function removeCategoria(Categorias $categoria): self
    {
        $this->categorias->removeElement($categoria);

        return $this;
    }

    /**
     * @return Collection|Comentario[]
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): self
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios[] = $comentario;
            $comentario->setRestaurante($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): self
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getRestaurante() === $this) {
                $comentario->setRestaurante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Plato[]
     */
    public function getPlatos(): Collection
    {
        return $this->platos;
    }

    public function addPlato(Plato $plato): self
    {
        if (!$this->platos->contains($plato)) {
            $this->platos[] = $plato;
            $plato->setRestaurante($this);
        }

        return $this;
    }

    public function removePlato(Plato $plato): self
    {
        if ($this->platos->removeElement($plato)) {
            // set the owning side to null (unless already changed)
            if ($plato->getRestaurante() === $this) {
                $plato->setRestaurante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HorarioRestaurante[]
     */
    public function getHorarios(): Collection
    {
        return $this->horarios;
    }

    public function addHorario(HorarioRestaurante $horario): self
    {
        if (!$this->horarios->contains($horario)) {
            $this->horarios[] = $horario;
            $horario->setRestaurante($this);
        }

        return $this;
    }

    public function removeHorario(HorarioRestaurante $horario): self
    {
        if ($this->horarios->removeElement($horario)) {
            // set the owning side to null (unless already changed)
            if ($horario->getRestaurante() === $this) {
                $horario->setRestaurante(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
