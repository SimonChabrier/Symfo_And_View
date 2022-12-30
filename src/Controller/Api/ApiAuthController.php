<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class ApiAuthController extends AbstractController
{
   //////////////////////////////////////////////* USER ACTIONS
    
    /**
     * Permet d'enregistrer un utilisateur
     * @Route("/api/register", name="api_user_register", methods={"POST"})
     */
    public function apiUserRegister(
        EntityManagerInterface $doctrine,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response
    {   
    
        $data = $request->getContent();
        $user = $serializer->deserialize($data, User::class, 'json');
        $errors = $validator->validate($user);

        // hash du mot de passe depuis la requête
        $user->setPassword(
            password_hash($user->getPassword(), PASSWORD_BCRYPT)
        );

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse($errorsString, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $doctrine->persist($user);
        $doctrine->flush();

        return $this->json(
            $user,
            Response::HTTP_CREATED,
            [],
            ['groups' => ['user:read']]
        );
    }

    // json loginroute

    /**
     * Permet de se connecter 
     * crée et retourne un Jwt Token
     * connecte aussil'utilisateur dans symfony.
     * via le firewall main et et mon custom authenticator
     * 
     * @Route("/api/login", name="api.login", methods={"POST"})
     */
    public function apiLogin(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    {       
            // Format de données à envoyer en POST
            // login dépend de la propriété donnée au pramètre app_user_provider dans security.yaml pour le firewall main
            // {
            //     "security": {
            //         "credentials": {
            //             "login": "simon",
            //             "password": "password"
            //         }
            //     }
            // }

            $user = $this->getUser();
    
            return new JsonResponse([
                'username' => $user->getUserIdentifier(),
                'roles' => $user->getRoles(),
                'token' => $JWTManager->create($user)
            ]);
    }

    // json logout route

    /**
     * Permet de se déconnecter
     * @Route("/api/logout", name="api.logout", methods={"POST"})
     */
    public function apiLogout()
    {
        // le logout est géré par le firewall main et le custom authenticator
        // il suffit de faire une requête POST sur cette route pour se déconnecter
        // le token est invalide après déconnexion

        return new JsonResponse([
            'message' => 'Déconnexion réussie'
        ]);
        
    }
}
