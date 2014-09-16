<?php
namespace Seguridad\BO;

use Seguridad\DAO\ModuloDAO;
use Application\Classes\Conexion;
use Seguridad\Data\ModuloData;

class ModuloBO extends Conexion
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
    function ingresar(ModuloData $ModuloData)
    {
        /* ----------------------------------------------------------------------------- */
        $ModuloDAO = new ModuloDAO();
        
        try {
            $ModuloDAO->setEntityManager($this->getEntityManager());
            $result = $ModuloDAO->setModulo("I", $ModuloData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function ingresar
    
    /* ----------------------------------------------------------------------------- */
    function modificar(ModuloData $ModuloData)
    {
        /* ----------------------------------------------------------------------------- */
        $ModuloDAO = new ModuloDAO();
        
        try {
            $ModuloDAO->setEntityManager($this->getEntityManager());
            $result = $ModuloDAO->setModulo("M", $ModuloData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function modificar
    
    /* ----------------------------------------------------------------------------- */
    function eliminar(ModuloData $ModuloData)
    {
        /* ----------------------------------------------------------------------------- */
        $ModuloDAO = new ModuloDAO();
        
        try {
            $ModuloDAO->setEntityManager($this->getEntityManager());
            $result = $ModuloDAO->setModulo('E', $ModuloData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function eliminar
    
    /* ----------------------------------------------------------------------------- */
    function eliminarMasivo(ModuloData $ModuloData)
    {
        /* ----------------------------------------------------------------------------- */
        $ModuloDAO = new ModuloDAO();
        
        try {
            $ModuloDAO->setEntityManager($this->getEntityManager());
            $result = $ModuloDAO->delModulos('I', $ModuloData->getXmlIds());
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function eliminarMasivo
    
    /* ----------------------------------------------------------------------------- */
    function activarMasivo(ModuloData $ModuloData)
    {
        /* ----------------------------------------------------------------------------- */
        $ModuloDAO = new ModuloDAO();
        
        try {
            $ModuloDAO->setEntityManager($this->getEntityManager());
            $result = $ModuloDAO->delModulos('A', $ModuloData->getXmlIds());
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function activarMasivo
    
    /* ----------------------------------------------------------------------------- */
    function consultar($id)
    {
        /* ----------------------------------------------------------------------------- */
        $ModuloDAO = new ModuloDAO();
        $ModuloDAO->setEntityManager($this->getEntityManager());
        $ModuloData = $ModuloDAO->getModulo($id);
        return $ModuloData;
    } // end function consultar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Listado
     *
     * @param string $opcion            
     * @param array $condiciones            
     * @return array
     */
    function listado($tipoConsulta)
    {
        /* ----------------------------------------------------------------------------- */
        $ModuloDAO = new ModuloDAO();
        
        $ModuloDAO->setEntityManager($this->getEntityManager());
        $ModuloDAO->setPage($this->page);
        $ModuloDAO->setLimit($this->limit);
        $ModuloDAO->setSidx($this->sidx);
        $ModuloDAO->setSord($this->sord);
        
        $result = $ModuloDAO->getModulos($tipoConsulta);
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
        $opcion = "";
        foreach ($arrData as $clave => $valor) {
            $seleccionado = "";
            if ($estado == $clave) {
                $seleccionado = "selected";
            } // end if
            $opcion = $opcion . '<option value="' . $clave . '" ' . $seleccionado . '>' . $valor . '</option>';
        } // end foreach
        
        return $opcion;
    } // end function getCboEstado
    
    /* ----------------------------------------------------------------------------- */
    public function getComboModulo($moduloId)
	/*-----------------------------------------------------------------------------*/
	{
        $ModuloDAO = new ModuloDAO();
        $ModuloDAO->setEntityManager($this->getEntityManager());
        $result = $ModuloDAO->getModulos(2);
        
        $opciones = \Application\Classes\Combo::getComboDataResultset($result, 'id', 'nombre', $moduloId, null, null);
        return $opciones;
    } // end function getComboModulo
} // end class ModuloBO
?>