<?php
namespace Application\BO;

use Application\DAO\PersonaDAO;
use Application\Classes\Conexion;
use Application\Data\PersonaData;

class PersonaBO extends Conexion
{
    
    /* ----------------------------------------------------------------------------- */
    function ingresar(PersonaData $PersonaData)
    {
        /* ----------------------------------------------------------------------------- */
        $PersonaDAO = new PersonaDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $PersonaDAO->setEntityManager($em);
            $id = $PersonaDAO->ingresar($PersonaData);
            $em->getConnection()->commit();
            return $id;
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $em->close();
            throw $e;
            exit();
        }
    } // end function ingresar
    
    
    /* ----------------------------------------------------------------------------- */
    function ingresar_cuenta(PersonaData $PersonaData)
    {
        /* ----------------------------------------------------------------------------- */
        $PersonaDAO = new PersonaDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $PersonaDAO->setEntityManager($em);
            $id = $PersonaDAO->ingresar_cuenta($PersonaData);
            $em->getConnection()->commit();
            return $id;
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $em->close();
            throw $e;
            exit();
        }
    } // end function ingresar
    
    
    
    /* ----------------------------------------------------------------------------- */
    function modificar_cuenta(PersonaData $PersonaData)
    {
        /* ----------------------------------------------------------------------------- */
        $PersonaDAO = new PersonaDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $PersonaDAO->setEntityManager($em);
            
           // die(var_dump($expression));
            $id = $PersonaDAO->modificar_cuenta($PersonaData);
            $em->getConnection()->commit();
            return $id;
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $em->close();
            throw $e;
            exit();
        }
    } // end function ingresar
    
    
    
    
    /* ----------------------------------------------------------------------------- */
    function modificar(PersonaData $PersonaData)
    {
        /* ----------------------------------------------------------------------------- */
        $PersonaDAO = new PersonaDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        
        try {
            $PersonaDAO->setEntityManager($this->getEntityManager());
            $id = $PersonaDAO->modificar($PersonaData);
            $em->getConnection()->commit();
            return $id;
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $em->close();
            throw $e;
        }
    } // end function modificar
      
    // Coloca el registro en estado inactivo
    /* ----------------------------------------------------------------------------- */
    function inactivar(PersonaData $PersonaData)
    {
        /* ----------------------------------------------------------------------------- */
        $PersonaDAO = new PersonaDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $PersonaDAO->setEntityManager($this->getEntityManager());
            $id = $PersonaDAO->eliminar($PersonaData);
            $em->getConnection()->commit();
            return $id;
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $em->close();
            throw $e;
        }
    } // end function eliminar
      
    // Elimina fisicamente de la base
    /* ----------------------------------------------------------------------------- */
    function eliminar(PersonaData $PersonaData)
    {
        $PersonaDAO = new PersonaDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $PersonaDAO->setEntityManager($em);
            $PersonaDAO->eliminar($PersonaData);
            $em->getConnection()->commit();
            return $id;
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $em->close();
            throw $e;
        }
    } // end function eliminar
    /* ----------------------------------------------------------------------------- */
    
    
    
    /* ----------------------------------------------------------------------------- */
    function consultar($id)
    {
        $PersonaDAO = new PersonaDAO();
        $PersonaDAO->setEntityManager($this->getEntityManager());
        $PersonaData = $PersonaDAO->consultar($id);
        return $PersonaData;
    } // end function consultar
    
    
    
    /* ----------------------------------------------------------------------------- */
    function consultar_cuenta($email)
    {
        $PersonaDAO = new PersonaDAO();
        $PersonaDAO->setEntityManager($this->getEntityManager());
        $PersonaData = $PersonaDAO->consultar_cuenta($email);
        return $PersonaData;
    } // end function consultar
    
    
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Listado
     *
     * @param string $opcion            
     * @param array $condiciones            
     * @return array
     */
    function listado($condiciones)
    {
        $PersonaDAO = new PersonaDAO();
        $PersonaDAO->setEntityManager($this->getEntityManager());
        $result = $PersonaDAO->listado($condiciones);
        return $result;
    } // end function listado
    
    /* ----------------------------------------------------------------------------- */
    function getCboEstado($estado)
    {
        /* ----------------------------------------------------------------------------- */
        $arrData = array(
            "A" => "ACTIVO",
            "I" => "INACTIVO"
        );
        $opciones = \Application\Classes\Combo::getComboDataArray($arrData, $estado, '', '');
        return $opciones;
    } // end function getCboEstado
    
    /* ----------------------------------------------------------------------------- */
    public function getComboCategorias($id,$tipo, $texto_1er_elemento = '&lt;Seleccione&gt;', $color_1er_elemento = '#FFFFAA')
	/*-----------------------------------------------------------------------------*/		
	{
        $PersonaDAO = new PersonaDAO();
        $PersonaDAO->setEntityManager($this->getEntityManager());
        $result = $PersonaDAO->getCategorias('');
        $opcions = \Application\Classes\Combo::getComboDataResultset($result, 'id', 'nombre', $id, $texto_1er_elemento, $color_1er_elemento);
        
        return $opcions;
    } // end function
    
    
}//end class BancoBO
