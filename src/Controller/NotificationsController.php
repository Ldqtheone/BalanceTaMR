<?php


namespace App\Controller;

use App\Service\MergeRequestService;
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
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var MergeRequestService
     */
    private MergeRequestService $mergeRequestService;

    /**
     * TeamProjectController constructor.
     * @param EntityManagerInterface $em
     * @param MergeRequestService $mergeRequestService
     */
    function __construct(EntityManagerInterface $em, MergeRequestService $mergeRequestService){

        $this->em = $em;
        $this->mergeRequestService = $mergeRequestService;
    }

    /**
     * @Route("/", name="notifications_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $showMerge = $this->mergeRequestService->getMr();

        return $this->render('merge_requests/index.html.twig', [
            'team_projects' => $showMerge,
        ]);
    }
}