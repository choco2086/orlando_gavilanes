<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use Application\BO\NegocioBO;
use Doctrine\ORM\EntityManager;
use Application\Data\NegocioData;
use Zend\Authentication\AuthenticationService;

class ListadogeneralController extends AbstractActionController
{

    protected $_objectManager;

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    
    
    
}//end controller 