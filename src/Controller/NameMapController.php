<?php

namespace App\Controller;

use App\Entity\NameMap;
use App\Form\NameMapFormType;
use App\Repository\MapRepository;
use App\Repository\NameMapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NameMapController extends AbstractController
{
    
    public function __construct(EntityManagerInterface $em, MapRepository $mapRepository, NameMapRepository $nameMapRepository)
    {
        $this->em = $em;
        $this->mapRepository = $mapRepository;
        $this->nameMapRepository = $nameMapRepository;
    }
    
    #[Route('/map/{id}/add', name: 'app_name_map_add')]
    public function add($id, Request $request): Response
    {
        $name = new NameMap;

        $map = $this->mapRepository->find($id);

        $form = $this->createForm(NameMapFormType::class, $name);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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


    #[Route('map/{mapId}/remove/{nameMapId}', name: 'app_name_map_remove')]
    public function remove($mapId, $nameMapId): Response
    {
        $name_map = $this->nameMapRepository->find($nameMapId);

        $this->em->remove($name_map);
        $this->em->flush();

        return $this->redirectToRoute('app_map_show', [
            'id' => $mapId,
        ]);
    }
}
