<?php
namespace App\Controller;

use App\Entity\Ingridient;
use App\Entity\Recipe;
use App\Entity\RecipeIngridient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $ingridientsRepository, $recipeIngridientRepository, $recipeRepository;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->ingridientsRepository =  $entityManager->getRepository(Ingridient::class);
        $this->recipeIngridientRepository = $entityManager->getRepository(RecipeIngridient::class);
        $this->recipeRepository = $entityManager->getRepository(Recipe::class);
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/getAllIngridients', name: 'ingridients')]
    public function getAllIngridients() :Response
    {
        $ingridients = $this->ingridientsRepository->getAllIngridients();
        return new JsonResponse($ingridients);
    }

    #[Route('/searchRecipesByIngridients', name: 'search_recipes')]
    public function searchRecipesByIngridients(Request $request) {
        $searchQuery = json_decode($request->getContent(), true);
        $recipesIds = $this->recipeIngridientRepository->findRecipesByIngridients($searchQuery['data']);
        $recipes = $this->recipeRepository->findBy(['id' => $recipesIds]);
        
        return $this->render('home/recipes_search_results.html.twig', ['recipes' =>$recipes ]);
    }
}