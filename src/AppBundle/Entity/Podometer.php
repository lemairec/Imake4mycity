<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Podometer
 *
 * @ORM\Table(name="podometer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PodometerRepository")
 */
class Podometer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     *
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    public $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    public $date;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    public $value;

    function get_date(){
        return $this->date->format(' d/m/Y');
    }

    function getCompleteDateStr(){
        return $this->date->format(' d/m/Y h:m');
    }
}
