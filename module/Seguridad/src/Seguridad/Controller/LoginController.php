<?php
namespace Seguridad\Controller;

use Seguridad\BO\UsuarioBO;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\Session\Container;

class LoginController extends AbstractActionController
{

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    /* protected $em; */
    private $_ipAcceso;

    private $_nombreHost;

    private $_agenteUsuario;
    
    /*
     * public function setEntityManager(EntityManager $em) { $this->em = $em; } public function getEntityManager() { if (null === $this->em) { $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); } return $this->em; }
     */
    private function capturaDatosRedUsuario()
    {
        $nombreHost = "";
        
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ipUsuario = explode(',', $_SERVER["HTTP_X_FORWARDED_FOR"]);
            
            for ($i = 0; $i < count($ipUsuario); $i ++) {
                if (trim($ipUsuario[$i]) != "127.0.0.1" && isset($ipUsuario[$i])) {
                    if ($i > 0) {
                        $ipFinalUsuario .= ",";
                    }
                    $ipFinalUsuario .= $ipUsuario[$i];
                    $tmp = gethostbyaddr($ipUsuario[$i]);
                    if (isset($tmp)) {
                        $nombreHost = gethostbyaddr($ipUsuario[$i]);
                    }
                }
            }
            $this->_ipAcceso = $ipFinalUsuario;
            $this->_nombreHost = $nombreHost;
        } else {
            $this->_ipAcceso = $_SERVER["REMOTE_ADDR"];
            $this->_nombreHost = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
        }
        $this->_agenteUsuario = $_SERVER["HTTP_USER_AGENT"];
    }

    public function autenticarAction()
    {
        try {
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            
            $UsuarioBO = new UsuarioBO();
            $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            
            $request = $this->getRequest();
            $this->capturaDatosRedUsuario();
            if ($this->getRequest()->isPost()) {
                $usuario = $this->getRequest()->getPost('usuario', null);
                $clave = $this->getRequest()->getPost('clave', null);
                $dispositivo_id = 1;
                $ipAcceso = $this->_ipAcceso;
                $nombreHost = $this->_nombreHost;
                $agenteUsuario = $this->_agenteUsuario;
                
                if (is_null($usuario) || is_null($clave)) {
                    $this->flashmessenger()->addMessage("Usuario y/o Clave no válidos");
                    return $this->redirect()->toRoute('seguridad-login');
                } // end if
                  
                // $result = $UsuarioBO->login($usuario, $clave, $ipAcceso, $nombreHost, $agenteUsuario);
                  // list ($rsUsuario, $rsPermiso) = $UsuarioBO->login($usuario, $clave, $ipAcceso, $nombreHost, $agenteUsuario);
                  
                // aqui logueo al usuario
                $persona_array = $UsuarioBO->login($correo, clave);
                // aqui cargo los permisos de perfil
                // $menuDinamico = $UsuarioBO->getMenuDinamicoPerfil($rsUsuario['id'], $dispositivo_id, 1);
                // menu segun opciones de perfil
                $menuDinamico = $UsuarioBO->listadoPerfilOpciones($persona_array['id']);
                
                if ($persona_array['id'] < 0) {
                    $this->flashmessenger()->addMessage("Acceso no válido");
                    return $this->redirect()->toRoute('seguridad-login');
                } else {
                    $session = new Container('usuario');
                    $session->offsetSet('persona_id', $persona_array['id']);
                    $session->offsetSet('nombre', $persona_array['nombre']);
                    $session->offsetSet('perfil_id', $persona_array['perfil_id']);
                    $session->offsetSet('nombre_perfil', $persona_array['nombre_perfil']);
                    
                    // aqui debo redireccionar por que entro al app
                    return $this->redirect()->toRoute('home');
                }
            }             // end if
            
            
            
            
           /* else {
                $this->flashmessenger()->addMessage("Acceso no válido");
                return $this->redirect()->toRoute('seguridad-login');
            } // end if*/
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        } // end try
    } // end function autenticarAction
    
    
    
    
    
    
    
    
    
public function cuentaAction()
    {
        // $users = $this->getObjectManager()->getRepository('\Application\Entity\User')->findAll();
        
        $viewModel = new ViewModel();
        $viewModel->hola = 'hola';
        //$viewModel->setTerminal(true);
        return $viewModel;
    }
    
    
    
    
    
    
    
    
    
    
    /* LOGOUT */
    // --------------------------------------------------------------------------
    public function logoutAction()
    {
        try {
            $plugin = $this->SesionUsuarioPlugin();
            $plugin->logout();
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        } // end try
    } // end public function logoutAction
          // --------------------------------------------------------------------------
}//end controller
