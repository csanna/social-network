<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    /**
     * @Route("/actu", name="article")
     */
    public function afficherActu(ArticleRepository $repo, PaginatorInterface $paginatorInterface, Request $request)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        //$articles = $this->getDoctrine()->getRepository(Article::class)->findBy([],['updated_at' => 'desc']);
        $articles = $paginatorInterface->paginate(
            $repo->findAllWithPagination(),
            $request->query->getInt('page', 1), //page number
            4 //limit per page
        );
        
        return $this->render('article/afficherActu.html.twig',[
            "articles" => $articles,
        ]);
    }

    /**
     * @Route("/actu/creation", name="creationArticle")
     * @Route("/actu/modification/{id}", name="modifArticle", methods="GET|POST")
     */
    public function ajoutEtModif(Article $article = null, Request $request)
    {
        if(!$article){
            $article = new Article();
        }

        $objectManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setUsername($this->getUser());
            $modif = $article->getId() !== null;
            $objectManager->persist($article);
            $objectManager->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectuée." : "L'ajout a été effectué.");
            return $this->redirectToRoute("article");
        }
        
        return $this->render('article/modificationArticle.html.twig',[
            "article" => $article,
            "form" => $form->createView(),
            "isModification" => $article->getId() !== null
        ]);
    }
    
    /**
     * @Route("/actu/{id}", name="supArticle", methods="supprimer")
     */
    public function suppression(Article $article = null, Request $request){
        
        $objectManager = $this->getDoctrine()->getManager();

        if($this->isCsrfTokenValid("SUP". $article->getId(), $request->get('_token'))){
            $objectManager->remove($article);
            $objectManager->flush();
            $this->addFlash("success","La suppression a été effectuée.");
            return $this->redirectToRoute("article");
        }
    }

    /**
     * @Route("/actu/afficher/{id}", name="afficherunArticle")
     */
    public function afficherunArticle(Article $article = null, Request $request){
        
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(['id' => $article]);

        $commentaires = $this->getDoctrine()->getRepository(Commentaire::class)->findBy([
            'article' => $article,
            'actif' => 1
        ],['created_at' => 'desc']);

        $commentaire = new Commentaire();

        $objectManager = $this->getDoctrine()->getManager();

        $formComment = $this->createForm(CommentaireType::class, $commentaire);
        $formComment->handleRequest($request);

        if($formComment->isSubmitted() && $formComment->isValid()){
            $commentaire->setArticle($article);
            $commentaire->setCreatedAt(new \DateTime('now'));
            $commentaire->setUpdatedAt(new \DateTime('now'));
            $commentaire->setUsername($this->getUser());

            $objectManager->persist($commentaire);
            $objectManager->flush();
            $this->addFlash("success", "Le commentaire a été ajouté.");
            return $this->redirectToRoute("afficherunArticle");
        }
        
        return $this->render('article/afficheruneActu.html.twig',[
            'article' => $article,
            'commentaires' => $commentaires,
            'formComment' => $formComment->createView()
        ]);
    }
}
