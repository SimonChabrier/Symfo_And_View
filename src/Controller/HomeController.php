<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Cette route permet d'accèder à la page d'accueil
     * @Route("/", name="app.home")
     */
    public function index(): Response
    {   
        return $this->render('base.html.twig', []);
    }

    /**
    * Cette route permettra de résoudre les routes dynamiquement via le router de VueJS
    * elle matchera avec tous les endpoints demandés par le router de VueJS
    * 
    * @Route("/slug?}", name="app.vue", requirements={"slug"=".+"})")
    */
    public function app(): Response
    {
      return $this->render('base.html.twig', []);
    }
}
