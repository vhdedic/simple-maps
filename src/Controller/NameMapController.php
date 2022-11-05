<?php

namespace App\Controller;

use App\Entity\NameMap;
use App\Form\NameMapFormType;
use App\Repository\MapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NameMapController extends AbstractController
{
    
    public function __construct(EntityManagerInterface $em, MapRepository $mapRepository)
    {
        $this->em = $em;
        $this->mapRepository = $mapRepository;
    }
    
    #[Route('/map/{id}/add', name: 'app_name_map_add')]
    public function add($id, Request $request): Response
    {
        $name = new NameMap;

        $map = $this->mapRepository->find($id);

        $form = $this->createForm(NameMapFormType::class, $name);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $name->setName($form->get('name')->getData());
            $name->setMap($map);
            $name->setDescription($form->get('description')->getData());

            $this->em->persist($name);
            $this->em->flush();

            return $this->redirectToRoute('app_map_show', [
                'id' => $id
            ]);
        }
        
        return $this->render('name_map/add.html.twig', [
            'map' => $map,
            'form' => $form->createView(),
        ]);
    }
}
