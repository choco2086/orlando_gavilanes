<?php
namespace Seguridad\BO;

use Seguridad\DAO\OpcionDAO;
use Application\Classes\Conexion;
use Seguridad\Data\OpcionData;

class OpcionBO extends Conexion
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
    function ingresar(OpcionData $OpcionData)
    {
        /* ----------------------------------------------------------------------------- */
        $OpcionDAO = new OpcionDAO();
        
        try {
            $OpcionDAO->setEntityManager($this->getEntityManager());
            $result = $OpcionDAO->setOpcion('I', $OpcionData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function ingresar
    
    /* ----------------------------------------------------------------------------- */
    function modificar(OpcionData $OpcionData)
    {
        /* ----------------------------------------------------------------------------- */
        $OpcionDAO = new OpcionDAO();
        
        try {
            $OpcionDAO->setEntityManager($this->getEntityManager());
            $result = $OpcionDAO->setOpcion('M', $OpcionData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function modificar
    
    /* ----------------------------------------------------------------------------- */
    function eliminar(OpcionData $OpcionData)
    {
        /* ----------------------------------------------------------------------------- */
        $OpcionDAO = new OpcionDAO();
        
        try {
            $OpcionDAO->setEntityManager($this->getEntityManager());
            $result = $OpcionDAO->setOpcion('E', $OpcionData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function eliminar
    
    /* ----------------------------------------------------------------------------- */
    function eliminarMasivo(OpcionData $OpcionData)
    {
        /* ----------------------------------------------------------------------------- */
        $OpcionDAO = new OpcionDAO();
        
        try {
            $OpcionDAO->setEntityManager($this->getEntityManager());
            $result = $OpcionDAO->delOpciones('I', $OpcionData->getXmlIds());
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function eliminarMasivo
    
    /* ----------------------------------------------------------------------------- */
    function activarMasivo(OpcionData $OpcionData)
    {
        /* ----------------------------------------------------------------------------- */
        $OpcionDAO = new OpcionDAO();
        
        try {
            $OpcionDAO->setEntityManager($this->getEntityManager());
            $result = $OpcionDAO->delOpciones('A', $OpcionData->getXmlIds());
            
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
        $OpcionDAO = new OpcionDAO();
        $OpcionDAO->setEntityManager($this->getEntityManager());
        $OpcionData = $OpcionDAO->getOpcion($id);
        return $OpcionData;
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
        $OpcionDAO = new OpcionDAO();
        
        $OpcionDAO->setEntityManager($this->getEntityManager());
        $OpcionDAO->setPage($this->page);
        $OpcionDAO->setLimit($this->limit);
        $OpcionDAO->setSidx($this->sidx);
        $OpcionDAO->setSord($this->sord);
        
        $result = $OpcionDAO->getOpciones($tipoConsulta, 0);
        return $result;
    } // end function listado
    function opcionAccionListado($tipoConsulta, $opcionId)
    {
        /* ----------------------------------------------------------------------------- */
        $OpcionDAO = new OpcionDAO();
        
        $OpcionDAO->setEntityManager($this->getEntityManager());
        $OpcionDAO->setPage($this->page);
        $OpcionDAO->setLimit($this->limit);
        $OpcionDAO->setSidx($this->sidx);
        $OpcionDAO->setSord($this->sord);
        
        $result = $OpcionDAO->getOpcionesAccionDispositivo($tipoConsulta, $opcionId);
        return $result;
    } // end function opcionAccionListado
    
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
    function getCboTipoOpcion($id)
    {
        /* ----------------------------------------------------------------------------- */
        $arrData = array(
            "M" => "MANTENIMIENTOS",
            "P" => "PROCESOS",
            "R" => "REPORTES"
        );
        $opcion = "";
        foreach ($arrData as $clave => $valor) {
            $seleccionado = "";
            if ($id == $clave) {
                $seleccionado = "selected";
            } // end if
            $opcion = $opcion . '<option value="' . $clave . '" ' . $seleccionado . '>' . $valor . '</option>';
        } // end foreach
        
        return $opcion;
    } // end function getCboTipoOpcion
} // end class OpcionBO
?>