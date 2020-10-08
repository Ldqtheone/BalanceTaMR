<?php


namespace App\Service;

use App\Entity\Team;
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
     * MergeRequestService constructor.
     * @param LoggerInterface $logger
     * @param GitlabApiService $gitlabApiService
     */
    public function __construct(LoggerInterface $logger,
                                GitlabApiService $gitlabApiService){
        $this->logger = $logger;
        $this->gitlabApiService = $gitlabApiService;
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

    public function getMrById(){
    }

}