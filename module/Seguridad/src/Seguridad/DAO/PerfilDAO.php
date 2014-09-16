<?php
namespace Seguridad\DAO;

use Doctrine\ORM\EntityManager;
use Seguridad\Entity\Perfil;
use Application\Classes\Conexion;
use Seguridad\Data\PerfilData;

class PerfilDAO extends Conexion
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
    function getPerfil($id)
    {
        $PerfilData = new PerfilData();
        
        $sql = "EXEC SEGURIDAD.GET_perfiles :prmAccion,:prmId";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', 3);
        $stmt->bindValue(':prmId', $id);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $PerfilData->setId($id);
            $PerfilData->setNombre($row['nombre']);
            $PerfilData->setSiglas($row['siglas']);
            $PerfilData->setEstado($row['estado']);
            $PerfilData->setFechaIng($row['fecha_ing']);
            $PerfilData->setFechaMod($row['fecha_mod']);
            $PerfilData->setUsuarioIngId($row['usuario_ing_id']);
            $PerfilData->setUsuarioModId($row['usuario_mod_id']);
        }
        return $PerfilData;
    } // end function constructor con parametro
    function getPerfiles($tipoConsulta)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_perfiles :prmAccion";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $tipoConsulta);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getPerfiles
    
    /* ----------------------------------------------------------------------------- */
    function getPerfilOpcionesAccionDispositivo($tipoConsulta, $perfilId)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_perfil_opciones_accion_dispositivo :prmAccion,:prmPerfilId";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $tipoConsulta);
        $stmt->bindValue(':prmPerfilId', $perfilId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getPerfilOpcionesAccionDispositivo
    
    /* ----------------------------------------------------------------------------- */
    function setPerfil($tipoAccion, PerfilData $PerfilData)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.SET_perfil :prmId,:prmNombre,:prmSiglas,:prmEstado,:prmUsuarioId,:prmPerfilOpcionAcciones,:prmAccion";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmId', $PerfilData->getId());
        $stmt->bindValue(':prmNombre', $PerfilData->getNombre());
        $stmt->bindValue(':prmSiglas', $PerfilData->getSiglas());
        $stmt->bindValue(':prmEstado', $PerfilData->getEstado());
        $stmt->bindValue(':prmUsuarioId', $PerfilData->getUsuarioIngId());
        $stmt->bindValue(':prmPerfilOpcionAcciones', $PerfilData->getXmlPerfilOpcionAccion());
        $stmt->bindValue(':prmAccion', $tipoAccion);
        $stmt->execute();
        $result = $stmt->fetch();
        $resultado = $result['idTran'];
        return $resultado;
    } // end function setPerfil
    
    /* ----------------------------------------------------------------------------- */
    function delPerfiles($accion, $xmlData)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.DEL_perfiles :prmAccion,:prmXmlIds";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $accion);
        $stmt->bindValue(':prmXmlIds', $xmlData);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function delOpciones
    
    /* ----------------------------------------------------------------------------- */
	
	/*
	private function getLimitIni(){
		return ($this->page-1)*$this->limit;
	}
	
	public function modificar(PerfilData $PerfilData){
	}//end function modificar
	
	
	public function getTodos($estado){
		$sql = "SELECT p "
		      ." FROM Seguridad\Entity\Perfil p"
			  ." WHERE 1 = 1";
		if (!empty($estado)){
			  $sql=$sql." and p.estado = :estado";
		}//end if
		$sql=$sql." ORDER BY p.nombre";
		
		$query = $this->getEntityManager()->createQuery($sql);

		if (!empty($estado)){
			$query->setParameter('estado', $estado);
		}//end if
		
		$result = $query->getArrayResult();
		return $result;	
	}//end function getTodos
	
	
	public function listado($opcion, $estado){
		if ($opcion==1){
		//$this->getEntityManager()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());			
			$sql = "SELECT u.id id, u.usuario usuario, u.estado_cambiar_clave estado_cambiar_clave, "
				  ."	   u.estado_permiso_mobil estado_permiso_mobil, u.nro_intentos nro_intentos, u.estado estado, "
				  ."       c.nombre nombre_perfil, p.nombre nombre_persona ";
		}//end if
		if ($opcion==2){
			$sql = "SELECT COUNT(u.id) tot_reg ";
		}//end if
		
		$sql=$sql." FROM Seguridad\Entity\Usuario u"
				 ."  JOIN u.perfil c"
				 ."  LEFT JOIN u.persona_id p "
				 ." WHERE 1 = 1";
		if ($estado!=''){
			  $sql=$sql." and u.estado = :estado";
		}//end if
		
		if ((!empty($this->sidx))&&($opcion==1)) {
			$sql=$sql." ORDER BY ".$this->sidx." ".$this->sord;
		}
		
		$query = $this->getEntityManager()->createQuery($sql);

		if ($opcion==1){
			$query->setFirstResult($this->getLimitIni())
				   ->setMaxResults($this->limit);		
		}//end if
		
		if ($estado!=''){
			$query->setParameter('estado', $estado);
		}//end if
		
		try {
			if ($opcion==1){
				//return $query->getResult();
				return $query->getArrayResult();
			}//end if
		
			if ($opcion==2){
				//$result = $query->getResult();
				$result = $query->getArrayResult();
				$tot_reg = 0;
				foreach ($result as $row){
					$tot_reg = $row["tot_reg"];
				}//end foreach
				return $tot_reg;
			}//end if

		}catch (\Exception $e) {
			 throw new \Exception($e->getMessage().' DQL:' . $query->getDql());
		}
		
	}//end function listado

*/
}//end class

