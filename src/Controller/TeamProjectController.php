<?php

namespace App\Controller;

use App\Entity\TeamProject;
use App\Form\TeamProjectType;
use App\Repository\TeamProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teamproject")
 */
class TeamProjectController extends AbstractController
{
    /**
     * @Route("/", name="team_project_index", methods={"GET"})
     */
    public function index(TeamProjectRepository $teamProjectRepository): Response
    {
        return $this->render('team_project/index.html.twig', [
            'team_projects' => $teamProjectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="team_project_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $teamProject = new TeamProject();
        $form = $this->createForm(TeamProjectType::class, $teamProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teamProject);
            $entityManager->flush();

            return $this->redirectToRoute('team_project_index');
        }

        return $this->render('team_project/new.html.twig', [
            'team_project' => $teamProject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_project_show", methods={"GET"})
     */
    public function show(TeamProject $teamProject): Response
    {
        return $this->render('team_project/show.html.twig', [
            'team_project' => $teamProject,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="team_project_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TeamProject $teamProject): Response
    {
        $form = $this->createForm(TeamProjectType::class, $teamProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('team_project_index');
        }

        return $this->render('team_project/edit.html.twig', [
            'team_project' => $teamProject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_project_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TeamProject $teamProject): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teamProject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($teamProject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_project_index');
    }
}
