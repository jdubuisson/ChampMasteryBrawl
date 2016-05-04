<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brawl
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BrawlRepository")
 */
class Brawl
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
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     */
    private $attacker;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     */
    private $defender;

    /**
     * @var integer
     *
     * @ORM\Column(name="attacker_champion1", type="integer", nullable=true)
     */
    private $attackerChampion1;

    /**
     * @var integer
     *
     * @ORM\Column(name="attacker_champion2", type="integer", nullable=true)
     */
    private $attackerChampion2;

    /**
     * @var integer
     *
     * @ORM\Column(name="attacker_champion3", type="integer", nullable=true)
     */
    private $attackerChampion3;

    /**
     * @var integer
     *
     * @ORM\Column(name="attacker_champion4", type="integer", nullable=true)
     */
    private $attackerChampion4;

    /**
     * @var integer
     *
     * @ORM\Column(name="attacker_champion5", type="integer", nullable=true)
     */
    private $attackerChampion5;

    /**
     * @var integer
     *
     * @ORM\Column(name="defender_champion1", type="integer", nullable=true)
     */
    private $defenderChampion1;

    /**
     * @var integer
     *
     * @ORM\Column(name="defender_champion2", type="integer", nullable=true)
     */
    private $defenderChampion2;

    /**
     * @var integer
     *
     * @ORM\Column(name="defender_champion3", type="integer", nullable=true)
     */
    private $defenderChampion3;

    /**
     * @var integer
     *
     * @ORM\Column(name="defender_champion4", type="integer", nullable=true)
     */
    private $defenderChampion4;

    /**
     * @var integer
     *
     * @ORM\Column(name="defender_champion5", type="integer", nullable=true)
     */
    private $defenderChampion5;

    /**
     * @var string
     *
     * @ORM\Column(name="victorious_champion1", type="string", nullable=true)
     */
    private $victoriousChampion1;

    /**
     * @var string
     *
     * @ORM\Column(name="victorious_champion2", type="string", nullable=true)
     */
    private $victoriousChampion2;

    /**
     * @var string
     *
     * @ORM\Column(name="victorious_champion3", type="string", nullable=true)
     */
    private $victoriousChampion3;

    /**
     * @var string
     *
     * @ORM\Column(name="victorious_champion4", type="string", nullable=true)
     */
    private $victoriousChampion4;

    /**
     * @var string
     *
     * @ORM\Column(name="victorious_champion5", type="string", nullable=true)
     */
    private $victoriousChampion5;

    /**
     * @var string
     *
     * @ORM\Column(name="victorious_user", type="string", nullable=true)
     */
    private $victoriousUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAttacker()
    {
        return $this->attacker;
    }

    /**
     * @param mixed $attacker
     */
    public function setAttacker($attacker)
    {
        $this->attacker = $attacker;
    }

    /**
     * @return mixed
     */
    public function getDefender()
    {
        return $this->defender;
    }

    /**
     * @param mixed $defender
     */
    public function setDefender($defender)
    {
        $this->defender = $defender;
    }

    /**
     * @return int
     */
    public function getAttackerChampion1()
    {
        return $this->attackerChampion1;
    }

    /**
     * @param int $attackerChampion1
     */
    public function setAttackerChampion1($attackerChampion1)
    {
        $this->attackerChampion1 = $attackerChampion1;
    }

    /**
     * @return int
     */
    public function getAttackerChampion2()
    {
        return $this->attackerChampion2;
    }

    /**
     * @param int $attackerChampion2
     */
    public function setAttackerChampion2($attackerChampion2)
    {
        $this->attackerChampion2 = $attackerChampion2;
    }

    /**
     * @return int
     */
    public function getAttackerChampion3()
    {
        return $this->attackerChampion3;
    }

    /**
     * @param int $attackerChampion3
     */
    public function setAttackerChampion3($attackerChampion3)
    {
        $this->attackerChampion3 = $attackerChampion3;
    }

    /**
     * @return int
     */
    public function getAttackerChampion4()
    {
        return $this->attackerChampion4;
    }

    /**
     * @param int $attackerChampion4
     */
    public function setAttackerChampion4($attackerChampion4)
    {
        $this->attackerChampion4 = $attackerChampion4;
    }

    /**
     * @return int
     */
    public function getAttackerChampion5()
    {
        return $this->attackerChampion5;
    }

    /**
     * @param int $attackerChampion5
     */
    public function setAttackerChampion5($attackerChampion5)
    {
        $this->attackerChampion5 = $attackerChampion5;
    }

    /**
     * @return int
     */
    public function getDefenderChampion1()
    {
        return $this->defenderChampion1;
    }

    /**
     * @param int $defenderChampion1
     */
    public function setDefenderChampion1($defenderChampion1)
    {
        $this->defenderChampion1 = $defenderChampion1;
    }

    /**
     * @return int
     */
    public function getDefenderChampion2()
    {
        return $this->defenderChampion2;
    }

    /**
     * @param int $defenderChampion2
     */
    public function setDefenderChampion2($defenderChampion2)
    {
        $this->defenderChampion2 = $defenderChampion2;
    }

    /**
     * @return int
     */
    public function getDefenderChampion3()
    {
        return $this->defenderChampion3;
    }

    /**
     * @param int $defenderChampion3
     */
    public function setDefenderChampion3($defenderChampion3)
    {
        $this->defenderChampion3 = $defenderChampion3;
    }

    /**
     * @return int
     */
    public function getDefenderChampion4()
    {
        return $this->defenderChampion4;
    }

    /**
     * @param int $defenderChampion4
     */
    public function setDefenderChampion4($defenderChampion4)
    {
        $this->defenderChampion4 = $defenderChampion4;
    }

    /**
     * @return int
     */
    public function getDefenderChampion5()
    {
        return $this->defenderChampion5;
    }

    /**
     * @param int $defenderChampion5
     */
    public function setDefenderChampion5($defenderChampion5)
    {
        $this->defenderChampion5 = $defenderChampion5;
    }

    /**
     * @return string
     */
    public function getVictoriousChampion1()
    {
        return $this->victoriousChampion1;
    }

    /**
     * @param string $victoriousChampion1
     */
    public function setVictoriousChampion1($victoriousChampion1)
    {
        $this->victoriousChampion1 = $victoriousChampion1;
    }

    /**
     * @return string
     */
    public function getVictoriousChampion2()
    {
        return $this->victoriousChampion2;
    }

    /**
     * @param string $victoriousChampion2
     */
    public function setVictoriousChampion2($victoriousChampion2)
    {
        $this->victoriousChampion2 = $victoriousChampion2;
    }

    /**
     * @return string
     */
    public function getVictoriousChampion3()
    {
        return $this->victoriousChampion3;
    }

    /**
     * @param string $victoriousChampion3
     */
    public function setVictoriousChampion3($victoriousChampion3)
    {
        $this->victoriousChampion3 = $victoriousChampion3;
    }

    /**
     * @return string
     */
    public function getVictoriousChampion4()
    {
        return $this->victoriousChampion4;
    }

    /**
     * @param string $victoriousChampion4
     */
    public function setVictoriousChampion4($victoriousChampion4)
    {
        $this->victoriousChampion4 = $victoriousChampion4;
    }

    /**
     * @return string
     */
    public function getVictoriousChampion5()
    {
        return $this->victoriousChampion5;
    }

    /**
     * @param string $victoriousChampion5
     */
    public function setVictoriousChampion5($victoriousChampion5)
    {
        $this->victoriousChampion5 = $victoriousChampion5;
    }

    /**
     * @return string
     */
    public function getVictoriousUser()
    {
        return $this->victoriousUser;
    }

    /**
     * @param string $victoriousUser
     */
    public function setVictoriousUser($victoriousUser)
    {
        $this->victoriousUser = $victoriousUser;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

}