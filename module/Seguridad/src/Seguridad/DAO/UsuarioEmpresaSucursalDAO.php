<?php
namespace Seguridad\DAO;

use Doctrine\ORM\EntityManager, Seguridad\Entity\UsuarioEmpresaCentroCosto, Application\Classes\Conexion;
use Seguridad\Data\UsuarioEmpresaCentroCostoData;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UsuarioEmpresaSucursalDAO extends Conexion
{

    private $page = null;

    private $limit = null;

    private $sidx = null;

    private $sord = null;

    function setPage($valor)
    {
        $this->page = $valor;
    }

    function setLimit($valor)
    {
        $this->limit = $valor;
    }

    function setSidx($valor)
    {
        $this->sidx = $valor;
    }

    function setSord($valor)
    {
        $this->sord = $valor;
    }

    function getPage()
    {
        return $this->page;
    }

    function getLimit()
    {
        return $this->limit;
    }

    function getSidx()
    {
        return $this->sidx;
    }

    function getSord()
    {
        return $this->sord;
    }
    
    /* ----------------------------------------------------------------------------- */
    private function getLimitIni()
    {
        /* ----------------------------------------------------------------------------- */
        return ($this->page - 1) * $this->limit;
    } // end function getLimitIni
    
    /* ----------------------------------------------------------------------------- */
    public function consultarEmpresaPorUsuario($usuario_id)
	/*-----------------------------------------------------------------------------*/	 	
	{
        $sql = 'SELECT usuario_empresa_sucursal.empresa_id, empresa.nombre_corto ' . ' FROM SEGURIDAD.usuario_empresa_sucursal  ' . '      LEFT JOIN GENERAL.empresa_sucursal ' . '            ON  empresa_sucursal.empresa_id 	=   usuario_empresa_sucursal.empresa_id' . '            AND empresa_sucursal.sucursal_id 	=   usuario_empresa_sucursal.sucursal_id' . '      LEFT JOIN GENERAL.empresa ' . '            ON  empresa.id			= empresa_sucursal.empresa_id' . ' WHERE usuario_empresa_sucursal.usuario_id = :usuario_id ' . ' GROUP BY usuario_empresa_sucursal.empresa_id, empresa.nombre_corto ' . ' ORDER BY nombre_corto ASC ';
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
        
        // $this->getEntityManager()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        /*
         * $sql = "SELECT uec.empresa_id empresa_id, e.nombre_corto nombre_corto " ." FROM Seguridad\Entity\UsuarioEmpresaCentroCosto uec " ." LEFT JOIN uec.empresa_sucursal ecc " ." LEFT JOIN ecc.empresa e " ."WHERE uec.usuario_id = :usuario_id " ."GROUP BY uec.empresa_id, e.nombre_corto " ."ORDER BY e.nombre_corto ASC "; $query = $this->getEntityManager()->createQuery($sql); $query->setParameter('usuario_id', $usuario_id); $result = $query->getResult(); return $query->getArrayResult();
         */
    } // end function consultarEmpresaPorUsuario
    
    /* ----------------------------------------------------------------------------- */
    public function consultarSucursalPorEmpresaPorUsuario($usuario_id, $empresa_id)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = 'SELECT  usuario_empresa_sucursal.sucursal_id, sucursal.nombre_corto nombre_corto ' . ' FROM SEGURIDAD.usuario_empresa_sucursal  ' . '      LEFT JOIN GENERAL.empresa_sucursal ' . '            ON  empresa_sucursal.empresa_id  =   usuario_empresa_sucursal.empresa_id' . '            AND empresa_sucursal.sucursal_id =   usuario_empresa_sucursal.sucursal_id' . '  LEFT JOIN GENERAL.sucursal ' . '            ON  sucursal.id		= empresa_sucursal.sucursal_id' . ' WHERE usuario_empresa_sucursal.usuario_id = :usuario_id ' . '   and usuario_empresa_sucursal.empresa_id = :empresa_id ' . ' GROUP BY usuario_empresa_sucursal.sucursal_id, sucursal.nombre_corto ' . ' ORDER BY sucursal.nombre_corto ';
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->bindValue(':empresa_id', $empresa_id);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        return $result;
        
        // $this->getEntityManager()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        /*
         * $sql = "SELECT uec.sucursal_id sucursal_id, cc.nombre_corto nombre_corto " ." FROM Seguridad\Entity\UsuarioEmpresaCentroCosto uec " ." LEFT JOIN uec.empresa_sucursal ecc " ." LEFT JOIN ecc.sucursal cc " ."WHERE uec.usuario_id = :usuario_id " ." and uec.empresa_id = :empresa_id " ."GROUP BY uec.sucursal_id, cc.nombre_corto " ."ORDER BY cc.nombre_corto "; $query = $this->getEntityManager()->createQuery($sql); $query->setParameter('usuario_id', $usuario_id); $query->setParameter('empresa_id', $empresa_id); //$result = $query->getResult(); return $query->getArrayResult();
         */
    } // end function consultarSucursalPorEmpresaPorUsuario
}//end class



