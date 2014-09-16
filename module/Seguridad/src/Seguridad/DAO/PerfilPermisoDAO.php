<?php
namespace Seguridad\DAO;

use Doctrine\ORM\EntityManager;
use Seguridad\Entity\Usuario;
use Application\Classes\Conexion;
use Seguridad\Data\UsuarioData;
use General\Data\PersonaData;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PerfilPermisoDAO extends Conexion
{

    private $perfil_id;

    private $opcion_accion_id;

    private $fecha_ing;

    private $fecha_mod;

    private $usuario_ing_id;

    private $usuario_mod_id;

    function setPerfilId($valor)
    {
        $this->perfil_id = $valor;
    }

    function setOpcionAccionId($valor)
    {
        $this->opcion_accion_id = $valor;
    }

    function setFechaIng($valor)
    {
        $this->fecha_ing = $valor;
    }

    function setFechaMod($valor)
    {
        $this->fecha_mod = $valor;
    }

    function setUsuarioIng($valor)
    {
        $this->usuario_ing_id = $valor;
    }

    function setUsuarioMod($valor)
    {
        $this->usuario_mod_id = $valor;
    }

    function getPerfilId($valor)
    {
        return $this->perfil_id;
    }

    function getOpcionAccionId($valor)
    {
        return $this->opcion_accion_id;
    }

    function getFechaIng($valor)
    {
        return $this->fecha_ing;
    }

    function getFechaMod($valor)
    {
        return $this->fecha_mod;
    }

    function getUsuarioIng($valor)
    {
        return $this->usuario_ing_id;
    }

    function getUsuarioMod($valor)
    {
        return $this->usuario_mod_id;
    }
    
    /* ----------------------------------------------------------------------------- */
    function __construct()
    {
        $this->perfil_id = 0;
        $this->opcion_accion_id = 0;
        $this->fecha_ing = null;
        $this->fecha_mod = null;
        $this->usuario_ing_id = 0;
        $this->usuario_mod_id = 0;
    } // end function constructor general
    
    /* ----------------------------------------------------------------------------- */
    function setPerfilPermiso($tipoAccion, $perfil_id, $opcion_accion_id, $usuario_id)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.SET_perfil_permiso :prmPerfilId,:prmOpcionAccionId,:prmUsuarioId";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmPerfilId', $perfil_id);
        $stmt->bindValue(':prmOpcionAccionId', $opcion_accion_id);
        $stmt->bindValue(':prmUsuarioId', $usuario_id);
        $stmt->bindValue(':prmAccion', $tipoAccion);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        return $result;
    } // end function setPerfilPermiso
    
    /* ----------------------------------------------------------------------------- */
    function getPerfilPermisos($tipoConsulta)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_perfil_permisos_adm :prmAccion,:prmIdPerfil";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $tipoConsulta);
        $stmt->bindValue(':prmIdPerfil', $id);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        return $result;
    } // end function getPerfiles
}

