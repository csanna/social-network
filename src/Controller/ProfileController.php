<?php

namespace App\Controller;

use App\Entity\Utilisateur;
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
}
