<?php
namespace Application\BO;

use Application\DAO\NegocioDAO;
use Application\Classes\Conexion;
use Application\Data\NegocioData;

class NegocioBO extends Conexion
{
    
    /* ----------------------------------------------------------------------------- */
    function ingresar(NegocioData $NegocioData)
    {
        /* ----------------------------------------------------------------------------- */
        $NegocioDAO = new NegocioDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $NegocioDAO->setEntityManager($em);
            $id = $NegocioDAO->ingresar($NegocioData);
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
    function modificar(NegocioData $NegocioData)
    {
        /* ----------------------------------------------------------------------------- */
        $NegocioDAO = new NegocioDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        
        try {
            $NegocioDAO->setEntityManager($this->getEntityManager());
            $id = $NegocioDAO->modificar($NegocioData);
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
    function inactivar(NegocioData $NegocioData)
    {
        /* ----------------------------------------------------------------------------- */
        $NegocioDAO = new NegocioDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $NegocioDAO->setEntityManager($this->getEntityManager());
            $id = $NegocioDAO->eliminar($NegocioData);
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
    function eliminar(NegocioData $NegocioData)
    {
        $NegocioDAO = new NegocioDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $NegocioDAO->setEntityManager($em);
            $NegocioDAO->eliminar($NegocioData);
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
        $NegocioDAO = new NegocioDAO();
        $NegocioDAO->setEntityManager($this->getEntityManager());
        $NegocioData = $NegocioDAO->consultar($id);
        return $NegocioData;
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
        $NegocioDAO = new NegocioDAO();
        $NegocioDAO->setEntityManager($this->getEntityManager());
        $result = $NegocioDAO->listado($condiciones);
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
        $NegocioDAO = new NegocioDAO();
        $NegocioDAO->setEntityManager($this->getEntityManager());
        $result = $NegocioDAO->getCategorias($tipo);
        $opcions = \Application\Classes\Combo::getComboDataResultset($result, 'id', 'nombre', $id, $texto_1er_elemento, $color_1er_elemento);
        
        return $opcions;
    } // end function
    
    /* ----------------------------------------------------------------------------- */
    public function getComboTipoCuentaBancaria($id, $texto_1er_elemento = "&lt;Seleccione&gt;", $color_1er_elemento = "#FFFFAA")
	/*-----------------------------------------------------------------------------*/		
	{
        $arrData = array(
            "AH" => "AHORRO",
            "CC" => "CUENTA CORRIENTE"
        );
        $opciones = \Application\Classes\Combo::getComboDataArray($arrData, $id, $texto_1er_elemento, $color_1er_elemento);
        return $opciones;
    } // end function getComboTipoCuentaBancaria
}//end class BancoBO
