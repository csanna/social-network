<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use App\Form\ModificationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profil/{username}", name="profil")
     */
    public function afficherProfil(Utilisateur $utilisateur)
    {
        return $this->render('profile/profil.html.twig',[
            "utilisateur" => $utilisateur
        ]);
    }

    /**
     * @Route("/profil/{username}/modifierProfil", name="modifierProfil", methods="GET|POST")
     */
    public function modifierProfil(Request $request, Utilisateur $user)
    {
        $objectManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(ModificationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $objectManager->persist($user);
            $objectManager->flush();
            $this->addFlash("success","La modification a été effectuée.");
            return $this->redirectToRoute("profil", ['username' => $user->getUsername()]);
        }
        
        return $this->render('profile/modifierProfil.html.twig',[
            "form" => $form->createView(),
            "user" => $user
        ]);
    }    
}
