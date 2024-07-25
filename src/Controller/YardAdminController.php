<?php

namespace App\Controller;

use App\Entity\Yard;
use App\Form\YardAdminType;
use App\Repository\YardRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/yard')]
class YardAdminController extends AbstractController
{
    #[Route('/', name: 'app_yard_admin_index', methods: ['GET'])]
    public function index(YardRepository $yardRepository): Response
    {
        return $this->render('yard_admin/index.html.twig', [
            'yards' => $yardRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_yard_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $yard = new Yard();
        $form = $this->createForm(YardAdminType::class, $yard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yard->setCreationDate(new DateTimeImmutable());
            $entityManager->persist($yard);
            $entityManager->flush();

            return $this->redirectToRoute('app_yard_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yard_admin/new.html.twig', [
            'yard' => $yard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_yard_admin_show', methods: ['GET'])]
    public function show(Yard $yard): Response
    {
        return $this->render('yard_admin/show.html.twig', [
            'yard' => $yard,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_yard_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Yard $yard, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(YardAdminType::class, $yard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_yard_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yard_admin/edit.html.twig', [
            'yard' => $yard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_yard_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Yard $yard, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $yard->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($yard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_yard_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
