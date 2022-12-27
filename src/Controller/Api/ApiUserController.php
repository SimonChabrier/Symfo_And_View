<?php

namespace App\Controller\Api;

use Exception;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiUserController extends AbstractController
{   

//////////////////////////////////////////////* USER CRUD 

    /**
     * Retourne l'ensemble des utilisateurs
     * @Route("/api/users", name="api.get.users", methods={"GET"})
     */
    public function apiGet(UserRepository $userRepository): Response
    {   
        return $this->json(
            $userRepository->findAll(),
            Response::HTTP_OK, 
            // https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
            [ 'Access-Control-Allow-Origin' => '*'], 
            ['groups' => 'user:read']
        );
    }

    /**
     * Retourne un utilisateur en fonction de son id
     * @Route("/api/users/{id}", name="api.get.user", methods={"GET"})
     */
    public function apiGetUser(User $user): Response
    {
        if ($user) {
            return $this->json(
                $user,
                Response::HTTP_OK,
                [],
                ['groups' => 'user:read']
            );
        }
    }

    /**
     * Enregistrer un nouvel utilisateur
     * @Route("/api/users/register", name="api.post.user", methods={"POST"})
     */
    public function apiPostUser(
        EntityManagerInterface $doctrine,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response
    {   
        $data = $request->getContent();
        $user = $serializer->deserialize($data, User::class, 'json');
        // hash du mot de passe
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            // les messages d'erreurs remontent des annotations @Assert ou @UniqueEntity etc de l'entité
            // ce sont les contraintes de validation de l'entité qui sont définies via les annotations
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

    /**
     * Mettre à jour un utilisateur
     * @Route("/api/users/{id}", name="api.patch.user", methods={"PATCH"})
     */
    public function apiPatchUser(
        User $user,
        EntityManagerInterface $doctrine,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): Response
    {   
        $data = $request->getContent();
        $serializer->deserialize($data, User::class, 'json', ['object_to_populate' => $user]);
        // hash du mot de passe
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse($errorsString, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $doctrine->persist($user);
        $doctrine->flush();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read']]
        );
    }

    /**
     * Supprimer un utilisateur
     * @Route("/api/users/delete/{id}", name="api.delete.user", methods={"DELETE"})
     */
    public function apiDeleteUser(
        User $user,
        EntityManagerInterface $doctrine
    ): Response
    {   
        $doctrine->remove($user);
        $doctrine->flush();

        return $this->json(
            [
                'message' => 'Utilisateur supprimé', 
                'username' => $user->getUserIdentifier(),
            ],
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read']]
        );
    }

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

    /**
     * Permet de se connecter
     * Actuellement j'utilise le JWT Token dans vue pour l'Auth ur l'API...
     * mais cette route permet de réupérer le sinfos complètes d'un user si besoin...
     * 
     * @Route("/api/login", name="api.login", methods={"POST"})
     */
    public function apiLogin(Request $request, UserRepository $userRepository): Response
    {   
            // Format de donnée attendu
            // {
            //     "username": "user@usermail",
            //     "password": "userpassword"
            // }

        $data = $request->getContent();
        $data = json_decode($data, true);

        // find user by username
        $user = $userRepository->findOneBy(['username' => $data['username']]);

        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }
        if (!password_verify($data['password'], $user->getPassword())) {
            return new JsonResponse(['message' => 'Mot de passe incorrect'], Response::HTTP_UNAUTHORIZED);
        }

        // token JWT
        // $token = $this->tokenGenerator->generateToken($user);
        // dd($token);

        
        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            [
                'groups' => ['user:read'],
            ]
        );
    }
}
