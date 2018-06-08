<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     * @Template("default/index.html.twig")
     * @return array
     */
    public function admin()
    {
        return [];
    }

    /**
     * @Route("/admin/dashboard", name="dashboard")
     * @Template("default/dashboard.html.twig")
     * @return array
     */
    public function dashboard()
    {
        return [];
    }

    /**
     * @Route("/admin/relatorios", name="relatorios")
     * @Template("default/relatorios.html.twig")
     * @return array
     */
    public function relatorios()
    {
        return [];
    }

    /**
     * @Route("/admin/login", name="login")
     * @Template("default/login.html.twig")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return [
            'error' => $error,
            'lastUsername' => $lastUsername
        ];
    }

    /**
     * @param Request $request
     * @Route("/insert", name="insert")
     * @return Response
     */
    public function insert(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User;
        $user->setUsername('kilderson')
            ->setEmail('dersonsena@gmail.com')
            ->setRoles('ROLE_USER')
            ->setPassword($this->get('security.password_encoder')->encodePassword($user, '123456'));

        $entityManager->persist($user);

        $user = new User;
        $user->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setRoles('ROLE_ADMIN')
            ->setPassword($this->get('security.password_encoder')->encodePassword($user, '123'));

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('<html><body>Inserido!</body></html>');
    }
}
