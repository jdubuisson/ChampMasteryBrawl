<?php

namespace LoLApiBundle\Service;

use Dowdow\LeagueOfLegendsAPIBundle\Caller\Caller;
use Symfony\Component\DependencyInjection\Container;

class ChampionMasteryService
{

    /**
     * @var Caller
     */
    private $caller;

    /**
     * @var Container
     */
    private $container;

    /**
     * Constructor
     * @param Caller $caller
     * @param Container $container
     */
    public function __construct(Caller $caller, Container $container)
    {
        $this->caller = $caller;
        $this->container = $container;
    }

    /**
     * Retrieves the ChampionMastery data for the given player id
     *
     * @param $summonerId int
     * @param $region string
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     * @return array
     */
    public function getChampionMasteryForSummonerId($summonerId, $region)
    {
        $request = $this->container->getParameter('roots')['championmastery']['championMasteryByPlayerId'];
        $request = str_replace('{playerId}', $summonerId, $request);
        $locationIds = $this->container->getParameter('locationIds');
        $locationId = $locationIds['global'];
        if(array_key_exists($region, $locationIds))
        {
            $locationId = $locationIds[$region];
        }
        $request = str_replace('{locationId}', $locationId, $request);
        $champMasteryData = $this->caller->send($request, $region, array());

        return $champMasteryData;
    }

    /**
     * Get Summoners names by summoners ids
     * @param $ids
     * @param $region
     * @return array
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     */
    public function getSummonersNames($ids, $region)
    {
        $request = $this->container->getParameter('roots')['summoner']['summonerNamesBySummonerIds'];
        $request = str_replace('{summonerIds}', $this->normalizeArray($ids), $request);
        $names = $this->caller->send($request, $region);
        return $this->namesToArray($names);
    }


}