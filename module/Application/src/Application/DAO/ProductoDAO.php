<?php
namespace Application\DAO;

use Doctrine\ORM\EntityManager, Application\Classes\Conexion;
// use Talentohumano\Data\ProductoData;
use Application\Data\ProductoData;
// use Doctrine\ORM\Tools\Pagination\Paginator;
class ProductoDAO extends Conexion
{

    private $table_name = 'producto';
    /* ----------------------------------------------------------------------------- */
    public function getTodos($tipo)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "  SELECT * ";
        $sql .= " FROM producto ";
        $sql .= "  WHERE 1 = 1";
        $sql .= " ORDER BY producto.nombre";
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
     * @param ProductoData $ProductoData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function ingresar(ProductoData $ProductoData)
	/*-----------------------------------------------------------------------------*/
	{
        $key = array(
            'id' => $ProductoData->getId()
        );
        $record = array(
            'id'              => $ProductoData->getId(),
            'nombre'          => $ProductoData->getNombre(),
            'telefono_movil'  => $ProductoData->getTelefonoMovil(),
            'telefono_fijo'   => $ProductoData->getTelefonoFijo(),
            'descripcion'     => $ProductoData->getDescripcion(),
            'localidad'       => $ProductoData->getLocalidad(),
            'pagina_web'      => $ProductoData->getWeb(),
            'localizacion_latitud'=> $ProductoData->getLocalizacionLatitud(),
            'localizacion_longitud'=> $ProductoData->getLocalizacionLongitud(),
             
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
     * @param ProductoData $ProductoData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function modificar_cuenta(ProductoData $ProductoData)
	/*-----------------------------------------------------------------------------*/
	{
        $key = array(
            'id' => $ProductoData->getId()
        );
        $record = array(
           
            'nombre'          => $ProductoData->getNombre(),
            'telefono_movil'  => $ProductoData->getTelefonoMovil(),
            'telefono_fijo'   => $ProductoData->getTelefonoFijo(),
            'descripcion'     => $ProductoData->getDescripcion(),
            'localidad'       => $ProductoData->getLocalidad(),
            'pagina_web'      => $ProductoData->getWeb(),
            'localizacion_latitud'=> $ProductoData->getLocalizacionLatitud(),
            'localizacion_longitud'=> $ProductoData->getLocalizacionLongitud(),
             
        );
        $em = $this->getEntityManager();
        $em->getConnection()->update($this->table_name, $record, $key);
        return $ProductoData->getId();
    } // end function modificar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Eliminar
     *
     * @param ProductoData $ProductoData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function inactivar(ProductoData $ProductoData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $ProductoData->getId()
        );
        $record = array(
            
            'estado' => "I",
            'fecha_mod' => \Application\Classes\Fecha::getFechaHoraActualServidor(),
            'usuario_mod_id' => $ProductoData->getUsuarioModId()
        );
        $em = $this->getEntityManager();
        $em->getConnection()->update($this->table_name, $record, $key);
        return $ProductoData->getId();
    } // end function eliminar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Activar
     *
     * @param ProductoData $ProductoData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function activar(ProductoData $ProductoData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $ProductoData->getId()
        );
        $record = array(
            'estado' => "A",
            'fecha_mod' => \Application\Classes\Fecha::getFechaHoraActualServidor(),
            'usuario_mod_id' => $ProductoData->getUsuarioModId()
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
    public function eliminar(ProductoData $ProductoData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $ProductoData->getId()
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
     * @return array Retorna un Array ($ProductoData, $ProductoDataIng, $ProductoDataMod)
     */
    public function consultar($id)
    {
        /* ----------------------------------------------------------------------------- */
        $ProductoData = new ProductoData();
        
        // $this->getEntityManager()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        $sql = "SELECT user.id,user.fullName";
        $sql .= " FROM user ";
        $sql .= " WHERE user.id = :id ";
        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(); // Se utiliza el fecth por que es un registro
        if ($row) {
            $ProductoData->setId($row['id']);
            $ProductoData->setFullName($row['fullName']);
        } // end if
        
        return $ProductoData;
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

