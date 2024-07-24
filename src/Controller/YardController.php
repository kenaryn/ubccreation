<?php

namespace App\Controller;

use App\Entity\Yard;
use App\Form\YardType;
use App\Repository\YardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/yard')]
class YardController extends AbstractController
{
    #[Route('/', name: 'app_yard_index', methods: ['GET'])]
    public function index(YardRepository $yardRepository): Response
    {
        return $this->render('yard/index.html.twig', [
            'yards' => $yardRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_yard_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $yard = new Yard();
        $form = $this->createForm(YardType::class, $yard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($yard);
            $entityManager->flush();

            return $this->redirectToRoute('app_yard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yard/new.html.twig', [
            'yard' => $yard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_yard_show', methods: ['GET'])]
    public function show(Yard $yard): Response
    {
        return $this->render('yard/show.html.twig', [
            'yard' => $yard,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_yard_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Yard $yard, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(YardType::class, $yard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_yard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yard/edit.html.twig', [
            'yard' => $yard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_yard_delete', methods: ['POST'])]
    public function delete(Request $request, Yard $yard, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$yard->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($yard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_yard_index', [], Response::HTTP_SEE_OTHER);
    }
}
