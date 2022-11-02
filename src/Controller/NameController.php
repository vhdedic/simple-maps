<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NameController extends AbstractController
{
    #[Route('/names', name: 'app_name_index')]
    public function index(): Response
    {
        return $this->render('name/index.html.twig');
    }
}
