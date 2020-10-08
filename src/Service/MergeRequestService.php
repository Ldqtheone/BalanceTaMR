<?php


namespace App\Service;

use App\Entity\Team;
use Psr\Log\LoggerInterface;


class MergeRequestService
{

    private $logger;

    private $gitlabApiService;

    public function __construct(LoggerInterface $logger,
                                GitlabApiService $gitlabApiService){
        $this->logger = $logger;
        $this->gitlabApiService = $gitlabApiService;
    }

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

}