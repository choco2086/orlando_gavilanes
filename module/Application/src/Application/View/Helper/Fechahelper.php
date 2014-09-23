<?php
namespace Application\View\Helper;

use Seguridad\Controller\Plugin;
use Zend\View\Helper\AbstractHelper;
use Seguridad\Controller\Plugin\SesionUsuarioPlugin;

class Fechahelper extends AbstractHelper
{

    protected $tipo;
    
    // protected $formato;
    public function __invoke($tipo)
    {
        $SesionUsuarioPlugin = new SesionUsuarioPlugin();
        // $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        ///echo $tipo;die();
        if ($SesionUsuarioPlugin->getId()) {
           // echo 'chucha';die();
            switch ($tipo) {
                case 'id':
                    return $SesionUsuarioPlugin->getId();
                    break;
                
                case 'nombre':
                    
                    return $SesionUsuarioPlugin->getNombre();
                    break;
                    ;
                
                case 'email':
                    return $SesionUsuarioPlugin->getEmail();
                    break;
                    ;
                    
                    break;
            } // end switch
        } else {
            return 'no user';
        } // end if
    }
}