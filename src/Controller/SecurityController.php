<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('@EasyAdmin/page/login.html.twig', [
            // parameters usually defined in Symfony login forms
            'error' => $error,
            'last_username' => $lastUsername,
            'translation_domain' => 'admin',
            'favicon_path' => '/favicon-admin.svg',
            'page_title' => '<h5>Admin Djs</h5>',
            // this parameter, the login form won't include a CSRF token
            'csrf_token_intention' => 'authenticate',
            // the URL users are redirected to after the login (default: '/admin')
            'target_path' => $this->generateUrl('admin'),
            'username_label' => 'Login',
            // the label displayed for the password form field (the |trans filter is applied to it)
            'password_label' => 'Mot de passe',
            // the label displayed for the Sign In form button (the |trans filter is applied to it)
            'sign_in_label' => 'Log in',
            // the 'name' HTML attribute of the <input> used for the username field (default: '_username')
            'username_parameter' => 'email',
            // the 'name' HTML attribute of the <input> used for the password field (default: '_password')
            'password_parameter' => 'password',
            // whether to enable or not the "forgot password?" link (default: false)
            'forgot_password_enabled' => false,
            // whether to enable or not the "remember me" checkbox (default: false)
            'remember_me_enabled' => true,
            // remember me name form field (default: '_remember_me')
            'remember_me_parameter' => 'remember_me',
            // whether to check by default the "remember me" checkbox (default: false)
            'remember_me_checked' => true,
            // the label displayed for the remember me checkbox (the |trans filter is applied to it)
            'remember_me_label' => 'Remember me',
        ]
        );
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
