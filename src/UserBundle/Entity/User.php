<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="User")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", nullable=true)
     */
    private $googleID;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", nullable=true)
     */
    private $facebookID;

    /**
     * @ORM\ManyToOne(targetEntity="Dowdow\LeagueOfLegendsAPIBundle\Entity\Summoner")
     **/
    private $summoner;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", nullable=true)
     */
    private $region;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastMasteryUpdate", type="datetime", nullable=true)
     */
    private $lastMasteryUpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastTeamUpdate", type="datetime", nullable=true)
     */
    private $lastTeamUpdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="champion1", type="integer", nullable=true)
     */
    private $champion1;

    /**
     * @var integer
     *
     * @ORM\Column(name="champion2", type="integer", nullable=true)
     */
    private $champion2;
    /**
     * @var integer
     *
     * @ORM\Column(name="champion3", type="integer", nullable=true)
     */
    private $champion3;
    /**
     * @var integer
     *
     * @ORM\Column(name="champion4", type="integer", nullable=true)
     */
    private $champion4;
    /**
     * @var integer
     *
     * @ORM\Column(name="champion5", type="integer", nullable=true)
     */
    private $champion5;

    /**
     * @return \DateTime
     */
    public function getLastMasteryUpdate()
    {
        return $this->lastMasteryUpdate;
    }

    /**
     * @param \DateTime $lastMasteryUpdate
     */
    public function setLastMasteryUpdate($lastMasteryUpdate)
    {
        $this->lastMasteryUpdate = $lastMasteryUpdate;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set googleID
     *
     * @param string $googleID
     * @return User
     */
    public function setGoogleID($googleID)
    {
        $this->googleID = $googleID;

        return $this;
    }

    /**
     * Get googleID
     *
     * @return string
     */
    public function getGoogleID()
    {
        return $this->googleID;
    }

    /**
     * Set facebookID
     *
     * @param string $facebookID
     * @return User
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;

        return $this;
    }

    /**
     * Get facebookID
     *
     * @return string
     */
    public function getFacebookID()
    {
        return $this->facebookID;
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

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return int
     */
    public function getChampion1()
    {
        return $this->champion1;
    }

    /**
     * @param int $champion1
     */
    public function setChampion1($champion1)
    {
        $this->champion1 = $champion1;
    }

    /**
     * @return int
     */
    public function getChampion2()
    {
        return $this->champion2;
    }

    /**
     * @param int $champion2
     */
    public function setChampion2($champion2)
    {
        $this->champion2 = $champion2;
    }

    /**
     * @return int
     */
    public function getChampion3()
    {
        return $this->champion3;
    }

    /**
     * @param int $champion3
     */
    public function setChampion3($champion3)
    {
        $this->champion3 = $champion3;
    }

    /**
     * @return int
     */
    public function getChampion4()
    {
        return $this->champion4;
    }

    /**
     * @param int $champion4
     */
    public function setChampion4($champion4)
    {
        $this->champion4 = $champion4;
    }

    /**
     * @return int
     */
    public function getChampion5()
    {
        return $this->champion5;
    }

    /**
     * @param int $champion5
     */
    public function setChampion5($champion5)
    {
        $this->champion5 = $champion5;
    }

    /**
     * @return \DateTime
     */
    public function getLastTeamUpdate()
    {
        return $this->lastTeamUpdate;
    }

    /**
     * @param \DateTime $lastTeamUpdate
     */
    public function setLastTeamUpdate($lastTeamUpdate)
    {
        $this->lastTeamUpdate = $lastTeamUpdate;
    }

}
