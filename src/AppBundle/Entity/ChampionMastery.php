<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StaticChampion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ChampionMasteryRepository")
 */
class ChampionMastery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="championId", type="integer")
     */
    private $championId;

    /**
     * @var integer
     *
     * @ORM\Column(name="championLevel", type="integer", nullable=true)
     */
    private $championLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="championPoints", type="integer")
     */
    private $championPoints;

    /**
     * @var integer
     *
     * @ORM\Column(name="championPointsSinceLastLevel", type="integer", nullable=true)
     */
    private $championPointsSinceLastLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="championPointsUntilNextLevel", type="integer", nullable=true)
     */
    private $championPointsUntilNextLevel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="chestGranted", type="boolean", nullable=true)
     */
    private $chestGranted;

    /**
     * @var string
     *
     * @ORM\Column(name="highestGrade", type="string", length=255, nullable=true)
     */
    private $highestGrade;

    /**
     * @var integer
     *
     * @ORM\Column(name="summonerId", type="integer", nullable=true)
     */
    private $lastPlayTime;

    /**
     * @ORM\ManyToOne(targetEntity="Dowdow\LeagueOfLegendsAPIBundle\Entity\Summoner")
     **/
    private $summoner;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getChampionId()
    {
        return $this->championId;
    }

    /**
     * @param int $championId
     */
    public function setChampionId($championId)
    {
        $this->championId = $championId;
    }

    /**
     * @return int
     */
    public function getChampionLevel()
    {
        return $this->championLevel;
    }

    /**
     * @param int $championLevel
     */
    public function setChampionLevel($championLevel)
    {
        $this->championLevel = $championLevel;
    }

    /**
     * @return int
     */
    public function getChampionPoints()
    {
        return $this->championPoints;
    }

    /**
     * @param int $championPoints
     */
    public function setChampionPoints($championPoints)
    {
        $this->championPoints = $championPoints;
    }

    /**
     * @return int
     */
    public function getChampionPointsSinceLastLevel()
    {
        return $this->championPointsSinceLastLevel;
    }

    /**
     * @param int $championPointsSinceLastLevel
     */
    public function setChampionPointsSinceLastLevel($championPointsSinceLastLevel)
    {
        $this->championPointsSinceLastLevel = $championPointsSinceLastLevel;
    }

    /**
     * @return int
     */
    public function getChampionPointsUntilNextLevel()
    {
        return $this->championPointsUntilNextLevel;
    }

    /**
     * @param int $championPointsUntilNextLevel
     */
    public function setChampionPointsUntilNextLevel($championPointsUntilNextLevel)
    {
        $this->championPointsUntilNextLevel = $championPointsUntilNextLevel;
    }

    /**
     * @return boolean
     */
    public function isChestGranted()
    {
        return $this->chestGranted;
    }

    /**
     * @param boolean $chestGranted
     */
    public function setChestGranted($chestGranted)
    {
        $this->chestGranted = $chestGranted;
    }

    /**
     * @return string
     */
    public function getHighestGrade()
    {
        return $this->highestGrade;
    }

    /**
     * @param string $highestGrade
     */
    public function setHighestGrade($highestGrade)
    {
        $this->highestGrade = $highestGrade;
    }

    /**
     * @return int
     */
    public function getLastPlayTime()
    {
        return $this->lastPlayTime;
    }

    /**
     * @param int $lastPlayTime
     */
    public function setLastPlayTime($lastPlayTime)
    {
        $this->lastPlayTime = $lastPlayTime;
    }

    /**
     * @return mixed
     */
    public function getSummoner()
    {
        return $this->summoner;
    }

    /**
     * @param mixed $summoner
     */
    public function setSummoner($summoner)
    {
        $this->summoner = $summoner;
    }



}