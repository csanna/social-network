<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModifierProfilController extends AbstractController
{
    /**
     * @Route("/modifier_profil/{username}", name="modifier_profil", methods="GET|POST")
     */
    public function modifierProfil(Request $request)
    {
        $objectManager = $this->getDoctrine()->getManager();

        //$form = $this->createForm(ModificationType::class);
        //$form->handleRequest($request);
        
        return $this->render('modifier_profil/index.html.twig', [
            'controller_name' => 'ModifierProfilController',
        ]);
    }
}
