<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ArticleFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder){
            $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $user1 = new Utilisateur();
        $user1->setUsername('TestFixtures');

        $password = $this->encoder->encodePassword($user1, 'TestFixtures');
        $user1->setPassword($password);

        $user1->setAge("20");
        $user1->setLieuResidence("Paris, France");
        
        $date = new \DateTime("12-12-1990");

        $user1->setDateAnniversaire($date);
        $user1->setRoles("ROLE_USER");
        $user1->setImage("profil.png");
        $user1->setUpdatedAt(new \DateTime("now"));
        $manager->persist($user1);
        
        $article1 = new Article();
        $article1->setTitre("Mon premier post")
                ->setContenu("Voici mon tout premier post!")
                ->setUsername($user1)
                ->setCreatedAt(new \DateTime("now"))
                ->setUpdatedAt(new \DateTime("now"));
        $manager->persist($article1);

        $user2 = new Utilisateur();
        $user2->setUsername('TestFixtures2');

        $password = $this->encoder->encodePassword($user2, 'TestFixtures2');
        $user2->setPassword($password);

        $user2->setAge("30");
        $user2->setLieuResidence("Lyon, France");
        
        $date = new \DateTime("22-10-1995");

        $user2->setDateAnniversaire($date);
        $user2->setRoles("ROLE_USER");
        $user2->setImage("profil2.png");
        $user2->setUpdatedAt(new \DateTime("now"));
        $manager->persist($user2);
        
        $article2 = new Article();
        $article2->setTitre("Une belle journée")
                ->setContenu("Il fait beau aujourd'hui.")
                ->setUsername($user2)
                ->setCreatedAt(new \DateTime("now"))
                ->setUpdatedAt(new \DateTime("now"));
        $manager->persist($article2);

        $user3 = new Utilisateur();
        $user3->setUsername('TestFixtures3');

        $password = $this->encoder->encodePassword($user2, 'TestFixtures3');
        $user3->setPassword($password);

        $user3->setAge("22");
        $user3->setLieuResidence("Marseille, France");
        $date = new \DateTime("22-10-1995");

        $user3->setDateAnniversaire($date);
        $user3->setRoles("ROLE_USER");
        $user3->setImage("profil3.png");
        $user3->setUpdatedAt(new \DateTime("now"));
        $manager->persist($user3);
        
        $article3 = new Article();
        $article3->setTitre("Ce que j'ai mangé")
                ->setContenu("J'ai fait des pizzas hier soir!")
                ->setUsername($user3)
                ->setCreatedAt(new \DateTime("now"))
                ->setUpdatedAt(new \DateTime("now"));
        $manager->persist($article3);

        $manager->flush();
    }
}
