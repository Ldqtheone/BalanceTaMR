<?php


namespace App\Controller;


use App\Repository\TeamProjectRepository;
use App\Service\GitlabApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notifications")
 */
class NotificationsController extends AbstractController
{
    /**
     * @var GitlabApiService
     */
    private GitlabApiService $gitlabApiService;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var TeamProjectRepository
     */
    private TeamProjectRepository $teamProjectRepository;

    /**
     * TeamProjectController constructor.
     * @param GitlabApiService $gitlabApiService
     * @param EntityManagerInterface $em
     * @param TeamProjectRepository $teamProjectRepository
     */

    function __construct(GitlabApiService $gitlabApiService,
                         EntityManagerInterface $em,
                         TeamProjectRepository $teamProjectRepository){

        $this->gitlabApiService = $gitlabApiService;
        $this->em = $em;
        $this->teamProjectRepository = $teamProjectRepository;
    }

    /**
     * @Route("/", name="notifications_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        foreach ($this->teamProjectRepository->findAll() as $item) {
            if (count($this->gitlabApiService->getMergeByProject($item->getProjectId())) > 1)
            $showMerge[] = $this->gitlabApiService->getMergeByProject($item->getProjectId());
        }
        //var_dump($showMerge);
        //die;

        return $this->render('merge_requests/index.html.twig', [
            'team_projects' => $showMerge,
        ]);
    }
}