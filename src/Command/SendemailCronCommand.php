<?php

namespace App\Command;

use App\Service\MergeRequestService;
use App\Service\SendEmailService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendemailCronCommand extends Command
{
    protected static $defaultName = 'sendemail:cron';
    /**
     * @var MergeRequestService
     */
    private MergeRequestService $mergeRequestService;

    public function __construct(MergeRequestService $mergeRequestService)
    {
        parent::__construct();
        $this->mergeRequestService = $mergeRequestService;
    }

    protected function configure()
    {
        $this->setDescription('Send an email to the users about all MRs');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $mrList = $this->mergeRequestService->getMr();

        SendEmailService::sendEmail($mrList);

        $io->success('Notification email successfully sent!');

        return Command::SUCCESS;
    }
}
