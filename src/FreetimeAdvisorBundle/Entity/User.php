<?php

namespace FreetimeAdvisorBundle\Entity;

use FOS\UserBundle\Model\User as FosUser;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="FreetimeAdvisorBundle\Repository\UserRepository")
 */
class User extends FosUser
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    public function __construct()
    {
        // hérite le constructeur parent
        parent::__construct();
    }

}
