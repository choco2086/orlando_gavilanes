<?php
namespace Seguridad\Controller\Plugin;

use Seguridad\BO\UsuarioBO;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;

class SesionUsuarioPlugin extends AbstractPlugin
{

    public function getId()
    {
        return $this->getRecord()['id'];
    }

    public function getNombre()
    {
        return $this->getRecord()['nombre'];
    }

    public function getEmail()
    {
        return $this->getRecord()['email'];
    }

   
    /* ----------------------------------------------------------------------------- */
    public function getRecord()
	/*-----------------------------------------------------------------------------*/
	{
        $session = new Container('usuario');
        
        $result = [
            'id' => $session->offsetGet('id'),
            'nombre' => $session->offsetGet('nombre'),
            'email' => $session->offsetGet('email'),
        ];
        return $result;
    } // end function getSessionStorage
    
 	

	

	
    
  
    
    /* ----------------------------------------------------------------------------- */
    public function getPermisoOpcion($opcion_id, $flag_exit = true, $flag_check_login = true)
	/*-----------------------------------------------------------------------------*/
	{
        if ($flag_check_login) {
            if (! $this->isLogin()) {
                return false;
            }
        } // end if
        
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_opcion')) {
            $permiso_opcion = $session->offsetGet('permiso_opcion');
            
            $clave = $opcion_id;
            if (isset($permiso_opcion[$clave])) {
                $valor = $permiso_opcion[$clave];
                if ($valor == 'OK') {
                    return true;
                } // end if
            } // end if
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para PermisoOpcion  opcion_id:' . $opcion_id);
            exit();
        } // end if
        
        return false;
    } // end function getPermisoOpcion
    
  
  
    /* ----------------------------------------------------------------------------- */
    public function getArrayPermisoOpcion($flag_exit = true, $flag_check_login = true)
	/*-----------------------------------------------------------------------------*/
	{
        if ($flag_check_login) {
            if (! $this->isLogin()) {
                return false;
            }
        } // end if
        
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_opcion')) {
            $permiso_opcion = $session->offsetGet('permiso_opcion');
            
            return $permiso_opcion;
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para getArrayPermisoOpcion');
            exit();
        } // end if
        
        return false;
    } // end function getArrayPermisoOpcion
    
  
    /* ----------------------------------------------------------------------------- */
    public function isLogin()
	/*-----------------------------------------------------------------------------*/
	{
        $session = new Container('usuario');
        if (! isset($session)) {
            $this->getController()
                ->flashmessenger()
                ->addMessage("Debe de Iniciar Session");
            $this->getController()
                ->plugin('redirect')
                ->toRoute('home'); // seguridad-login;
            return false;
        }
        return true;
    } // end function isLogin
    
    /* ----------------------------------------------------------------------------- */
    public function logout()
	/*-----------------------------------------------------------------------------*/
	{
        $session = new \Zend\Session\Container();
        $session->getManager()->destroy();
        
        $this->getController()
            ->flashmessenger()
            ->addMessage("Ud. cerró la sesión");
        $this->getController()
            ->plugin('redirect')
            ->toRoute('home'); // seguridad-login;
        
        return true;
    } // end function logout
}//end class