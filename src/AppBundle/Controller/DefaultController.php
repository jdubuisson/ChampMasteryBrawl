<?php

namespace AppBundle\Controller;

use Dowdow\LeagueOfLegendsAPIBundle\Constant\Region;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $champions = $this->get('dowdow_league_of_legends_api.service_champion')->getChampions(Region::EUW);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'champs' => $champions,
        ]);
    }
}
