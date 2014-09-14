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