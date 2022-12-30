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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ApiUserController extends AbstractController
{   
   
//////////////////////////////////////////////* USER API CRUD 

    /**
     * Retourne l'ensemble des utilisateurs
     * @Route("/api/users", name="api.get.users", methods={"GET"})
     */
    public function apiGet(UserRepository $userRepository): Response
    {   
        // get all users from the database
        $users = $userRepository->findAll();
        // prepare $susers datas to be encoded in a json file 
        $users = $this->get('serializer')->normalize($users, null, ['groups' => 'user:read']);
        // create a json file with the users data from the database
        $json = json_encode($users);
        file_put_contents('users.json', $json);
        // save json file in the public folder
        $publicDirectory = $this->getParameter('kernel.project_dir').'/public';
        // create a directory if json directory doesn't exist
        if (!file_exists($publicDirectory.'/json')) {
            mkdir($publicDirectory.'/json', 0777, true);
        }
        // move the json file to the public folder
        rename($publicDirectory.'/users.json', $publicDirectory.'/json/users.json');
        // get the json file from the public folder
        $jsonFile = file_get_contents($publicDirectory.'/json/users.json');
        // decode the json file
        $jsonDecoded = json_decode($jsonFile, true);
        // return the json file
        return $this->json(
            $jsonDecoded,
            Response::HTTP_OK, 
            // https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
            [ 'Access-Control-Allow-Origin' => '*'], 
            ['groups' => 'user:read']
        );

        //convert the file data in associative array
        $data = json_decode($json, true);



        // return $this->json(
        //     $userRepository->findAll(),
        //     Response::HTTP_OK, 
        //     // https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
        //     [ 'Access-Control-Allow-Origin' => '*'], 
        //     ['groups' => 'user:read']
        // );
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
                'username' => $user->getUsername(),
            ],
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read']]
        );
    }



}
