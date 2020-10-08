<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MergeRequestController extends AbstractController
{
    /**
     * @Route("/mr", name="merge_request")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $title = $request->query->get('title');

        return $this->render('merge_request/index.html.twig', [
            'controller_name' => 'MergeRequestController',
            'title' => $title
        ]);
    }
}
