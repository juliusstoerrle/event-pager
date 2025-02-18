<?php

declare(strict_types=1);

namespace App\View\Web\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminHomeController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
