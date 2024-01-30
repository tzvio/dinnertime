<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $cookTime = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $prepTime = null;

    #[ORM\Column]
    private ?float $ratings = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cusine = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeIngridient::class)]
    private Collection $recipeIngridients;

    public function __construct()
    {
        $this->recipeIngridients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCookTime(): ?int
    {
        return $this->cookTime;
    }

    public function setCookTime(int $cookTime): static
    {
        $this->cookTime = $cookTime;

        return $this;
    }

    public function getPrepTime(): ?int
    {
        return $this->prepTime;
    }

    public function setPrepTime(int $prepTime): static
    {
        $this->prepTime = $prepTime;

        return $this;
    }

    public function getRatings(): ?float
    {
        return $this->ratings;
    }

    public function setRatings(float $ratings): static
    {
        $this->ratings = $ratings;

        return $this;
    }

    public function getCusine(): ?string
    {
        return $this->cusine;
    }

    public function setCusine(?string $cusine): static
    {
        $this->cusine = $cusine;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngridient>
     */
    public function getRecipeIngridients(): Collection
    {
        return $this->recipeIngridients;
    }

    public function addRecipeIngridient(RecipeIngridient $recipeIngridient): static
    {
        if (!$this->recipeIngridients->contains($recipeIngridient)) {
            $this->recipeIngridients->add($recipeIngridient);
            $recipeIngridient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngridient(RecipeIngridient $recipeIngridient): static
    {
        if ($this->recipeIngridients->removeElement($recipeIngridient)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngridient->getRecipe() === $this) {
                $recipeIngridient->setRecipe(null);
            }
        }

        return $this;
    }


}
