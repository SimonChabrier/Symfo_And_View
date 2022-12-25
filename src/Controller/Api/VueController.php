<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VueController extends AbstractController
{
    /**
     * @Route("/vue", name="app_vue")
     */
    public function index(): Response
    {
        return $this->render('vue/index.html.twig', [
            'controller_name' => 'VueController',
        ]);
    }

    //////////////////////////////////////////////* TEST API ON App.vue

    /**
    * @Route("/api/test/{word}", name="api.test")")
    */
    public function apiWord(string $word): Response
    {
      return new JsonResponse('réponse de la méthode apiWord du VueController :  ' . $word);
    }
}
