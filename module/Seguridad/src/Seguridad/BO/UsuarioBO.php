<?php
namespace Seguridad\BO;

use Seguridad\DAO\UsuarioDAO;
use Seguridad\DAO\UsuarioEmpresaSucursalDAO;
use Application\Classes\Conexion;
use Seguridad\Data\UsuarioData;

class UsuarioBO extends Conexion
{

    
    /**
     * Listado
     *
     * @param string $opcion            
     * @param array $condiciones            
     * @return array
     */
    function listado($opcion, $condiciones)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $result = $UsuarioDAO->listado($opcion, $condiciones);
        return $result;
    } // end function listado
    
    
    
    /* ----------------------------------------------------------------------------- */
    function login($usuario, $clave)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $resultDatosUsuario = $UsuarioDAO->login($usuario, $clave);
        return $resultDatosUsuario;
    } // end function login
    
  
    /* ----------------------------------------------------------------------------- */
    function existeCuenta($email)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
    
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $resultDatosUsuario = $UsuarioDAO->existeCuenta($email);
        return $resultDatosUsuario;
    } // end function login
    
    /* ----------------------------------------------------------------------------- */
    function enviarEmailParaActualizarClave($email)
    {
        //aqui se enviara el mail con la direccion url para el cambio de clave
        
        return $true;
    } // end function login
    
    
    
}//end class UsuarioBO
