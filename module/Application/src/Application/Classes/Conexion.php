<?php
namespace Application\Classes;

use Doctrine\ORM\EntityManager;

class Conexion
{

    /**
     *
     * @var Doctrine\ORM\EntityManager
     *
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        return $this->em;
    }
}//end class Conexion
