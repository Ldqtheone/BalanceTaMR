<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MergeRequestController extends AbstractController
{
    /**
     * Page for a specific Merge Request
     * @Route("/mr", name="merge_request")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $infos = $request->query->all();
        $mrInfo = array();

        // gets all the data from the MR and sends it to the URL args
        // TODO : hide the URL args in some way
        foreach ($infos['slug'] as $info => $val){
            $mrInfo[$info] = $val;
        }

        return $this->render('merge_request/index.html.twig', [
            'controller_name' => 'MergeRequestController',
            'infos' => $mrInfo
        ]);
    }
}
