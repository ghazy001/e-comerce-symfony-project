<?php

namespace App\Controller;

use App\classe\Search;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/nos-produits', name: 'product')]
    public function index(Request $request): Response
    {

        $products=$this->entityManager->getRepository(Product::class)->findAll();

         $search = New Search();
         $form = $this->createForm(SearchType::class,$search);

         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){

             $products=$this->entityManager->getRepository(Product::class)->findWithSearch($search);

         }

        return $this->render('product/index.html.twig',[
            'products'=>$products,
            'form'=>$form->createView()
        ]);
    }

    #[Route('/produit/{slug}', name: 'Myproduct')]
    public function show($slug): Response
    {

        $product=$this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

             if (!$product){
                 return $this->redirectToRoute('product');
             }

        return $this->render('product/show.html.twig',[
            'product'=>$product
        ]);
    }
}
