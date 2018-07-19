<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Form\LoginType;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, [
          '_username' => $lastUsername
        ]);

        return $this->render('security/login.html.twig', array(
            'form' => $form->createView(),
            'error'         => $error
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginAction()
    {
        // The security layer will intercept this request, else redirect to login page
        $this->addFlash('warning', $this->get('translator')->trans('login_expired'));
        return $this->redirect($this->generateUrl('login'));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request, else redirect to login page
        $this->addFlash('warning', $this->get('translator')->trans('login_expired'));
        return $this->redirect($this->generateUrl('login'));
    }


    /**
     * @Route("/admin", name="admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function admin()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
}
