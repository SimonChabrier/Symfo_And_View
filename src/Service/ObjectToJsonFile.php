<?php

namespace App\Service;

// create a conveter object to json file class using the SerializerInterface
// this class get objet in entry and return a json file in the public folder

use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ObjectToJsonFile extends AbstractController
{
    private $serializer;
    private $userRepository;

    public function __construct(SerializerInterface $serializer, UserRepository $userRepository)
    {
        $this->serializer = $serializer;
        $this->userRepository = $userRepository;
    }

    public function convertAndSave($object, $context, $fileName, $format)
    {
        //* 1 - Convert $object in valid json data using the serialize method of SerializerInterface and the $context 
        $object = $this->serializer->serialize($object, $format, ['groups' => $context]);
        // create a json file with the json data
        file_put_contents($fileName, $object);
        // get the App public folder
        $publicDirectory = $this->getParameter('kernel.project_dir').'/public';
        // create a directory only if json directory doesn't exist
        if (!file_exists($publicDirectory.'/json')) {
            mkdir($publicDirectory.'/json', 0777, true);
        }
        // move the json file to the public folder using rename($from, $to)
        rename($publicDirectory.'/'.$fileName, $publicDirectory.'/json/'.$fileName);

        //* 2 - Get the json file from the public folder
        $jsonFile =  file_get_contents($publicDirectory.'/json/'.$fileName);
        // return the json file in valid json data
        return json_decode($jsonFile, true);
    }

     // add new object to the json file if json file exist
    public function addNewUserToJsonFile($object, $context, $fileName, $format)
    {
        // get the App public folder
        $publicDirectory = $this->getParameter('kernel.project_dir').'/public';
        // get the json file from the public folder
        $jsonFile =  file_get_contents($publicDirectory.'/json/'.$fileName);
        // convert the json file in valid json data
        $jsonFile = json_decode($jsonFile, true);
        // convert the new object in valid json data
        $object = $this->serializer->serialize($object, $format, ['groups' => $context]);

        // convert the new object in valid json data
        $object = json_decode($object, true);
        // add the new object to the json file
        array_push($jsonFile, $object);
        // convert the json file in valid json data
        $jsonFile = json_encode($jsonFile);
        // create a json file with the json data
        file_put_contents($fileName, $jsonFile);
        // move the json file to the public folder using rename($from, $to)
        rename($publicDirectory.'/'.$fileName, $publicDirectory.'/json/'.$fileName);
        // return the json file in valid json data
        return json_decode($jsonFile, true);
    }

    // update user in the json file if json file exist
    public function updateUserInJsonFile($object, $context, $fileName, $format)
    {
        $publicDirectory = $this->getParameter('kernel.project_dir').'/public';
        $jsonFile =  file_get_contents($publicDirectory.'/json/'.$fileName);
        $jsonFile = json_decode($jsonFile, true);

        $object = $this->serializer->serialize($object, $format, ['groups' => $context]);
        $object = json_decode($object, true);
        // update the user by id in the json file
        foreach ($jsonFile as $key => $user) {
            if ($user['id'] == $object['id']) {
                $jsonFile[$key] = $object;
            }
        }

        $jsonFile = json_encode($jsonFile);
        file_put_contents($fileName, $jsonFile);
        // move the json file to the public folder using rename($from, $to)
        rename($publicDirectory.'/'.$fileName, $publicDirectory.'/json/'.$fileName);
        return json_decode($jsonFile, true);
    }

    // Remove delete User in the json file if json file exist
    public function deleteUserFromJsonFile($id, $fileName)
    {
        $publicDirectory = $this->getParameter('kernel.project_dir').'/public';
        $jsonFile =  file_get_contents($publicDirectory.'/json/'.$fileName);
        if($jsonFile) {
            $jsonFile = json_decode($jsonFile, true);
            // find user by id in the json file and remove it
            foreach ($jsonFile as $key => $user) {
                if ($user['id'] == $id) {
                    unset($jsonFile[$key]);
                }
            }
            // make a new array of objects without reindex each object using array_values() on $jsonFile
            $jsonFile = json_encode(array_values($jsonFile));
            file_put_contents($fileName, $jsonFile);
            rename($publicDirectory.'/'.$fileName, $publicDirectory.'/json/'.$fileName);

            return json_decode($jsonFile, true);
        }

        return false;
    }
}



