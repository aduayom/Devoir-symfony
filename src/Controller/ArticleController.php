<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/show", name="article_show")
     */
    public function show( ArticleRepository $repo): Response
    {
        $article=$repo->findAll(); 
        return $this->render('article/index.html.twig', [
            'article' => $article,
        ]);
    }




    /**
     * @Route("/article/show/statut{statut}", name="article_show_statut")
     */
    public function showArticleByStatut( $statut,ArticleRepository $repo): Response
    {
        $article=$repo->findBy(
            ["statut"=>$statut]
        );
        return $this->render('article/index.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/article/show/categorie{id_categorie}", name="article_show_categorie")
     */
    public function showArticleByCategorie( $id_categorie,ArticleRepository $repo): Response
    {
        $article=$repo->findBy(
            ["categorie"=>$id_categorie]
        );
        return $this->render('article/index.html.twig', [
            'article' => $article,
        ]);
    }




     /**
     * @Route("/article/delete{id}", name="article_delete",methods={"GET"})
     */
    public function delete(Article $article,ArticleRepository $repo,EntityManagerInterface $manager): Response
    {
        $manager->remove($article);
        $manager->flush();
        //dd("methode de supression");
        return $this->redirectToRoute("article_show");
       
    }

    /**
     * @Route("/article/add/{id?}", name="article_add",methods={"POST","GET"})
     */
    public function add($id,ArticleRepository $repo,EntityManagerInterface $manager,Request $request): Response
    {
        if (!empty($id)){
            //gestion du formulaire en mode modification
           $article=$repo->find($id);
        }else {
       //gestion de formuaire en mode ajout
       $article=new article();
         }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();
            //dd($categorie);
            return $this->redirectToRoute("article_show");
        }

        return $this->render('article/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
