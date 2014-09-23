<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use Application\BO\ProductoBO;
use Doctrine\ORM\EntityManager;
use Application\Data\ProductoData;
use Zend\Authentication\AuthenticationService;

class ProductoController extends AbstractActionController
{

    protected $_objectManager;

    public function indexAction()
    {
        // $users = $this->getObjectManager()->getRepository('\Application\Entity\User')->findAll();

        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        var_dump($SesionUsuarioPlugin->getNombre());
       // $id_usuario = $SesionUsuarioPlugin->getUsuarioId();
         
        $ProductoBO = new ProductoBO();
        $condiciones = null;
        $ProductoBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $users = $ProductoBO->Listado($condiciones);
        $viewModel = new ViewModel();
        $viewModel->users = $users;
        // $viewModel->setTerminal(true);
        return $viewModel;
    }

    
    
    
    public function addAction()
    {
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $ProductoBO = new ProductoBO();
        $ProductoBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $cbo_estado=$ProductoBO->getCboEstado('');
        $CboTipoPrecio=$ProductoBO->getCboTipoPrecio('');
        if ($this->request->isPost()) {
            $ProductoData = new ProductoData();
            $ProductoData->getDescripcion($this->getRequest()->getPost('descripcion'));
            $ProductoData->getPrecio($this->getRequest()->getPost('precio'));
            $ProductoData->getNegocioCatalagoId($this->getRequest()->getPost('negocio_catalogo_id'));
            $ProductoBO->ingresar($ProductoData);
            return $this->redirect()->toRoute('home');
        }
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_tipo_precio = $CboTipoPrecio;
        
        return $viewModel;
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        // $user = $this->getObjectManager()->find('\Application\Entity\User', $id);
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $ProductoBO = new ProductoBO();
        $ProductoBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $user = $ProductoBO->consultar($id);
        
        
     if ($this->request->isPost()) {
            $ProductoData = new ProductoData();
            $ProductoData->getId($this->getRequest()->getPost('codigo'));
            $ProductoData->getDescripcion($this->getRequest()->getPost('descripcion'));
            $ProductoData->getPrecio($this->getRequest()->getPost('precio'));
            $ProductoData->getNegocioCatalagoId($this->getRequest()->getPost('negocio_catalogo_id'));
            $ProductoBO->modificar($ProductoData);
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
        $ProductoBO = new ProductoBO();
        $ProductoBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $user = $ProductoBO->consultar($id);
        $ProductoData = new ProductoData();
        $ProductoData->setId($id);
        if ($this->request->isPost()) {
            // $this->getObjectManager()->remove($user);
            // $this->getObjectManager()->flush();
            $ProductoBO->eliminar($ProductoData);
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel(array(
            'user' => $user
        ));
    }
    
    
    public function negocioAction()
    {
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $ProductoBO = new ProductoBO();
        $ProductoBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $cbo_estado=$ProductoBO->getCboEstado('');
        $cbo_categorias = $ProductoBO->getComboCategorias('6', '1');
    
        if ($this->request->isPost()) {
            $ProductoData = new ProductoData();
            $fullName = $this->getRequest()->getPost('fullname');
            $ProductoData->setFullName($fullName);
            $ProductoBO->ingresar($ProductoData);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            $newId = $ProductoData->getId();
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
        $ProductoBO = new ProductoBO();
        $ProductoBO->setEntityManager($EntityManagerPlugin->getEntityManager());
         if ($this->request->isPost()) {
            $ProductoData = new ProductoData();
            $fullName = $this->getRequest()->getPost('fullname');
            $ProductoData->setFullName($fullName);
            $ProductoBO->ingresar($ProductoData);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            $newId = $ProductoData->getId();
            return $this->redirect()->toRoute('home');
        }
    
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        //$viewModel->setTerminal(true);
        return $viewModel;
    }
    
    
    
    /*
     * protected function getObjectManager() { if (!$this->_objectManager) { $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); } return $this->_objectManager; }
     */
}