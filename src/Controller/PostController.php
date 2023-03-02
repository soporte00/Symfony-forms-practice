<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post/crear', name: 'app_post_create', methods:['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($form->getData());
            $entityManager->flush();

            $this->addFlash('success','Publicación guardada con éxito');
            return $this->redirectToRoute('app_post_create');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/post/{id}/editar', name: 'app_post_edit', methods:['GET','POST'])]
    public function edit(Post $post, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // $entityManager->persist($form->getData()); //Linea opcional..
            $entityManager->flush();

            $this->addFlash('success','Publicación editada con éxito');
            return $this->redirectToRoute('app_post_edit', ["id"=>$post->getId()]);
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
