<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategorieFixtures extends Fixture
{
    private $repo;
    public function __construct(CategorieRepository $repo)
    {
        $this->repo=$repo;
    }

    public function load(ObjectManager $manager)
    {
        for ($i=1;$i<20;$i++) {
            $cat = new Categorie();
            $cat->setLibelle("Catégorie".$i);
            $cat->setCreateAt(new\DateTime());
            $manager->persist($cat);
        }
        
        $manager->flush();


        $categorie=$this->repo->findAll();
        foreach ($categorie as $key => $categorie) {
            for ($i=0; $i <10 ; $i++) {
                $article = new Article();
                $article->setTitre("Article".$i)
                            ->setContenu("It is a long established fact that a reader will be ")
                            ->setCategorie($categorie);
                $manager->persist($article);
            }
            $manager->flush();
        }
    }
}