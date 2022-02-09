<?php

namespace App\Entity;

use App\Repository\AlergenoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlergenoRepository::class)
 */
class Alergeno
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
    private $alergeno;

    /**
     * @ORM\ManyToMany(targetEntity=Plato::class, mappedBy="alergenos")
     */
    private $platos;

    public function __construct()
    {
        $this->platos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlergeno(): ?string
    {
        return $this->alergeno;
    }

    public function setAlergeno(string $alergeno): self
    {
        $this->alergeno = $alergeno;

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
            $plato->addAlergeno($this);
        }

        return $this;
    }

    public function removePlato(Plato $plato): self
    {
        if ($this->platos->removeElement($plato)) {
            $plato->removeAlergeno($this);
        }

        return $this;
    }
}
