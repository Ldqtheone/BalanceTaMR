<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * @param $controller
     * @param $type
     * @param Request $request
     */
    public function createForm($controller, $type, Request $request){
        $form = $controller->createForm($type);
        $form->handleRequest($request);
    }

    /**
     * @param $form
     * @param $team
     * @return bool
     */
    public function checkFormValidity($form, $team){
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($team);
            $this->em->flush();

            return true;
        }
        return false;
    }

    /**
     * @param $controller
     * @param $route
     * @param $params
     * @return mixed
     */
    public function render($controller, $route, $params){
        return $controller->render($route, $params);
    }

}