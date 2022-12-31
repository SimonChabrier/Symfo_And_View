<?php

namespace App\EventSubscriber;

use App\Service\JsonManager;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiSubscriber extends AbstractController implements EventSubscriberInterface 
{

    public function __construct(JsonManager $jsonManager, UserRepository $userRepository)
    {
        $this->jsonManager = $jsonManager;
        $this->userRepository = $userRepository;
    }

    /**
     * Create a json file with the users data if the getAllUsers method is called and the json file doesn't exist
     *
     * @param ControllerEvent $event
     * @return void
     */
    public function onKernelController(ControllerEvent $event): void
    {   
        // if the controller is the getAllUsers method and the json file doesn't exist        
        if($event->getRequest()->attributes->get('_controller') == "App\Controller\Api\ApiUserController::getAllUsers" && !file_exists($this->getParameter('kernel.project_dir').'/public/json/users.json')) {
            $users = $this->userRepository->findAll();
            // create a json file with the users data
            $this->jsonManager->jsonFileInit($users, 'user:read', 'users.json', 'json');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
