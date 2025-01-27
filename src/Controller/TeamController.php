<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use App\Service\ControllerService;
use App\Service\MergeRequestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/home")
 */
class TeamController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var ControllerService
     */
    private ControllerService $controllerService;

    /**
     * TeamController constructor.
     * @param EntityManagerInterface $em
     * @param ControllerService $controllerService
     */
    public function __construct(EntityManagerInterface $em, ControllerService $controllerService)
    {
        $this->em = $em;
        $this->controllerService = $controllerService;
    }

    /**
     * @Route("/", name="team_index", methods={"GET"})
     * @param TeamRepository $teamRepository
     * @return Response
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="team_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $team = new Team();

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if($this->controllerService->checkFormValidity($form, $team)){
            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_show", methods={"GET"})
     * @param Team $team
     * @param MergeRequestService $mergeRequestService
     * @return Response
     */
    public function show(Team $team, MergeRequestService $mergeRequestService): Response
    {
        $projects = $mergeRequestService->getAllMr($team);

        return $this->render('team/show.html.twig', [
            'projects' => $projects,
            'team' => $team
        ]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Team $team
     * @return Response
     */
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if($this->controllerService->checkFormValidity($form, $team)){
            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods={"DELETE"})
     * @param Request $request
     * @param Team $team
     * @return Response
     */
    public function delete(Request $request, Team $team): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $this->em->remove($team);
            $this->em->flush();
        }

        return $this->redirectToRoute('team_index');
    }
}
