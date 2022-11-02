<?php

namespace App\Controller;

use App\Repository\NameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NameController extends AbstractController
{
    public function __construct(NameRepository $nameRepository)
    {
        $this->nameRepository = $nameRepository;
    }
    
    #[Route('/names', name: 'app_name_index')]
    public function index(): Response
    {
        $names = $this->nameRepository->findAll();
        
        return $this->render('name/index.html.twig', [
            'names' => $names
        ]);
    }
}
