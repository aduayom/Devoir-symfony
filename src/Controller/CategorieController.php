<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/show{id?}", name="categorie_show",methods={"GET","POST"})
     */
    public function show($id,CategorieRepository $repo, Request $request,EntityManagerInterface $manager): Response
    {
        $categorie=$repo->findAll();
        //on vérifie ici si le id existe
        if (!empty($id)){
                 //gestion du formulaire en mode modification
                $categorie=$repo->find($id);
        }else {
            //gestion de formuaire en mode ajout
            $categorie=new Categorie();
        }

        //mappage du formaulaire et l'objet categorie
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            //dd($categorie);
            return $this->redirectToRoute("categorie_show");
        }
        $categories=$repo->findAll();
        //dd($categories);
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/add", name="categorie_add",methods={"POST"})
     */
    public function add(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/categorie/update", name="categorie_update",methods={"POST"})
     */
    public function update(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

      /**
     * @Route("/categorie/delete{id}", name="categorie_delete",methods={"GET"})
     */
    public function delete($id,CategorieRepository $repo,EntityManagerInterface $manager): Response
    {
        $categorie=$repo->find($id);
        $manager->remove($categorie);
        $manager->flush();
        //dd("methode de supression");
        return $this->redirectToRoute("categorie_show");
    }
}
