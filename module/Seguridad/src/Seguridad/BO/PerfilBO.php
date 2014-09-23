<?php
namespace Seguridad\BO;

use Seguridad\DAO\PerfilDAO;
use Application\Classes\Conexion;
use Seguridad\Data\PerfilData;

class PerfilBO extends Conexion
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
    function ingresar(PerfilData $PerfilData)
    {
        /* ----------------------------------------------------------------------------- */
        $PerfilDAO = new PerfilDAO();
        
        try {
            $PerfilDAO->setEntityManager($this->getEntityManager());
            $result = $PerfilDAO->setPerfil('I', $PerfilData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function ingresar
    
    /* ----------------------------------------------------------------------------- */
    function modificar(PerfilData $PerfilData)
    {
        /* ----------------------------------------------------------------------------- */
        $PerfilDAO = new PerfilDAO();
        
        try {
            $PerfilDAO->setEntityManager($this->getEntityManager());
            $result = $PerfilDAO->setPerfil('M', $PerfilData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function modificar
    
    /* ----------------------------------------------------------------------------- */
    function eliminar(PerfilData $PerfilData)
    {
        /* ----------------------------------------------------------------------------- */
        $PerfilDAO = new PerfilDAO();
        
        try {
            $PerfilDAO->setEntityManager($this->getEntityManager());
            $result = $PerfilDAO->setPerfil('E', $PerfilData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
    } // end function eliminar
    
    /* ----------------------------------------------------------------------------- */
    function eliminarMasivo(PerfilData $PerfilData)
    {
        /* ----------------------------------------------------------------------------- */
        $PerfilDAO = new PerfilDAO();
        
        try {
            $PerfilDAO->setEntityManager($this->getEntityManager());
            $result = $PerfilDAO->delPerfiles('I', $PerfilData->getXmlIds());
            
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
        $PerfilDAO = new PerfilDAO();
        
        try {
            $PerfilDAO->setEntityManager($this->getEntityManager());
            $result = $PerfilDAO->delPerfiles('A', $PerfilData->getXmlIds());
            
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
        $PerfilDAO = new PerfilDAO();
        $PerfilDAO->setEntityManager($this->getEntityManager());
        $PerfilData = $PerfilDAO->getPerfil($id);
        return $PerfilData;
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
        $PerfilDAO = new PerfilDAO();
        
        $PerfilDAO->setEntityManager($this->getEntityManager());
        $PerfilDAO->setPage($this->page);
        $PerfilDAO->setLimit($this->limit);
        $PerfilDAO->setSidx($this->sidx);
        $PerfilDAO->setSord($this->sord);
        
        $result = $PerfilDAO->getPerfiles($tipoConsulta);
        return $result;
    } // end function listado
    function perfilopcionAccionListado($tipoConsulta, $perfilId)
    {
        /* ----------------------------------------------------------------------------- */
        $PerfilDAO = new PerfilDAO();
        
        $PerfilDAO->setEntityManager($this->getEntityManager());
        $PerfilDAO->setPage($this->page);
        $PerfilDAO->setLimit($this->limit);
        $PerfilDAO->setSidx($this->sidx);
        $PerfilDAO->setSord($this->sord);
        
        $result = $PerfilDAO->getPerfilOpcionesAccionDispositivo($tipoConsulta, $perfilId);
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
    public function getCombo($id, $texto_1er_elemento = "&lt;Seleccione&gt;", $color_1er_elemento = "#FFFFAA")
    {
        $PerfilDAO = new PerfilDAO();
        
        $opciones = "";
        if ($texto_1er_elemento != '') {
            $opciones = '<option value="" style="color:\'' . $color_1er_elemento . '\'">' . $texto_1er_elemento . '</option>';
        } // end if
        
        $selected = "";
        
        $PerfilDAO->setEntityManager($this->getEntityManager());
        $result = $PerfilDAO->getPerfiles(2);
        
        foreach ($result as $row) {
            $selected = "";
            // var_dump($id);
            
            if ($id == $row['id']) {
                $selected = "selected";
            } // end if
            $opciones = $opciones . '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['nombre'] . '</option>';
        } // end foreach
        
        return $opciones;
    } // end function getCombo
} // end class PerfilBO
?>