<?php

namespace BrawlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use BrawlBundle\Entity\StaticChampion;
use Dowdow\LeagueOfLegendsAPIBundle\Constant\Region;

class StaticDataInitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cmb:static-data-init')
            ->setDescription('updates the database with new static data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $region = Region::EUW;
        $data = $this->getContainer()
            ->get('dowdow_league_of_legends_api.service_staticchampion')
            ->getStaticChampions($region);
        $output->writeln('start import for region '.$region);
        $em = $this->getContainer()->get('doctrine')->getManager();
        foreach ($data->data as $key => $staticChampion) {
            $old = $em->getRepository('BrawlBundle:StaticChampion')->findOneByChampionKey($staticChampion->key);
            if ($old) {
                $em->remove($old);
            }
            $champ = new StaticChampion();
            $champ->setChampionId($staticChampion->id);
            $champ->setChampionKey($staticChampion->key);
            $champ->setChampionName($staticChampion->name);
            $champ->setChampionTitle($staticChampion->title);
            $champ->setRegion($region);
            $em->persist($champ);
            $em->flush();
            $output->writeln($staticChampion->name . ' persisted');
        }
        $output->writeln('endimport for region '.$region);
    }
}