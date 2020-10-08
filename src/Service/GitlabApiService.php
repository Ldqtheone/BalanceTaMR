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

    /**
     * GitlabApiService constructor.
     * @param LoggerInterface $logger
     * @param Client $client
     */
    public function __construct(LoggerInterface $logger, Client $client){
        $this->logger = $logger;
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function tokenAuth(){
        $auth = new Client();
        $auth->authenticate('HNtbdHhikjxvHZqzeN-4', Client::AUTH_HTTP_TOKEN);

        return $auth;
    }

    /**
     * @return mixed
     */
    public function getOwnerProject(){
        return $this->tokenAuth()->projects()->all(
            [
                "owned" => true,
                "simple"=> true
            ]
        );
    }

    /**
     * @param int $projectId
     * @return mixed
     */
    public function getMergeByProject(int $projectId){
        return $this->tokenAuth()->mergeRequests()->all($projectId);
    }
}