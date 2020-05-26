<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/actu", name="article")
     */
    public function afficherActu()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        
        return $this->render('article/afficherActu.html.twig',[
            "articles" => $articles
        ]);
    }
}
