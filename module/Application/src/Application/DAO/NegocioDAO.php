<?php
namespace Application\DAO;

use Doctrine\ORM\EntityManager, Application\Classes\Conexion;
// use Talentohumano\Data\NegocioData;
use Application\Data\NegocioData;
// use Doctrine\ORM\Tools\Pagination\Paginator;
class NegocioDAO extends Conexion
{

    private $table_name = 'negocio_catalogo';
     /* ----------------------------------------------------------------------------- */
    public function getCategorias($tipo)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "  SELECT categoria.id,categoria.nombre ";
        $sql .= " FROM categoria ";
        $sql .= "  WHERE 1 = 1";
        
        switch ($tipo) {
            case 1:
                $sql = $sql . " and categoria.estado_producto_servicio = 1";
                ;
                break;
            
            case 2:
                $sql = $sql . " and categoria.estado_transporte = 1";
                ;
                break;
            
            case 3:
                $sql = $sql . " and categoria.estado_evento = 1";
                ;
                break;
            
            default:
                ;
                break;
        }
        
        $sql .= " ORDER BY categoria.nombre";
        $em = $this->getEntityManager();
        $stmt = $em->getConnection();
        $stmt = $stmt->executeQuery($sql);
        $result = $stmt->fetchAll();
        
        //die(var_dump($result));
        return $result;
    } // end function getTodos
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Ingresar
     *
     * @param NegocioData $NegocioData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function ingresar(NegocioData $NegocioData)
	/*-----------------------------------------------------------------------------*/
	{
	    
	    
	    
        $key = array(
            'id' => $NegocioData->getId()
        );
        $record = array(
            'id'                    => $NegocioData->getId(),
            'categoria_id'          => $NegocioData->getCategoriaId(),
            'persona_id'            => $NegocioData->getPersonaId(),
            'nombre'                => $NegocioData->getNombre(),
            'telefono_movil'        => $NegocioData->getTelefonoMovil(),
            'telefono_fijo'         => $NegocioData->getTelefonoFijo(),
            'direccion'             => $NegocioData->getDireccion(),
            'localidad'             => $NegocioData->getLocalidad(),
            'localizacion_latitud'  => $NegocioData->getLocalizacionLatitud(),
            'localizacion_longitud' => $NegocioData->getLocalizacionLongitud(),
            'concepto_negocio_id'   => $NegocioData->getConceptoNegocioId(),

            'fecha_ingreso'         => date("Y-m-d"),
            'estado'                => 'A',
             
        );
        
      
        
        $em = $this->getEntityManager();
        $em->getConnection()->insert($this->table_name, $record);
        $id = $em->getConnection()->lastInsertId();
        return $id;
    } // end function ingresar
    
    /* ----------------------------------------------------------------------------- */

    
    /**
     * Modificar
     *
     * @param NegocioData $NegocioData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function modificar(NegocioData $NegocioData)
	/*-----------------------------------------------------------------------------*/
	{
        $key = array(
            'id' => $NegocioData->getId()
        );
        $record = array(
            'categoria_id'          => $NegocioData->getCategoriaId(),
            'persona_id'            => $NegocioData->getPersonaId(),
            'nombre'                => $NegocioData->getNombre(),
            'telefono_movil'        => $NegocioData->getTelefonoMovil(),
            'telefono_fijo'         => $NegocioData->getTelefonoFijo(),
            'direccion'             => $NegocioData->getDireccion(),
            'localidad'             => $NegocioData->getLocalidad(),
            'localizacion_latitud'  => $NegocioData->getLocalizacionLatitud(),
            'localizacion_longitud' => $NegocioData->getLocalizacionLongitud(),
            'concepto_negocio_id'   =>$NegocioData->getConceptoNegocioId(),
            'fecha_modificacion'    => date("Y-m-d"),
            //'estado'                => $NegocioData->getEstado(),
             
            
        );
        
        //die(var_dump($record));
        
        $em = $this->getEntityManager();
        $em->getConnection()->update($this->table_name, $record, $key);
        return $NegocioData->getId();
    } // end function modificar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Eliminar
     *
     * @param NegocioData $NegocioData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function inactivar(NegocioData $NegocioData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $NegocioData->getId()
        );
        $record = array(
            
            'estado' => "I",
            'fecha_modificacion' => \Application\Classes\Fecha::getFechaHoraActualServidor(),
           
        );
        $em = $this->getEntityManager();
        $em->getConnection()->update($this->table_name, $record, $key);
        return $NegocioData->getId();
    } // end function eliminar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Activar
     *
     * @param NegocioData $NegocioData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function activar(NegocioData $NegocioData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $NegocioData->getId()
        );
        $record = array(
            'estado' => "A",
            'fecha_mod' => \Application\Classes\Fecha::getFechaHoraActualServidor(),
            'usuario_mod_id' => $NegocioData->getUsuarioModId()
        );
        $em = $this->getEntityManager();
        $em->getConnection()->update($this->table_name, $record, $key);
        return $key;
    } // end function activar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Eliminar
     *
     * @param int $empresa_id            
     * @param int $rol_cab_sec            
     * @param int $persona_id            
     * @param int $rubro_id            
     * @return array $key ($empresa_id, $rol_cab_sec, $persona_id, $rubro_id)
     */
    public function eliminar(NegocioData $NegocioData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $NegocioData->getId()
        );
        $em = $this->getEntityManager();
        $em->getConnection()->delete($this->table_name, $key);
        return $key;
    } // end function eliminar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Consultar
     *
     * @param int $area_id            
     * @return array Retorna un Array ($NegocioData, $NegocioDataIng, $NegocioDataMod)
     */
    public function consultar($id)
    {
        /* ----------------------------------------------------------------------------- */
        $NegocioData = new NegocioData();
        
        // $this->getEntityManager()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        $sql = "SELECT *";
        $sql .= " FROM negocio_catalogo negocio ";
        $sql .= " WHERE negocio.id = :id ";
        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(); // Se utiliza el fecth por que es un registro
        if ($row) {
            $NegocioData->setId($row['id']);
            $NegocioData->setNombre($row['nombre']);
            
          
            $NegocioData->setId($row['id']);
            $NegocioData->setCategoriaId($row['categoria_id']);
            $NegocioData->setPersonaId($row['persona_id']);
            $NegocioData->setDireccion($row['direccion']);
            $NegocioData->setLocalidad($row['localidad']);
            $NegocioData->setTelefonoFijo($row['telefono_fijo']);
            $NegocioData->setTelefonoMovil($row['telefono_movil']);
            $NegocioData->setLocalizacionLatitud($row['localizacion_latitud']);
            $NegocioData->setLocalizacionLongitud($row['localizacion_longitud']);
            $NegocioData->setConceptoNegocioId($row['concepto_negocio_id']);
            $NegocioData->setEstado($row['estado']);
            
        } // end if
        
        return $NegocioData;
    } // end function consultar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Listado
     *
     * @param array $condiciones            
     * @return array
     */
    public function listado($condiciones)
    {
        /* ----------------------------------------------------------------------------- */
        // $this->getEntityManager()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        $sql = ' SELECT User.* ';
        $sql .= ' FROM User ';
        $sql .= ' WHERE 1 = 1';
        
        $em = $this->getEntityManager();
        $stmt = $em->getConnection();
        $stmt = $stmt->executeQuery($sql);
        $result = $stmt->fetchAll();
        return $result;
    } // end function listado
}//end class AreaDAO

