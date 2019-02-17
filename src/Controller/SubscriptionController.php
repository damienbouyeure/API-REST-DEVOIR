<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionController extends AbstractFOSRestController
{
    private $subscriptionRepository;
    private $em;
    public function __construct(SubscriptionRepository $subscriptionRepository, EntityManagerInterface $entityManager)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->em = $entityManager;
    }
    /**    * @Rest\Get("/api/subscriptions/{name}") */
    public function getApiSubscription(Subscription $subscription)
    {
        return $this->view($subscription);
    }

    /**    * @Rest\Get("/api/subscriptions") */
    public function getApiUsers()
    {
        $subscription = $this->subscriptionRepository->findAll();
        return $this->view($subscription);
    }

    /**
     * @Rest\Post("/api/admin/subscriptions")
     * @ParamConverter("subscription", converter="fos_rest.request_body")
     */
    public function postApiUser(Subscription $subscription)
    {
        $this->em->persist($subscription);
        $this->em->flush();
        return $this->view($subscription);
    }
}
