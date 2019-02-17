<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


class UserController extends AbstractFOSRestController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->em = $entityManager;
    }

    /**    * @Rest\Get("/api/users/{id}") */
    public function getApiUser(User $user)
    {
        return $this->view($user, [
            'groups' => ['card'],
        ]);
    }

    /**    * @Rest\Get("/api/users") */
    public function getApiUsers()
    {
        $users = $this->userRepository->findAll();
        return $this->view($users, [
            'groups' => ['card'],
        ]);
    }

    /**
     * @Rest\Post("/api/users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function postApiUser(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user,[
            'groups' => ['card'],
        ]);
    }
    /**    * @Rest\Get("/api/profile") */
    public function getProfileUser()
    {
        $users =$this->getUser();
        return $this->view($users,[
            'groups' => ['card'],
        ]);
    }
    /**    * @Rest\Patch("/api/profile") */
    public function patchApiUser(Request $request)
    {
        $user = $this->getUser();
        if (!empty($request->get('firstname'))) {
            $user->setFirstname($request->get('firstname'));
        }
        if (!empty($request->get('lastname'))) {
            $user->setLastname($request->get('lastname'));
        }
        if (!empty($request->get('address'))) {
            $user->setAddress($request->get('address'));
        }
        if (!empty($request->get('country'))) {
            $user->setCountry($request->get('country '));
        }
        if (!empty($request->get('createdAt'))) {
            $date=date_create_from_format('Y-m-d H:i:s', $request->get('createdAt'));
            $user->setCreatedAt($date);
        }
        if (!empty($request->get('card'))) {
            $user->setCard($request->get('card '));
        }
        if (!empty($request->get('subscription'))) {
            $user->setSubscription($request->get('subscription '));
        }
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user,[
            'groups' => ['card'],
        ]);
    }

    /**    * @Rest\Patch("/api/admin/users/{id}") */
    public function patchAdminApiUser(Request $request)
    {
        $user = $this->getUser();
        if (!empty($request->get('firstname'))) {
            $user->setFirstname($request->get('firstname'));
        }
        if (!empty($request->get('lastname'))) {
            $user->setLastname($request->get('lastname'));
        }
        if (!empty($request->get('address'))) {
            $user->setAddress($request->get('address'));
        }
        if (!empty($request->get('country'))) {
            $user->setCountry($request->get('country '));
        }
        if (!empty($request->get('createdAt'))) {
            $date=date_create_from_format('Y-m-d H:i:s', $request->get('createdAt'));
            $user->setCreatedAt($date);
        }
        if (!empty($request->get('card'))) {
            $user->setCard($request->get('card '));
        }
        if (!empty($request->get('subscription'))) {
            $user->setSubscription($request->get('subscription '));
        }
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user,[
            'groups' => ['card'],
        ]);
    }
    /**    * @Rest\Delete("/api/admin/users/{id}") */
    public function deleteApiUser(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}