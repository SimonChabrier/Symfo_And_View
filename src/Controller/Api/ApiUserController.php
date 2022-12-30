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

use App\Service\ObjectToJsonFile;



class ApiUserController extends AbstractController
{   
   
//////////////////////////////////////////////* USER API CRUD 

    /**
     * Retourne l'ensemble des utilisateurs
     * @Route("/api/users", name="api.get.users", methods={"GET"})
     */
    public function apiGet(UserRepository $userRepository, ObjectToJsonFile $objectToJsonFile): Response
    {   

        // check if the users.json file exists in the public folder
        if (file_exists($this->getParameter('kernel.project_dir').'/public/json/users.json')) {
            // get the users from the json file
            $usersFromJsonFile = file_get_contents($this->getParameter('kernel.project_dir').'/public/json/users.json');
            $users = json_decode($usersFromJsonFile, true);
        } else {
            // get all users from the database and create the json file
            $usersFromDataBase = $userRepository->findAll();
            $users = $objectToJsonFile->convertAndSave($usersFromDataBase, 'user:read', 'users.json', 'json'); 
        }

        return $this->json(
            $users,
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
        ValidatorInterface $validator,
        UserRepository $userRepository,
        ObjectToJsonFile $objectToJsonFile
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
        
        $userToSerialize = $userRepository->findOneBy([], ['id' => 'DESC']);
        $objectToJsonFile->addNewUserToJsonFile($userToSerialize, 'user:read', 'users.json', 'json');

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
        ValidatorInterface $validator,
        ObjectToJsonFile $objectToJsonFile
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

        // update the json file using the service updateUserToJsonFile
        $objectToJsonFile->updateUserInJsonFile($user, 'user:read', 'users.json', 'json');

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
        EntityManagerInterface $doctrine,
        ObjectToJsonFile $objectToJsonFile
    ): Response
    {   

        $objectToJsonFile->deleteUserFromJsonFile($user->getId(), 'users.json');

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
