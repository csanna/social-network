<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ActuController extends AbstractController
{
    /**
     * @Route("/actu", name="actu")
     */
    public function afficherActu()
    {
        return $this->render('actu/actu.html.twig');
    }
}
