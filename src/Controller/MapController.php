<?php

namespace App\Controller;

use App\Entity\Map;
use App\Form\MapFormType;
use App\Repository\MapRepository;
use App\Repository\NameMapRepository;
use App\Repository\NameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, MapRepository $mapRepository, NameRepository $nameRepository, NameMapRepository $nameMapRepository)
    {
        $this->em = $em;
        $this->mapRepository = $mapRepository;
        $this->nameRepository = $nameRepository;
        $this->nameMapRepository = $nameMapRepository;

    }
    
    #[Route('/maps', name: 'app_map_index')]
    public function index(): Response
    {
        $maps = $this->mapRepository->findAll();
        
        return $this->render('map/index.html.twig', [
            'maps' => $maps,
        ]);
    }

    #[Route('/map/create', name: 'app_map_create')]
    public function create(Request $request): Response
    {
        $map = new Map;

        $form = $this->createForm(MapFormType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $map->setName($form->get('name')->getData());

            $this->em->persist($map);
            $this->em->flush();

            return $this->redirectToRoute('app_map_index');
        }

        return $this->render('map/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/map/{id}/edit', name: 'app_map_edit')]
    public function edit($id, Request $request): Response
    {
        $map = $this->mapRepository->find($id);

        $form = $this->createForm(MapFormType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $map->setName($form->get('name')->getData());

            $this->em->persist($map);
            $this->em->flush();

            return $this->redirectToRoute('app_map_index');
        }

        return $this->render('map/edit.html.twig', [
            'form' => $form->createView(),
            'map' => $map,
        ]);
    }

    #[Route('/map/{id}/show', name: 'app_map_show')]
    public function show($id): Response
    {
        $map = $this->mapRepository->find($id);
        
        return $this->render('map/show.html.twig', [
            'map' => $map,
        ]);
    }
}
