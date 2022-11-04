<?php

namespace App\Controller;

use App\Entity\Name;
use App\Form\NameFormType;
use App\Repository\NameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NameController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, NameRepository $nameRepository)
    {
        $this->em = $em;
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

    #[Route('/name/create', name: 'app_name_create')]
    public function create(Request $request): Response
    {
        $name = new Name;

        $form = $this->createForm(NameFormType::class, $name);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $name->setName($form->get('name')->getData());
            $name->setLongitude($form->get('longitude')->getData());
            $name->setLatitude($form->get('latitude')->getData());

            $this->em->persist($name);
            $this->em->flush();

            return $this->redirectToRoute('app_name_index');
        }

        return $this->render('name/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/name/{id}/edit', name: 'app_name_edit')]
    public function edit($id, Request $request): Response
    {
        $name = $this->nameRepository->find($id);

        $form = $this->createForm(NameFormType::class, $name);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $name->setName($form->get('name')->getData());
            $name->setLongitude($form->get('longitude')->getData());
            $name->setLatitude($form->get('latitude')->getData());

            $this->em->persist($name);
            $this->em->flush();

            return $this->redirectToRoute('app_name_index');
        }

        return $this->render('name/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
