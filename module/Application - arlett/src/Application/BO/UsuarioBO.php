<?php
namespace Application\BO;

use Application\DAO\UsuarioDAO;
use Application\Classes\Conexion;
use Application\Data\UserData;

class UsuarioBO extends Conexion
{
    
    /* ----------------------------------------------------------------------------- */
    function ingresar(UserData $UserData)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $UsuarioDAO->setEntityManager($em);
            $id = $UsuarioDAO->ingresar($UserData);
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
    function modificar(UserData $UserData)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        
        try {
            $UsuarioDAO->setEntityManager($this->getEntityManager());
            $id = $UsuarioDAO->modificar($UserData);
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
    function inactivar(UserData $UserData)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $UsuarioDAO->setEntityManager($this->getEntityManager());
            $id = $UsuarioDAO->eliminar($UserData);
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
    function eliminar(UserData $UserData)
    {
        $UsuarioDAO = new UsuarioDAO();
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        try {
            $UsuarioDAO->setEntityManager($em);
            $UsuarioDAO->eliminar($UserData);
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
        $UsuarioDAO = new UsuarioDAO();
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $UserData = $UsuarioDAO->consultar($id);
        return $UserData;
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
        $UsuarioDAO = new UsuarioDAO();
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $result = $UsuarioDAO->listado($condiciones);
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
        $UsuarioDAO = new UsuarioDAO();
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $result = $UsuarioDAO->getCategorias('');
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
