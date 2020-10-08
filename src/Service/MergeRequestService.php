<?php


namespace App\Service;

use App\Entity\Team;
use App\Repository\TeamProjectRepository;
use Psr\Log\LoggerInterface;


class MergeRequestService
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var GitlabApiService
     */
    private GitlabApiService $gitlabApiService;

    /**
     * @var TeamProjectRepository
     */
    private TeamProjectRepository $teamProjectRepository;

    /**
     * MergeRequestService constructor.
     * @param LoggerInterface $logger
     * @param GitlabApiService $gitlabApiService
     * @param TeamProjectRepository $teamProjectRepository
     */
    public function __construct(LoggerInterface $logger,
                                GitlabApiService $gitlabApiService,
                                TeamProjectRepository $teamProjectRepository){
        $this->logger = $logger;
        $this->gitlabApiService = $gitlabApiService;
        $this->teamProjectRepository = $teamProjectRepository;
    }

    /**
     * @param Team $team
     * @return array
     */
    public function getAllMr(Team $team)
    {
        $projectIds = array();

        foreach ($team->getProjects() as $project){
            $projectIds[] = $project->getProjectId();
        }

        $showMerge = array();

        foreach ($projectIds as $projectId) {
            $showMerge[] = $this->gitlabApiService->getMergeByProject($projectId);
        }

        return $showMerge;
    }

    public function getMr(){

        $showMerge = array();

        foreach ($this->teamProjectRepository->findAll() as $item) {
            if (count($this->gitlabApiService->getMergeByProject($item->getProjectId())) > 1)
                $showMerge[] = $this->gitlabApiService->getMergeByProject($item->getProjectId());
        }

        return $showMerge;
    }

}