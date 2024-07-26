<?php

namespace App\Controller;

use App\Entity\TypeSite;
use App\Form\TypeSiteType;
use App\Repository\TypeSiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/type/site')]
class TypeSiteController extends AbstractController
{
    #[Route('/', name: 'app_type_site_index', methods: ['GET'])]
    public function index(TypeSiteRepository $typeSiteRepository): Response
    {
        return $this->render('type_site/index.html.twig', [
            'type_sites' => $typeSiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_site_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeSite = new TypeSite();
        $form = $this->createForm(TypeSiteType::class, $typeSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeSite);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_site_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_site/new.html.twig', [
            'type_site' => $typeSite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_site_show', methods: ['GET'])]
    public function show(TypeSite $typeSite): Response
    {
        return $this->render('type_site/show.html.twig', [
            'type_site' => $typeSite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_site_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeSite $typeSite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeSiteType::class, $typeSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_site_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_site/edit.html.twig', [
            'type_site' => $typeSite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_site_delete', methods: ['POST'])]
    public function delete(Request $request, TypeSite $typeSite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $typeSite->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeSite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_site_index', [], Response::HTTP_SEE_OTHER);
    }
}
