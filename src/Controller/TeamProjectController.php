<?php

namespace App\Controller;

use App\Entity\TeamProject;
use App\Repository\TeamProjectRepository;
use App\Service\GitlabApiService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/updateProject")
 */
class TeamProjectController extends AbstractController
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
     * @Route("/", name="updateProject_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $this->checkProjects();

        return $this->render('team_project/index.html.twig', [
            'team_projects' => $this->teamProjectRepository->findAll(),
        ]);
    }

    /**
     * Check existing projects and push it if not exist
     */
    private function checkProjects(){
        $allProjects = $this->gitlabApiService->getOwnerProject();

        foreach ($allProjects as $project){

            $id = (int)$project['id'];
            $name = $project['name'];

            $projectList = new TeamProject();
            $projectList->setProjectId($id);
            $projectList->setProjectName($name);

            $searchedId = $this->teamProjectRepository->findOneBy(['project_id' => $id]);

            if($searchedId){
                if($searchedId->getProjectId() != $id){
                    $this->em->persist($projectList);
                    $this->em->flush();
                }
            }
            else{
                $this->em->persist($projectList);
                $this->em->flush();
            }
        }
    }
}
