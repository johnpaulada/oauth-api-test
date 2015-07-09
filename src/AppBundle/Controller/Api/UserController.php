<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * Gets user specified by id
     *
     * @Route("/api/user/{id}", name="get_user")
     * @Method("GET")
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function getUserAction($id)
    {
        $user = $this->get('user_repo')->find($id);

        if ($user) {
            return new JsonResponse([
                'id'       => $user->getId(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'name'     => $user->getName(),
                'status'   => $user->getStatus()
            ], JsonResponse::HTTP_OK);
        }

        return new JsonResponse([
            'type'    => 'error',
            'message' => 'User could not be found.'
        ], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Get all users
     *
     * @Route("/api/users", name="get_users")
     *
     * @return JsonResponse
     */
    public function getUsersAction() {
        $users = $this->get('user_repo')->findAll();
        $userList = [];

        foreach ($users as $user) {
            array_push($userList, [
                'id'       => $user->getId(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'name'     => $user->getName(),
                'status'   => $user->getStatus()
            ]);
        }

        return new JsonResponse($userList, JsonResponse::HTTP_OK);
    }
}
