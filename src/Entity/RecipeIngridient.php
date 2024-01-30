<?php

namespace App\Entity;

use App\Repository\RecipeIngridientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeIngridientRepository::class)]
class RecipeIngridient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipeIngridients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ingridient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getIngridient(): ?string
    {
        return $this->ingridient;
    }

    public function setIngridient(string $ingridient): static
    {
        $this->ingridient = $ingridient;

        return $this;
    }
}
