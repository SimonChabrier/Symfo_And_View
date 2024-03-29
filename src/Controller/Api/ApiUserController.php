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

// use the JsonManager service to create the json file with the users data and don't use the database if the json file exist
use App\Service\JsonManager;

class ApiUserController extends AbstractController
{   
   
//////////////////////////////////////////////* USER API CRUD 

    /**
     * Retourne l'ensemble des utilisateurs
     * @Route("/api/users", name="api.get.users", methods={"GET"})
     */
    public function getAllUsers(UserRepository $userRepository, JsonManager $JsonManager): Response
    {   

        // if database is empty
        if (count($userRepository->findAll()) == 0) {

            // delete the json file if exist
            // if (file_exists($this->getParameter('kernel.project_dir').'/public/json/users.json')) {
            //     unlink($this->getParameter('kernel.project_dir').'/public/json/users.json');
            // }

            // return json with message and empty array
            return $this->json(
                [
                    'message' => 'No user in database',
                    'users' => []
                ],
                Response::HTTP_OK,
                [],
                ['groups' => 'user:read']
            );
        }

        // check if the users.json file exists in the public folder
        if (file_exists($this->getParameter('kernel.project_dir').'/public/json/users.json')) {
            $message = 'ALl users from json file';
            // get all users from the json file
            $usersFromJsonFile = file_get_contents($this->getParameter('kernel.project_dir').'/public/json/users.json');
            $users = json_decode($usersFromJsonFile, true);

        } 
        // retrun json with message and users
        return $this->json(
            [
                'message' => $message,
                'users' => $users
            ],
            Response::HTTP_OK,
            [],
            ['groups' => 'user:read']
        );

        
    }

    /**
     * Retourne un utilisateur en fonction de son id
     * @Route("/api/users/{id}", name="api.get.user", methods={"GET"})
     */
    public function getUserbyId(Request $request, JsonManager $JsonManager, UserRepository $userRepository): Response
    {   

        // get requested user id from the request object
        $id = $request->attributes->get('id');

        // if json file exists
        if (file_exists($this->getParameter('kernel.project_dir').'/public/json/users.json')) {
            
            $message = 'user from json file';
            $userId = $request->attributes->get('id');
            $user = $JsonManager->searchUserInJsonFile($userId, 'users.json');

        } else {

            $message = 'user from database';
            $user = $userRepository->find($id);
        }

        if(!$user){
         $user = "Aucun User trouvé pour id: ".$id;
        }

        return $this->json(
            [
                'message' => $message,
                'user' => $user
            ],
            Response::HTTP_OK,
            [],
            ['groups' => 'user:read']
        );
    }

    /**
     * Enregistrer un nouvel utilisateur
     * @Route("/api/users/register", name="api.post.user", methods={"POST"})
     */
    public function postUser(
        EntityManagerInterface $doctrine,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        UserRepository $userRepository,
        JsonManager $JsonManager
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

        // save the new user in the database
        $doctrine->persist($user);
        $doctrine->flush();

        // add the new user entry created in database to the json file 
        if (file_exists($this->getParameter('kernel.project_dir').'/public/json/users.json')) {
            $userToSerialize = $userRepository->findOneBy([], ['id' => 'DESC']);
            $JsonManager->addUserToJsonFile($userToSerialize, 'user:read', 'users.json', 'json');
        }
       
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
    public function patchUser(
        User $user,
        EntityManagerInterface $doctrine,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        JsonManager $JsonManager
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

        // save the user in the database
        $doctrine->persist($user);
        $doctrine->flush();

        // update the json file using the service updateUserToJsonFile
        if (file_exists($this->getParameter('kernel.project_dir').'/public/json/users.json')) {
            $JsonManager->updateUserInJsonFile($user, 'user:read', 'users.json', 'json');
        }
    
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
    public function deleteUser(
        User $user,
        EntityManagerInterface $doctrine,
        JsonManager $JsonManager
    ): Response
    {   

        // update the json file using the service updateUserToJsonFile
        if (file_exists($this->getParameter('kernel.project_dir').'/public/json/users.json')) {
            $JsonManager->deleteUserFromJsonFile($user->getId(), 'users.json');
        }

        // delete user from database
        $doctrine->remove($user);
        $doctrine->flush();

        return $this->json(
            [
                'message' => 'Utilisateur supprimé', 
                // username only for display the info message in front (no security issue here)
                'username' => $user->getUsername(),
            ],
            Response::HTTP_OK,
            [],
            ['groups' => ['user:read']]
        );
    }



}
