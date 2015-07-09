<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @Route("/oauth/v2/auth/login", name="oauth_login")
     */
    public function oauthLoginAction()
    {

    }

    /**
     * @Route("/oauth/v2/auth/login-check", name="oauth_login_check")
     */
    public function oauthLoginCheckAction()
    {

    }

    /**
     * @Route("/request-token")
     *
     * @param Request $request
     * @return Response
     */
    public function requestTokenAction(Request $request)
    {
        $id     = $this->container->getParameter('oauth_client_id');
        $secret = $this->container->getParameter('oauth_client_secret');

        $username = $request->query->get('username');
        $password = $request->query->get('password');

        return $this->redirect($this->generateUrl('fos_oauth_server_token', [
            'client_id'     => $id,
            'client_secret' => $secret,
            'username'      => $username,
            'password'      => $password,
            'grant_type'    => 'password'
        ]));
    }

    /**
     * @Route("/refresh-token")
     *
     * @param Request $request
     * @return Response
     */
    public function refreshTokenAction(Request $request)
    {
        $id     = $this->container->getParameter('oauth_client_id');
        $secret = $this->container->getParameter('oauth_client_secret');

        $token  = $request->query->get('refresh_token');

        return $this->redirect($this->generateUrl('fos_oauth_server_token', [
            'client_id'     => $id,
            'client_secret' => $secret,
            'grant_type'    => 'refresh_token',
            'refresh_token' => $token
        ]));
    }

    /**
     * @Route("/login", name="login")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $this->get('user_repo')->findOneBy([
            'username' => $username
        ]);

        if ($user !== null && $this->container->get('security.password_encoder')->isPasswordValid($user, $password)) {
            $token = new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                'default',
                $user->getRoles()
            );

            $this->get('security.token_storage')->setToken($token);

            return new JsonResponse([
                'type'    => 'success',
                'message' => 'Login successful!'
            ], JsonResponse::HTTP_OK);
        }

        return new JsonResponse([
            'type'    => 'error',
            'message' => 'Invalid credentials.'
        ], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @return JsonResponse
     */
    public function logoutAction()
    {
        $this->get('security.token_storage')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        return new JsonResponse([
            'type'    => 'success',
            'message' => 'Logout successful!'
        ], JsonResponse::HTTP_OK);
    }
}
