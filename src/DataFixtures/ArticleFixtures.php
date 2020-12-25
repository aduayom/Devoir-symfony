<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    private $repo;
    public function __construct(CategorieRepository $repo)
    {
        $this->repo=$repo;
    }
    public function load(ObjectManager $manager)
    {
        $categorie=$this->repo->findAll();
            foreach ($categorie as $key => $categorie) {
                    for ($i=0; $i <10 ; $i++) { 
                        $article = new Article();
                        $article->setTitre("Article".$i)
                                ->setContenu("It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).")
                                ->setCategorie($categorie);
                        $manager->persist($article);
                    }
                    $manager->flush();
            }
        
    }
}
