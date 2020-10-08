<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

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
     * @param $form
     * @param $entity
     * @return bool
     */
    public function checkFormValidity($form, $entity){
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();

            return true;
        }

        return false;
    }

}