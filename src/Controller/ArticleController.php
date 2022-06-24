<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{

    /**
     * @Route("/articles", name="app_articles")
     */
    public function showAllArticle(ManagerRegistry $doctrine)
    {
        $articles = $doctrine->getRepository(Article::class)->findAll();
        return $this->render("article/allArticles.html.twig", [
            "articles" => $articles
         ]
        );
    }

 
    /**
     *@Route("/ajout-article", name="ajout-article")
     */
    public function formArticle(ManagerRegistry $doctrine, Request $request): Response
    {
        // on créé l'objet article
        $article = new Article();

        // on créé un forumulaire avec l'objet article et à partir du formulaire généré
        $form = $this->createForm(ArticleType::class, $article);

        // on transmet la requete courante au formulaire
        $form->handleRequest($request);

        // on vérifie si le formulaire est valide et s'il est soumit (click sur boutton envoyer)
        if ($form->isSubmitted() && $form->isValid()) {
           // on définit la date de création
           $article->setDateDeCreation(new DateTime("now"));

           // récupération du manager de doctrine
           $manager = $doctrine->getManager();

           // on persite l'objet article
           $manager->persist($article);

           // on envoie dans la base de données
           $manager->flush(); 

           return $this->redirectToRoute("app_articles");
        }

        return $this->render("article/formulaire.html.twig", [
            'formArticle'=> $form->createView()
        ]);
    }

    /**
     * @Route("/update-article_{id}" , name="article_update");
     */
    public function update(ManagerRegistry $doctrine, $id)// $id aura comme valeur l'id passé en parametre de la route
    {
        // recupération de l'article dont l'id est celui passé en parametre de la fonction
        $article = $doctrine->getRepository(Article::class)->find($id);

        dd($article);
        // on créé un forumulaire avec l'objet article et à partir du formulaire généré
          $form = $this->createForm(ArticleType::class, $article);

        // on transmet la requete courante au formulaire
        $form->handleRequest($request);

        // on vérifie si le formulaire est valide et s'il est soumit (click sur boutton envoyer)
        if ($form->isSubmitted() && $form->isValid()) {
           // on définit la date de création
           $article->setDateDeModification(new DateTime("now"));

           // récupération du manager de doctrine
           $manager = $doctrine->getManager();

           // on persite l'objet article
           $manager->persist($article);

           // on envoie dans la base de données
           $manager->flush(); 

           return $this->redirectToRoute("app_articles");
        }


        return $this->render("article/formulaire.html.twig", [
            'formArticle'=> $form->createView()
        ]);  

    }

    /**
     * @Route("/delete_article_{id}", name="article_delete")
     */
    public function delete($id, ManagerRegistry $doctrine) // $id aura 
    //pour valeur l' id passé en paramètre de la route
    {
        // on récupere l'article à supprimer
        $article = $doctrine->getRepository(Article::class)->find($id);
        // on récupere le manager de doctrine
        $manager = $doctrine->getManager();
        // on prépare la suppression de l'article
        $manager->remove($article);
        // on execute l'action (suppression)
        $manager->flush();

        return $this->redirectToRoute("app_articles");

    }

    /**
     * @Route("/article_{id}", name="app_article");
     */
    public function showArticle($id, ManagerRegistry $doctrine)
    {
        $article = $doctrine->getRepository(Article::class)->find($id);

        return $this->render("article/unArticle.html.twig", [
            'article' =>$article
        ]);
    }
}
