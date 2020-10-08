<?php


namespace App\Service;

use Psr\Log\LoggerInterface;
use Gitlab\Client;

class GitlabApiService
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var Client
     */
    private Client $client;

    public function __construct(LoggerInterface $logger, Client $client){
        $this->logger = $logger;
        $this->client = $client;
    }

    public function tokenAuth(){
        $auth = new Client();
        $auth->authenticate('HNtbdHhikjxvHZqzeN-4', Client::AUTH_HTTP_TOKEN);

        return $auth;
    }

    public function getOwnerProject(){
        return $this->tokenAuth()->projects()->all([
                "owned" => true,
                "simple"=> true]
        );
    }

    public function getMergeByProject(int $projectId){
        return $this->tokenAuth()->mergeRequests()->all($projectId);
    }
}