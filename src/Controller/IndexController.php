<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route(path: '/admin', name: 'admin_index')]
    public function adminIndex(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
