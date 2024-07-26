<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        # Get the login error if there is one.
        $error = $authenticationUtils->getLastAuthenticationError();

        # Get last username entered by the user.
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logOut(Security $security): Response
    {
        // Log out the user on the current firewall.
        $response = $security->logout();
        return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
    }
}
