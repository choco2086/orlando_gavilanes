<?php
namespace Application\BO;

use Application\DAO\ProductoDAO;
use Application\Classes\Conexion;
use Application\Data\ProductoData;

class ProductoBO extends Conexion
{
    
    /* ----------------------------------------------------------------------------- */
    function ingresar(ProductoData $ProductoData)
    {
        /* ----------------------------------------------------------------------------- */
        $ProductoDAO = new ProductoDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $ProductoDAO->setEntityManager($em);
            $id = $ProductoDAO->ingresar($ProductoData);
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
    function modificar(ProductoData $ProductoData)
    {
        /* ----------------------------------------------------------------------------- */
        $ProductoDAO = new ProductoDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        
        try {
            $ProductoDAO->setEntityManager($this->getEntityManager());
            $id = $ProductoDAO->modificar($ProductoData);
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
    function inactivar(ProductoData $ProductoData)
    {
        /* ----------------------------------------------------------------------------- */
        $ProductoDAO = new ProductoDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $ProductoDAO->setEntityManager($this->getEntityManager());
            $id = $ProductoDAO->eliminar($ProductoData);
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
    function eliminar(ProductoData $ProductoData)
    {
        $ProductoDAO = new ProductoDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $ProductoDAO->setEntityManager($em);
            $ProductoDAO->eliminar($ProductoData);
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
        $ProductoDAO = new ProductoDAO();
        $ProductoDAO->setEntityManager($this->getEntityManager());
        $ProductoData = $ProductoDAO->consultar($id);
        return $ProductoData;
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
        $ProductoDAO = new ProductoDAO();
        $ProductoDAO->setEntityManager($this->getEntityManager());
        $result = $ProductoDAO->listado($condiciones);
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
    function getCboTipoPrecio($tipo_precio_id)
    {
        /* ----------------------------------------------------------------------------- */
        $arrData = array(
                "F" => "Precio Fijo",
                "N" => "Negociable",
                "G" => "Gratuito"
        );
        $opciones = \Application\Classes\Combo::getComboDataArray($arrData, $tipo_precio_id, '', '');
        return $opciones;
    } // end function getCboEstado
      
    
    
    
    /* ----------------------------------------------------------------------------- */
    public function getComboCategorias($id,$tipo, $texto_1er_elemento = '&lt;Seleccione&gt;', $color_1er_elemento = '#FFFFAA')
	/*-----------------------------------------------------------------------------*/		
	{
        $ProductoDAO = new ProductoDAO();
        $ProductoDAO->setEntityManager($this->getEntityManager());
        $result = $ProductoDAO->getCategorias('');
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
