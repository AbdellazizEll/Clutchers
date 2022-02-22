<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="the name of category is required")
     */
    private $nomC;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="cat", orphanRemoval=true)
     */
    private $ListProduit;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->ListProduit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->nomC;
    }

    public function setNomC(string $nomC): self
    {
        $this->nomC = $nomC;

        return $this;
    }
    

    

    public function addListProduit(Produit $listProduit): self
    {
        if (!$this->ListProduit->contains($listProduit)) {
            $this->ListProduit[] = $listProduit;
            $listProduit->setCat($this);
        }

        return $this;
    }

    public function removeListProduit(Produit $listProduit): self
    {
        if ($this->ListProduit->removeElement($listProduit)) {
            // set the owning side to null (unless already changed)
            if ($listProduit->getCat() === $this) {
                $listProduit->setCat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getListProduit(): Collection
    {
        return $this->ListProduit;
    }
}
