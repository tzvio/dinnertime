<?php

namespace App\Command;

use App\Entity\Ingridient;
use App\Entity\Recipe;
use App\Entity\RecipeIngridient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:import:data',
    description: 'Improt recipe list and ingredients in JSON format to the database',
)]
class ImportDataCommand extends Command
{

    public function __construct(private readonly EntityManagerInterface $entityManager) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('recipe', InputArgument::REQUIRED, 'Recipe file to import');
        $this->addArgument('ingredients', InputArgument::REQUIRED, 'Ingredients file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->parseRecipeJSONFile($input->getArgument('recipe'));
        $this->parseIngridentJSONFile($input->getArgument('ingredients'));
        $io = new SymfonyStyle($input, $output);
        $io->success('Succesfully imported json list.');
        return Command::SUCCESS;
    }

    private function parseIngridentJSONFile($file)
    {
        $jsonData = file_get_contents($file);
        $arrayData = json_decode($jsonData, true);
        foreach ($arrayData['ingridients'] as $name) {
            $ingredient = new Ingridient();
            $ingredient->setName($name);
            $this->entityManager->persist($ingredient);
            $this->entityManager->flush();
        }
    }


    private function saveRecipeData($data) 
    {
        $recipe = new Recipe();
        $recipe->setTitle($data["title"]);
        echo $data["title"] . "\n";
        $recipe->setCookTime($data["cook_time"]);
        $recipe->setPrepTime($data["prep_time"]);
        $recipe->setRatings($data["ratings"]);
        $recipe->setCusine($data["cuisine"]);
        $recipe->setCategory($data["category"]);
        $recipe->setAuthor($data["author"]);
        $recipe->setImage($data["image"]);
        foreach ($data["ingredients"] as $row) {
            $ingredient = new RecipeIngridient();
            $ingredient->setIngridient($row);
            $recipe->addRecipeIngridient($ingredient);
            $this->entityManager->persist($ingredient);
        }
        $this->entityManager->persist($recipe);
    }

    private function parseRecipeJSONFile($file) {
        $jsonData = file_get_contents($file);
        $arrayData = json_decode($jsonData, true);
        foreach ($arrayData as $index => $row) {
            $this->saveRecipeData($row);
            if (($index % 10) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }
    }
}