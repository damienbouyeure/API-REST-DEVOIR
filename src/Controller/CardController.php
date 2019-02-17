<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class CardController extends AbstractFOSRestController
{
    private $cardRepository;
    private $em;

    public function __construct(CardRepository $cardRepository, EntityManagerInterface $entityManager)
    {
        $this->cardRepository = $cardRepository;
        $this->em = $entityManager;
    }
    /**    * @Rest\Get("/api/profile/cards") */
    public function getProfileUser()
    {
        $card= $this->cardRepository->findBy(['users'=> $this->getUser()]);
        return $this->view($card, [
            'groups' => ['user'],
        ]);
    }

}
