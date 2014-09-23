<?php
namespace Seguridad\BO;

use Seguridad\DAO\PerfilPermisoDAO;
use Application\Classes\Conexion;

class PerfilPermisoBO extends Conexion
{

    function mantenimiento($opcion, $OpcionData)
    {
        $PerfilPermisoDAO = new PerfilPermisoDAO();
        
        $PerfilPermisoDAO->setEntityManager($this->getEntityManager());
        $result = $PerfilPermisoDAO->mantenimiento($opcion, $OpcionData);
        return $result;
    } // end function obtenerTodo
}//end class EmpresaBO
