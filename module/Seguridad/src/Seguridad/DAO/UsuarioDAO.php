<?php
namespace Seguridad\DAO;

use Doctrine\ORM\EntityManager, Seguridad\Entity\Usuario, Application\Classes\Conexion;
use Seguridad\Data\UsuarioData;
use General\Data\PersonaData;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UsuarioDAO extends Conexion
{
    
    /* ----------------------------------------------------------------------------- */
    function login($email, $clave)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "SELECT * ";
        $sql .= " FROM persona ";
        $sql .= " WHERE email = :email";
        $sql .= " and clave = :clave";
        
        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(":email",$email);
        $stmt->bindValue(":clave",$clave);
        $stmt->execute();
        $result = $stmt->fetch();
        
        return $result;
    } // end function login
    
    
    /* ----------------------------------------------------------------------------- */
    function existeCuenta($email)
    /*-----------------------------------------------------------------------------*/
    {
        $sql = "SELECT count(*) as existe ";
        $sql .= " FROM persona ";
        $sql .= " WHERE email = :email";
       
    
        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(":email",$email);
        $stmt->execute();
        $result = $stmt->fetch();
    
        return $result['existe'];
    } // end function login
    
    
    
    
}//end class