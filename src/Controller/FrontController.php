<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//factorisation des routes
/**
     * @Route("/front")
*/
class FrontController extends AbstractController
{
    /**
     * @Route("/show", name="front_show")
     */
    public function show(ArticleRepository $repo): Response
    {
        $article=$repo->findBy(
            ["statut"=>"publier"]
        );
        return $this->render('front/index.html.twig', [
            'article' => $article,
        ]);
    }
}
