<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('home/accueil.html.twig');
    }

    /**
     * @Route("/bienvenue", name="bienvenue")
     */
    public function pageapresConnexion()
    {
        return $this->render('home/pageapresConnexion.html.twig');
    }

    /**
     * @Route("/inscrit", name="inscrit")
     */
    public function pageapresInscription()
    {
        return $this->render('home/pageapresInscription.html.twig');
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $objectManager = $this->getDoctrine()->getManager();
        
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $passwordCrypte = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($passwordCrypte);
            $utilisateur->setRoles("ROLE_USER");
            $objectManager->persist($utilisateur);
            $objectManager->flush();
            return $this->redirectToRoute("inscrit");
        }

        return $this->render('home/inscription.html.twig',[
            "form" => $form->createView()
        ]); 
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(AuthenticationUtils $util){
        
        return $this->render('home/connexion.html.twig',[
            "lastUserName" => $util->getLastUsername(),
            "error" => $util->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(){

    }
}
