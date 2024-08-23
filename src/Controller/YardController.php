<?php

namespace App\Controller;

use App\Entity\Yard;
use App\Entity\Proposal;
use App\Form\YardType;
use App\Repository\YardRepository;
use DateTimeImmutable;
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
    /**
     * Provides an entry point to yards' managing feature. List existing yards.
     */
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        # List only this user's yards.

        // if (!$this->isGranted('ROLE_USER')) 
        // $this->redirectToRoute('APP_REGISTER');

            $user = $this->getUser();
            return $this->render('yard/index.html.twig', [
                'yards' => $yardRepository->findBy(['user' => $user]),
            ]);
      
    }

    #[Route('/new', name: 'app_yard_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /**
         * Creates a new yard, which requires to be an authenticated user.
         */
        if (!$this->isGranted('ROLE_USER')) 
        return $this->render('yard/need-to-register.html.twig');

        $yard = new Yard();
        $form = $this->createForm(YardType::class, $yard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yard->setCreationDate(new DateTimeImmutable('now'));
            $yard->setUser($this->getUser());
            $yard->setProposal(Proposal::Estimate);
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
        /**
         * Show a yard's details.
         */
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('yard/show.html.twig', [
            'yard' => $yard,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_yard_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Yard $yard, EntityManagerInterface $entityManager): Response
    {
        /**
         *  Edits a existing yard to update current value(s) and/or add a nullable value.
         */
        $this->denyAccessUnlessGranted('ROLE_USER');
        // ajouter tester si c'est le sien vraiùment TODO
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
        /**
         * Deletes a specific yard from the database.
         */
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isCsrfTokenValid('delete' . $yard->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($yard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_yard_index', [], Response::HTTP_SEE_OTHER);
    }
}
