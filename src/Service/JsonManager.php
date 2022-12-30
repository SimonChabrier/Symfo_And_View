<?php

namespace App\Service;

// create a conveter object to json file class using the SerializerInterface
// this class get objet in entry and return a json file in the public folder

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JsonManager extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    // init the json file if json file doesn't exist
    public function jsonFileInit($object, $context, $fileName, $format)
    {
        $object = $this->serializer->serialize($object, $format, ['groups' => $context]);
        file_put_contents($fileName, $object);
        $publicDirectory = $this->getParameter('kernel.project_dir').'/public';

        if (!file_exists($publicDirectory.'/json')) {
            mkdir($publicDirectory.'/json', 0777, true);
        }

        rename($publicDirectory.'/'.$fileName, $publicDirectory.'/json/'.$fileName);

        $jsonFile =  file_get_contents($publicDirectory.'/json/'.$fileName);
        return json_decode($jsonFile, true);
    }

     // add new object to the json file if json file exist
    public function addUserToJsonFile($object, $context, $fileName, $format)
    {
        $publicDirectory = $this->getParameter('kernel.project_dir').'/public';
        $jsonFile =  file_get_contents($publicDirectory.'/json/'.$fileName);
        $jsonFile = json_decode($jsonFile, true);

        $object = $this->serializer->serialize($object, $format, ['groups' => $context]);
        $object = json_decode($object, true);

        array_push($jsonFile, $object);
        $jsonFile = json_encode($jsonFile);

        file_put_contents($fileName, $jsonFile);
        rename($publicDirectory.'/'.$fileName, $publicDirectory.'/json/'.$fileName);

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

    // search user by id in the json file if json file exist
    public function searchUserInJsonFile($id, $fileName)
    {
        $publicDirectory = $this->getParameter('kernel.project_dir').'/public';
        $jsonFile =  file_get_contents($publicDirectory.'/json/'.$fileName);
       
        if($jsonFile) {
            $jsonFile = json_decode($jsonFile, true);

            // find user by id in the json file and return it
            foreach ($jsonFile as $user) {

                if ($user['id'] == $id) {
                    return $user;
                }
            }
        }

        return false;
    }
}



