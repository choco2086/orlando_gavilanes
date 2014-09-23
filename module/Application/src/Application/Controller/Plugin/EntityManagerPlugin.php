<?php
namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;
// Zend\Authentication\AuthenticationService;
class EntityManagerPlugin extends AbstractPlugin
{

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /* ----------------------------------------------------------------------------- */
    public function setEntityManager(EntityManager $em)
	/*-----------------------------------------------------------------------------*/
    {
        $this->em = $em;
    }
    
    /* ----------------------------------------------------------------------------- */
    public function getEntityManager()
	/*-----------------------------------------------------------------------------*/
    {
        if (null === $this->em) {
            $this->em = $this->getController()
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
            
            // $this->em = $this->getController()->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
}//end class