<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use Application\BO\NegocioBO;
use Doctrine\ORM\EntityManager;
use Application\Data\NegocioData;
use Zend\Authentication\AuthenticationService;

class NegocioController extends AbstractActionController
{

    protected $_objectManager;

    public function indexAction()
    {
        
        /*$parametro = 1;
        
        if ($parametro) {
            $this->plugin('redirect')->toRoute('negocio', [
                'action' => 'add'
            ], [
                'query' => [
                    'param' => $parametro
                ]
            ]);
        }
        */
        
        
        
        
        
        
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function addAction()
    {   
        $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $NegocioBO = new NegocioBO();
        $NegocioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $persona_id=$SesionUsuarioPlugin->getId();
        
        // este parametro va a venir y me dira si es empresa ,urbano,evento o transporte
        $parametro = 1;
        $cbo_categorias = $NegocioBO->getComboCategorias('', $parametro,'&lt;Seleccione una categoria &gt;');
        
        if ($this->request->isPost()) {
            $NegocioData = new NegocioData();
            //$NegocioData->setId($this->getRequest()->getPost('id'));
            $NegocioData->setCategoriaId($this->getRequest()->getPost('categoria_id'));
            $NegocioData->setPersonaId($persona_id);
            $NegocioData->setNombre($this->getRequest()->getPost('nombre'));
            $NegocioData->setDireccion($this->getRequest()->getPost('direccion'));
            $NegocioData->setLocalidad($this->getRequest()->getPost('localidad'));
            $NegocioData->setTelefonoFijo($this->getRequest()->getPost('telefono_fijo'));
            $NegocioData->setTelefonoMovil($this->getRequest()->getPost('telefono_movil'));
            
            $NegocioData->setLocalizacionLatitud($this->getRequest()->getPost('localizacion_latitud'));
            $NegocioData->setLocalizacionLongitud($this->getRequest()->getPost('localizacion_longitud'));
            $NegocioData->setConceptoNegocioId($parametro);
           
            
            $id=$NegocioBO->ingresar($NegocioData);
            //return $this->redirect()->toRoute('home');
            return $this->redirect()->toRoute('negocio',
                    [	'action'=>'edit'
                    ]
                    ,[	'query'=> ['id'=>$id]
                    ]
            );
        }
        
        $viewModel = new ViewModel();
        // $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        // $viewModel->setTerminal(true);
        $this->getServiceLocator()
            ->get('viewhelpermanager')
            ->get('HeadScript')
            ->appendFile('https://maps.googleapis.com/maps/api/js?sensor=true');
       /* $this->getServiceLocator()
        ->get('viewhelpermanager')
        ->get('HeadScript')
        ->appendFile($this->request->getBasePath().'/js/geolocation/jquery-gmaps-latlon-picker.js');
        */
        $this->getServiceLocator()->get('viewhelpermanager')->get('headLink')->appendStylesheet($this->request->getBasePath().'/css/jquery-gmaps-latlon-picker.css');
        // $this->view->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?sensor=true');
        return $viewModel;
    }

    public function editAction()
    {
        //de esta manera extraigo la variable permitida en la url que se configura en module config
        //para seguridad solo deja pasar la variable que se le indica en la ruta en este caso id
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $NegocioBO = new NegocioBO();
        $NegocioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $persona_id=$SesionUsuarioPlugin->getId();
        
        
        if ($this->request->isPost()) {
            $NegocioData = new NegocioData();
            $NegocioData->setId($this->getRequest()->getPost('codigo'));
            $NegocioData->setConceptoNegocioId($this->getRequest()->getPost('concepto_negocio_id'));
            $NegocioData->setCategoriaId($this->getRequest()->getPost('categoria_id'));
            $NegocioData->setPersonaId($persona_id);
            $NegocioData->setNombre($this->getRequest()->getPost('nombre'));
            $NegocioData->setDireccion($this->getRequest()->getPost('direccion'));
            $NegocioData->setLocalidad($this->getRequest()->getPost('localidad'));
            $NegocioData->setTelefonoFijo($this->getRequest()->getPost('telefono_fijo'));
            $NegocioData->setTelefonoMovil($this->getRequest()->getPost('telefono_movil'));
            $NegocioData->setLocalizacionLatitud($this->getRequest()->getPost('localizacion_latitud'));
            $NegocioData->setLocalizacionLongitud($this->getRequest()->getPost('localizacion_longitud'));
           // die(var_dump($NegocioData));
            $respuesta_id=$NegocioBO->modificar($NegocioData);
           // return $this->redirect()->toRoute('home');
           // die(var_dump($id));

            //si quisiera extraer la variable enviada por query
            //$id = $this->getRequest()->getQuery('id', "");
            
            return $this->redirect()->toRoute('negocio',
                    [	'action'=>'edit','id'=>$respuesta_id//asi mando las variables permitidas en module.config
                    ]
                    //,[	'query'=> ['id'=>$id]]//asi mando variables extras
                    
            );
            
            
        }else{
        	$NegocioData=$NegocioBO->consultar($id);
        	//die(var_dump($NegocioData));
        }
        
        //aqui el concepto de negocio es si es empresa,comerciante,transporte,evento
        $cbo_categorias = $NegocioBO->getComboCategorias($NegocioData->getCategoriaId(), $NegocioData->getConceptoNegocioId(),'&lt;Seleccione una categoria &gt;');
       // die(var_dump($cbo_categorias));
        
        
        $cbo_estado=$NegocioBO->getCboEstado($NegocioData->getEstado());
        
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        $viewModel->NegocioData = $NegocioData;
        // $viewModel->setTerminal(true);
        $this->getServiceLocator()
            ->get('viewhelpermanager')
            ->get('HeadScript')
            ->appendFile('https://maps.googleapis.com/maps/api/js?sensor=true');
       /* $this->getServiceLocator()
        ->get('viewhelpermanager')
        ->get('HeadScript')
        ->appendFile($this->request->getBasePath().'/js/geolocation/jquery-gmaps-latlon-picker.js');
        */
        $this->getServiceLocator()->get('viewhelpermanager')->get('headLink')->appendStylesheet($this->request->getBasePath().'/css/jquery-gmaps-latlon-picker.css');
        // $this->view->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?sensor=true');
        return $viewModel;
    }//end modificar


    public function deleteAction()
    {
       /* $id = (int) $this->params()->fromRoute('id', 0);
        // $user = $this->getObjectManager()->find('\Application\Entity\User', $id);
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $NegocioBO = new NegocioBO();
        $NegocioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $user = $NegocioBO->consultar($id);
        $NegocioData = new NegocioData();
        $NegocioData->setId($id);
        if ($this->request->isPost()) {
            // $this->getObjectManager()->remove($user);
            // $this->getObjectManager()->flush();
            $NegocioBO->eliminar($NegocioData);
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel(array(
            'user' => $user
        ));*/
    }

    public function negocioAction()
    {
        /*$EntityManagerPlugin = $this->EntityManagerPlugin();
        $NegocioBO = new NegocioBO();
        $NegocioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $cbo_estado = $NegocioBO->getCboEstado('');
        $cbo_categorias = $NegocioBO->getComboCategorias('6', '1');
        
        if ($this->request->isPost()) {
            $NegocioData = new NegocioData();
            $fullName = $this->getRequest()->getPost('fullname');
            $NegocioData->setFullName($fullName);
            $NegocioBO->ingresar($NegocioData);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            $newId = $NegocioData->getId();
            return $this->redirect()->toRoute('home');
        }
        
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        // $viewModel->setTerminal(true);
        return $viewModel;*/
    }

    public function detallesAction()
    {
      /*  $EntityManagerPlugin = $this->EntityManagerPlugin();
        $NegocioBO = new NegocioBO();
        $NegocioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $cbo_estado = $NegocioBO->getCboEstado('');
        $cbo_categorias = $NegocioBO->getComboCategorias('6', '1');
        
        if ($this->request->isPost()) {
            $NegocioData = new NegocioData();
            $fullName = $this->getRequest()->getPost('fullname');
            $NegocioData->setFullName($fullName);
            $NegocioBO->ingresar($NegocioData);
            // $this->getObjectManager()->persist($user);
            // $this->getObjectManager()->flush();
            $newId = $NegocioData->getId();
            return $this->redirect()->toRoute('home');
        }
        
        $viewModel = new ViewModel();
        $viewModel->cbo_estado = $cbo_estado;
        $viewModel->cbo_categorias = $cbo_categorias;
        // $viewModel->setTerminal(true);
        return $viewModel;*/
    }//end function detalles
    
    
}//end controller 