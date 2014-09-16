<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use Application\BO\UsuarioBO;
use Doctrine\ORM\EntityManager;
use Application\Data\UserData;

class IndexController extends AbstractActionController
{

    protected $_objectManager;

    public function indexAction()
    {
        // $users = $this->getObjectManager()->getRepository('\Application\Entity\User')->findAll();
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $UsuarioBO = new UsuarioBO();
        $condiciones = null;
        $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $users = $UsuarioBO->Listado($condiciones);
        $viewModel = new ViewModel();
        $viewModel->users = $users;
        // $viewModel->setTerminal(true);
        return $viewModel;
    }

    
    
    
    public function addAction()
    {
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $UsuarioBO = new UsuarioBO();
        $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $cbo_estado=$UsuarioBO->getCboEstado('');
        $cbo_categorias = $UsuarioBO->getComboCategorias('6', '1');
      
        if ($this->request->isPost()) {
            $userData = new UserData();
            $fullName = $this->getRequest()->getPost('fullname');
            $userData->setFullName($fullName);
            $UsuarioBO->ingresar($userData);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            $newId = $userData->getId();
            return $this->redirect()->toRoute('home');
        }
        
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        //$viewModel->setTerminal(true);
        return $viewModel;
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        // $user = $this->getObjectManager()->find('\Application\Entity\User', $id);
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $UsuarioBO = new UsuarioBO();
        $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $user = $UsuarioBO->consultar($id);
        if ($this->request->isPost()) {
            $user->setFullName($this->getRequest()
                ->getPost('fullname'));
            $id = $UsuarioBO->modificar($user);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            return $this->redirect()->toRoute('home');
        }
        
        // die(var_dump($user));
        return new ViewModel(array(
            'user' => $user
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        // $user = $this->getObjectManager()->find('\Application\Entity\User', $id);
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $UsuarioBO = new UsuarioBO();
        $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $user = $UsuarioBO->consultar($id);
        $UserData = new UserData();
        $UserData->setId($id);
        if ($this->request->isPost()) {
            // $this->getObjectManager()->remove($user);
            // $this->getObjectManager()->flush();
            $UsuarioBO->eliminar($UserData);
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel(array(
            'user' => $user
        ));
    }
    
    /*
     * protected function getObjectManager() { if (!$this->_objectManager) { $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); } return $this->_objectManager; }
     */
      
    public function negocioAction()
    {
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $UsuarioBO = new UsuarioBO();
        $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $cbo_estado=$UsuarioBO->getCboEstado('');
        $cbo_categorias = $UsuarioBO->getComboCategorias('6', '1');
      
        if ($this->request->isPost()) {
            $userData = new UserData();
            $fullName = $this->getRequest()->getPost('fullname');
            $userData->setFullName($fullName);
            $UsuarioBO->ingresar($userData);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            $newId = $userData->getId();
            return $this->redirect()->toRoute('home');
        }
        
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        //$viewModel->setTerminal(true);
        return $viewModel;
    }
    
    
    public function detallesAction()
    {
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $UsuarioBO = new UsuarioBO();
        $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $cbo_estado=$UsuarioBO->getCboEstado('');
        $cbo_categorias = $UsuarioBO->getComboCategorias('6', '1');
      
        if ($this->request->isPost()) {
            $userData = new UserData();
            $fullName = $this->getRequest()->getPost('fullname');
            $userData->setFullName($fullName);
            $UsuarioBO->ingresar($userData);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            $newId = $userData->getId();
            return $this->redirect()->toRoute('home');
        }
        
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        //$viewModel->setTerminal(true);
        return $viewModel;
    }
    
    
    public function formularioAction()
    {
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $UsuarioBO = new UsuarioBO();
        $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $cbo_estado=$UsuarioBO->getCboEstado('');
        $cbo_categorias = $UsuarioBO->getComboCategorias('6', '1');
      
        if ($this->request->isPost()) {
            $userData = new UserData();
            $fullName = $this->getRequest()->getPost('fullname');
            $userData->setFullName($fullName);
            $UsuarioBO->ingresar($userData);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            $newId = $userData->getId();
            return $this->redirect()->toRoute('home');
        }
        
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        //$viewModel->setTerminal(true);
        return $viewModel;
    }
}