<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SignupController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function signupAction(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $name     = $request->request->get('name');
        $status   = $request->request->get('status');

        $user = new User();

        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $password);

        $user->setUsername($username);
        $user->setPassword($encoded);
        $user->setName($name);
        $user->setStatus($status);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'type'    => 'success',
            'message' => 'Signup successful!'
        ], JsonResponse::HTTP_OK);
    }
}
