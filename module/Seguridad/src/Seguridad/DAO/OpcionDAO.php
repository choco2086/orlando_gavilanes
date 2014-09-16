<?php
namespace Seguridad\DAO;

use Doctrine\ORM\EntityManager;
use Application\Classes\Conexion;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Seguridad\Data\OpcionData;

class OpcionDAO extends Conexion
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
    function getOpcion($id)
    {
        $OpcionData = new OpcionData();
        
        $sql = "EXEC SEGURIDAD.GET_opciones :prmAccion,:prmModuloId,:prmId";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', 3);
        $stmt->bindValue(':prmModuloId', 0);
        $stmt->bindValue(':prmId', $id);
        $stmt->execute();
        
        while ($row = $stmt->fetch()) {
            $OpcionData->setId($id);
            $OpcionData->setModuloId($row['modulo_id']);
            $OpcionData->setNombre($row['nombre']);
            $OpcionData->setTipoOpcion($row['tipo_opcion']);
            $OpcionData->setUrlAcceso($row['url_acceso']);
            $OpcionData->setUrlLogo($row['url_logo']);
            $OpcionData->setOrden($row['nro_orden']);
            $OpcionData->setEstado($row['estado']);
            $OpcionData->setFechaIng($row['fecha_ing']);
            $OpcionData->setFechaMod($row['fecha_mod']);
            $OpcionData->setUsuarioIngId($row['usuario_ing_id']);
            $OpcionData->setUsuarioModId($row['usuario_mod_id']);
        }
        return $OpcionData;
    } // end function getOpcion
    
    /* ----------------------------------------------------------------------------- */
    function getOpciones($tipoConsulta, $moduloId)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_opciones :prmAccion,:prmModuloId";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $tipoConsulta);
        $stmt->bindValue(':prmModuloId', $moduloId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getOpciones
    
    /* ----------------------------------------------------------------------------- */
    function getOpcionesAccionDispositivo($tipoConsulta, $opcionId)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_opciones_accion_dispositivo :prmAccion,:prmOpcionId";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $tipoConsulta);
        $stmt->bindValue(':prmOpcionId', $opcionId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getOpcionesAccionDispositivo
    
    /* ----------------------------------------------------------------------------- */
    function setOpcion($tipoAccion, OpcionData $OpcionData)
	/*-----------------------------------------------------------------------------*/
	{
        $resultado = 0;
        $sql = "EXEC SEGURIDAD.SET_opcion :prmId,:prmModuloId,:prmNombre,:prmTipoOpcion,:prmUrlAcceso,:prmUrlLogo,:prmOrden,:prmEstado,:prmUsuarioId,:prmOpcionAcciones,:prmAccion";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmId', $OpcionData->getId());
        $stmt->bindValue(':prmModuloId', $OpcionData->getModuloId());
        $stmt->bindValue(':prmNombre', $OpcionData->getNombre());
        $stmt->bindValue(':prmTipoOpcion', $OpcionData->getTipoOpcion());
        $stmt->bindValue(':prmUrlAcceso', $OpcionData->getUrlAcceso());
        $stmt->bindValue(':prmUrlLogo', $OpcionData->getUrlLogo());
        $stmt->bindValue(':prmOrden', $OpcionData->getOrden());
        $stmt->bindValue(':prmEstado', $OpcionData->getEstado());
        $stmt->bindValue(':prmUsuarioId', $OpcionData->getUsuarioIngId());
        $stmt->bindValue(':prmOpcionAcciones', $OpcionData->getXmlOpcionAccion());
        $stmt->bindValue(':prmAccion', $tipoAccion);
        $stmt->execute();
        $result = $stmt->fetch();
        $resultado = $result['idTran'];
        return $resultado;
    } // end function setOpcion
    
    /* ----------------------------------------------------------------------------- */
    function delOpciones($accion, $xmlData)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.DEL_opciones :prmAccion,:prmXmlIds";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $accion);
        $stmt->bindValue(':prmXmlIds', $xmlData);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function delOpciones
}
