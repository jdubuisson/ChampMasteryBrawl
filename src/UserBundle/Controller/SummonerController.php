<?php

namespace UserBundle\Controller;

use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\LinkSummonerType;

/**
 * Class SummonerController
 * @package UserBundle\Controller
 */
class SummonerController extends Controller
{
    /**
     * @Route("/link-summoner")
     */
    public function linkAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->getUser();
        if ($user->getSummoner() == null) {
            $form = $this->createForm(LinkSummonerType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $region = $form->getData()['region'];
                    $summoners = $this
                        ->get('dowdow_league_of_legends_api.service_summoner')
                        ->getSummonersByNames(array($form->getData()['name']), $region);
                    $summoner = $summoners[0];
                    $user->setRegion($region);
                    $dbSummoner = $em->getRepository('DowdowLeagueOfLegendsAPIBundle:Summoner')->findById($summoner->getId());

                    if (count($dbSummoner) == 0) {
                        $em->persist($summoner);
                        $user->setSummoner($summoner);
                    } else {
                        $user->setSummoner($dbSummoner[0]);
                    }
                    $em->persist($user);
                    $em->flush();
                } catch (ClientException $ce) {
                    $form->addError(new FormError('error.summoner_not_found'));
                    return $this->render('UserBundle:Summoner:link.html.twig', ['user' => $user, 'form' => $form->createView()]);
                }
            } else {
                return $this->render('UserBundle:Summoner:link.html.twig', ['user' => $user, 'form' => $form->createView()]);
            }
        }
        return $this->redirectToRoute('user_default_profile');
    }
}
