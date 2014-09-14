<?php
namespace Application\DAO;

use Doctrine\ORM\EntityManager, Application\Classes\Conexion;
// use Talentohumano\Data\PersonaData;
use Application\Data\PersonaData;
// use Doctrine\ORM\Tools\Pagination\Paginator;
class PersonaDAO extends Conexion
{

    private $table_name = 'persona';
    /* ----------------------------------------------------------------------------- */
    public function getPersona($tipo)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "  SELECT categoria.id,categoria.nombre ";
        $sql .= " FROM categoria ";
        $sql .= "  WHERE 1 = 1";
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
     * @param PersonaData $PersonaData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function ingresar_cuenta(PersonaData $PersonaData)
	/*-----------------------------------------------------------------------------*/
	{
        $key = array(
            'id' => $PersonaData->getId()
        );
        $record = array(
            'id'              => $PersonaData->getId(),
            'nombre'          => $PersonaData->getNombre(),
            'telefono'        => $PersonaData->getTelefono(),
            'email'           => $PersonaData->getEmail(),
            'clave'           => $PersonaData->getClave(),
            
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
     * @param PersonaData $PersonaData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function modificar_cuenta(PersonaData $PersonaData)
	/*-----------------------------------------------------------------------------*/
	{
        $key = array(
            'id' => $PersonaData->getId()
        );
        $record = array(
            'nombre'          => $PersonaData->getNombre(),
            'telefono'        => $PersonaData->getTelefono(),
            'email'           => $PersonaData->getEmail(),
            'clave'           => $PersonaData->getClave(),
            
        );
        $em = $this->getEntityManager();
        $em->getConnection()->update($this->table_name, $record, $key);
        return $PersonaData->getId();
    } // end function modificar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Eliminar
     *
     * @param PersonaData $PersonaData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function inactivar(PersonaData $PersonaData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $PersonaData->getId()
        );
        $record = array(
            
            'estado' => "I",
            'fecha_mod' => \Application\Classes\Fecha::getFechaHoraActualServidor(),
            'usuario_mod_id' => $PersonaData->getUsuarioModId()
        );
        $em = $this->getEntityManager();
        $em->getConnection()->update($this->table_name, $record, $key);
        return $PersonaData->getId();
    } // end function eliminar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Activar
     *
     * @param PersonaData $PersonaData            
     * @return array Retorna un Array $key el cual contiene el id
     */
    public function activar(PersonaData $PersonaData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $PersonaData->getId()
        );
        $record = array(
            'estado' => "A",
            'fecha_mod' => \Application\Classes\Fecha::getFechaHoraActualServidor(),
            'usuario_mod_id' => $PersonaData->getUsuarioModId()
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
    public function eliminar(PersonaData $PersonaData)
    {
        /* ----------------------------------------------------------------------------- */
        $key = array(
            'id' => $PersonaData->getId()
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
     * @return array Retorna un Array ($PersonaData, $PersonaDataIng, $PersonaDataMod)
     */
    public function consultar($id)
    {
        /* ----------------------------------------------------------------------------- */
        $PersonaData = new PersonaData();
        
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
            $PersonaData->setId($row['id']);
            $PersonaData->setFullName($row['fullName']);
        } // end if
        
        return $PersonaData;
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

