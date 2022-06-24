<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function test() {
    
        $prenom = "Martin";
        $nom = "SOUFOR";
        $listeUsers = [
          "prenom" => $prenom,
          "nom" => $nom,
          "users" => [
                "user1" => ["prenom" => "Vanessa", "nom" => "Kameny", "age" => "30"],
                "user2" => ["prenom" => "Gaby", "nom" => "Nemany", "age" => "36"],
                "user3" => ["prenom" => "Chimène", "nom" => "Domgny", "age" => "38"]
          ], 
          "dernierArticle" => "$dernierArticle"
        ];
        return $this->render("test.html.twig", $listeUsers);
    }
}
