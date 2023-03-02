<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;

use App\Form\CategoryType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categoria', name: 'app_category')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $data = $entityManager->getRepository(Category::class);

        return $this->render('category/index.html.twig', [
            'categories'=>$data->findAll()
        ]);
    }

    #[Route('/categoria/{id}/editar', name:'app_category_edit')]
    public function edit(Category $category,Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            // $entityManager->persist($form->getData());
            $entityManager->flush();

            $this->addFlash('success','Categoría editada con éxito');
        }

        return $this->render('category/edit.html.twig',[
            "form"=>$form->createView()
        ]);
    }



    #[Route('/categoria/crear', name:'app_category_create', methods:['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($form->getData());
            $entityManager->flush();

            $this->addFlash('success','Categoría creada con éxito');
        }

        return $this->render('category/create.html.twig',[
            "form"=>$form->createView()
        ]);
    }

}
