<?php
namespace Seguridad\Controller;

use Seguridad\BO\UsuarioBO;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\Session\Container;
use Application\BO\PersonaBO;
use Application\Data\PersonaData;

class LoginController extends AbstractActionController
{

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    /* protected $em; */
    /*
    private function capturaDatosRedUsuario()
    {
        $nombreHost = "";
        $ipFinalUsuario = "";
        	
        if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $ipUsuario = explode(',',$_SERVER["HTTP_X_FORWARDED_FOR"]);
    
            for($i=0; $i<count($ipUsuario); $i++)
            {
                if(trim($ipUsuario[$i])!="127.0.0.1" && isset($ipUsuario[$i]))
                    {
                    if($i>0)
                    {
                    $ipFinalUsuario .= ",";
                }
                $ipFinalUsuario .= $ipUsuario[$i];
                $tmp = gethostbyaddr($ipUsuario[$i]);
                if(isset($tmp))
                {
                $nombreHost = gethostbyaddr($ipUsuario[$i]);
        }
        }
     			}
     			$this->_ipAcceso = $ipFinalUsuario;
     			$this->_nombreHost = $nombreHost;
     			}
     			else
     			{
     			$this->_ipAcceso = $_SERVER["REMOTE_ADDR"];
     			$this->_nombreHost = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
     		}
     		$this->_agenteUsuario = $_SERVER["HTTP_USER_AGENT"];
     	}
     */
   
    /* AUTENTICAR */
    // --------------------------------------------------------------------------
    public function autenticarAction()
    {
        try {
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            
            $UsuarioBO = new UsuarioBO();
            $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            // $UsuarioSesion = $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            
            $request = $this->getRequest();
            //$this->capturaDatosRedUsuario();
            if ($this->getRequest()->isPost()) {
                $EntityManagerPlugin = $this->EntityManagerPlugin();
                $usuario = $this->getRequest()->getPost('email', null);
                $clave = $this->getRequest()->getPost('clave', null);
                if (is_null($usuario) || is_null($clave)) {
                    $this->flashmessenger()->addMessage("Usuario y/o Clave no validos");
                    return $this->redirect()->toRoute('seguridad-login');
                } // end if
                  
                // $result = $UsuarioBO->login($usuario, $clave, $ipAcceso, $nombreHost, $agenteUsuario);
                  // list ($rsUsuario, $rsPermiso) = $UsuarioBO->login($usuario, $clave, $ipAcceso, $nombreHost, $agenteUsuario);
                  
                // aqui logueo al usuario
                
                $persona_array = $UsuarioBO->login($usuario, $clave);
                // aqui cargo los permisos de perfil
                // $menuDinamico = $UsuarioBO->getMenuDinamicoPerfil($rsUsuario['id'], $dispositivo_id, 1);
                // menu segun opciones de perfil
                // $menuDinamico = $UsuarioBO->listadoPerfilOpciones($persona_array['id']);
                //die(var_dump($persona_array));
                if ($persona_array['id'] < 0) {
                    $this->flashmessenger()->addMessage("Acceso no valido");
                    return $this->redirect()->toRoute('seguridad-login');
                } else {
                    
                   // die(var_dump($persona_array));
                    
                    $session = new Container('usuario');
                    $session->offsetSet('id', $persona_array['id']);
                    $session->offsetSet('nombre', $persona_array['nombre']);
                    $session->offsetSet('email', $persona_array['email']);
                    // $session->offsetSet('perfil_id', $persona_array['perfil_id']);
                    // $session->offsetSet('nombre_perfil', $persona_array['nombre_perfil']);
                    
                    //die(var_dump($session->offsetGet('nombre')));
                    
                    // aqui debo redireccionar por que entro al app
                    return $this->redirect()->toRoute('home');
                }
            } // end if
            
            $this->layout('layout/layout_base');
            
            
            /*
             * else { $this->flashmessenger()->addMessage("Acceso no válido"); return $this->redirect()->toRoute('seguridad-login'); } // end if
             */
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        } // end try
    } // end function autenticarAction
    
    /* CREAR CUENTA */
    // --------------------------------------------------------------------------
    public function cuentaAction()
    {
        // $users = $this->getObjectManager()->getRepository('\Application\Entity\User')->findAll();
        if ($this->getRequest()->isPost()) {
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            
            $nombre = $this->getRequest()->getPost('nombre', null);
            $clave = $this->getRequest()->getPost('clave', null);
            $mail = $this->getRequest()->getPost('email', null);
            $telefono = $this->getRequest()->getPost('telefono', null);
            
            $UsuarioBO = new UsuarioBO();
            $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $PersonaBO = new PersonaBO();
            $PersonaBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $PersonaData = new PersonaData();
            $PersonaData->setNombre($nombre);
            $PersonaData->setClave($clave);
            $PersonaData->setEmail($mail);
            $PersonaData->setTelefono($telefono);
             
           $existe_cuenta= $UsuarioBO->existeCuenta($mail);
            
           //die(var_dump($existe_cuenta));
           
             if($existe_cuenta>0){
                 //return $this->redirect()->toRoute('login');
                 
                return $this->redirect()->toRoute('login',
                         [	'action'=>'cuenta'
                         ]
                         ,[	'query'=> ['existe'=>$mail]
                         ]
                 );
                  
             }
            
            // ,[	'query'=> ['exxiste'=>'1']
            $persona_array = $UsuarioBO->login($mail, $clave);
             if (! empty($persona_array)) {
                // aqui debe entrar solo si esta logueado pero para seguir modificara
                $PersonaData->setId($persona_array['id']);
                $PersonaBO->modificar_cuenta($PersonaData);
                return $this->redirect()->toRoute('home');
            } else {
                $PersonaBO->ingresar_cuenta($PersonaData);
                 return $this->redirect()->toRoute('login',
                         [	'action'=>'autenticar'
                         ]
                         
                 );
            } // end if
        }//end if
        
        
        $existe_cuenta = $this->getRequest()->getQuery('existe', "");
       
        $this->layout('layout/layout_base');
        $viewModel = new ViewModel();
        $viewModel->existe_cuenta = $existe_cuenta;
       
        
        
        return $viewModel;
    }
    
    
    
    /* CREAR CUENTA */
    // --------------------------------------------------------------------------
    public function recuperarclaveAction()
    {
            
            
          if ($this->getRequest()->isPost()) {
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            $mail = $this->getRequest()->getPost('email', null);
            $UsuarioBO = new UsuarioBO();
            $UsuarioBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $existe_cuenta= $UsuarioBO->existeCuenta($mail);
            if($existe_cuenta>0){
                 //Se debe crear la funcion para el envio de mail
                $mail_enviado=$UsuarioBO->enviarEmailParaActualizarClave($mail);
                return $this->redirect()->toRoute('seguridad',
                        [	'action'=>'recuperarclave'
                        ]
                        ,[	'query'=> ['existe'=>$mail,'cambio_clave'=>1]
                        ]
                );
    
            }else{
                return $this->redirect()->toRoute('seguridad',
                        [	'action'=>'recuperarclave'
                        ]
                        ,[	'query'=> ['existe'=>$mail,'cambio_clave'=>'']
                        ]
                );
                
            }//end if
            
            }//end if post
            
            
        $this->layout('layout/layout_base');
        $cambio_clave = $this->getRequest()->getQuery('cambio_clave', "");
        $existe_cuenta = $this->getRequest()->getQuery('existe', "");

        $viewModel = new ViewModel();
        $viewModel->cambio_clave = $cambio_clave;
        $viewModel->existe_cuenta = $existe_cuenta;
        return $viewModel;
    }//end function recuperar clave
    
    
    
    
    
    
    /* LOGOUT */
    // --------------------------------------------------------------------------
    public function logoutAction()
    {
        try {
            $plugin = $this->SesionUsuarioPlugin();
            $plugin->logout();
            $this->plugin('redirect')->toRoute('login',
                    [	'action'=>'autenticar','id'=>$id
                    ]
                    /*,[	'query'=> ['contenedor_opcion'=>$contenedor_opcion]
                     ]*/
            );
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
