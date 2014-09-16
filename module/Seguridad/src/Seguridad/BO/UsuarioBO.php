<?php
namespace Seguridad\BO;

use Seguridad\DAO\UsuarioDAO;
use Seguridad\DAO\UsuarioEmpresaSucursalDAO;
use Application\Classes\Conexion;
use Seguridad\Data\UsuarioData;

class UsuarioBO extends Conexion
{

    private $primer_registro_empresa = null;

    private $page = null;

    private $limit = null;

    private $sidx = null;

    private $sord = null;

    function setPrimerRegistroEmpresa($valor)
    {
        $this->primer_registro_empresa = $valor;
    }

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

    function getPrimerRegistroEmpresa()
    {
        return $this->primer_registro_empresa;
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
    function ingresar(UsuarioData $UsuarioData, $isGenerarClave)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        try {
            $UsuarioDAO->setEntityManager($this->getEntityManager());
            $result = $UsuarioDAO->setUsuario("I", $UsuarioData, $isGenerarClave);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
        /*
         * $this->getEntityManager()->getConnection()->beginTransaction(); try { //\Zend\Debug\Debug::dump($UsuarioData); $UsuarioDAO->setEntityManager($this->getEntityManager()); $id = $UsuarioDAO->ingresar($UsuarioData); $this->getEntityManager()->getConnection()->commit(); return $id; } catch (Exception $e) { $this->getEntityManager()->getConnection()->rollback(); $this->getEntityManager()->close(); throw $e; exit; }
         */
    } // end function ingresar
    
    /* ----------------------------------------------------------------------------- */
    function modificar(UsuarioData $UsuarioData, $isGenerarClave)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        try {
            $UsuarioDAO->setEntityManager($this->getEntityManager());
            $result = $UsuarioDAO->setUsuario("M", $UsuarioData, $isGenerarClave);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
        /*
         * $this->getEntityManager()->getConnection()->beginTransaction(); try { $UsuarioDAO->setEntityManager($this->getEntityManager()); $id = $UsuarioDAO->modificar($UsuarioData); $this->getEntityManager()->getConnection()->commit(); return $id; } catch (Exception $e) { $this->getEntityManager()->getConnection()->rollback(); $this->getEntityManager()->close(); throw $e; }
         */
    } // end function modificar
    
    /* ----------------------------------------------------------------------------- */
    function eliminar(UsuarioData $UsuarioData)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        try {
            $UsuarioDAO->setEntityManager($this->getEntityManager());
            $result = $UsuarioDAO->setUsuario('E', $UsuarioData);
            
            return $result;
        } catch (Exception $e) {
            $this->getEntityManager()->close();
            throw $e;
            exit();
        }
        /*
         * $this->getEntityManager()->getConnection()->beginTransaction(); try { $UsuarioDAO->setEntityManager($this->getEntityManager()); $id = $UsuarioDAO->eliminar($UsuarioData); $this->getEntityManager()->getConnection()->commit(); return $id; } catch (Exception $e) { $this->getEntityManager()->getConnection()->rollback(); $this->getEntityManager()->close(); throw $e; }
         */
    } // end function eliminar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Eliminacion masiva
     *
     * @param \Seguridad\Data\UsuarioData $arrUsuarioData[]            
     * @return bool
     */
    function eliminarMasivo($arrUsuarioData)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $this->getEntityManager()
            ->getConnection()
            ->beginTransaction();
        
        try {
            // echo("<pre>"); var_dump($arrUsuarioData); echo("</pre>");
            $UsuarioDAO->setEntityManager($this->getEntityManager());
            foreach ($arrUsuarioData as $UsuarioData) {
                $id = $UsuarioDAO->eliminar($UsuarioData);
            } // end foreach
            $this->getEntityManager()
                ->getConnection()
                ->commit();
            return true;
        } catch (Exception $e) {
            $this->getEntityManager()
                ->getConnection()
                ->rollback();
            $this->getEntityManager()->close();
            throw $e;
        }
    } // end function eliminarMasivo
    
    /* ----------------------------------------------------------------------------- */
    function consultar($id)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        
        $UsuarioData = $UsuarioDAO->consultar($id);
        return $UsuarioData;
    } // end function consultar
    
    /* ----------------------------------------------------------------------------- */
    public function getComboEmpresasAsignadas($usuario_id, $empresa_id, $texto_1er_elemento = "&lt;Seleccione&gt;", $color_1er_elemento = "#FFFFAA")	
	/*-----------------------------------------------------------------------------*/	
	{
        $UsuarioEmpresaSucursalDAO = new UsuarioEmpresaSucursalDAO();
        
        $UsuarioEmpresaSucursalDAO->setEntityManager($this->getEntityManager());
        
        $result = $UsuarioEmpresaSucursalDAO->consultarEmpresaPorUsuario($usuario_id);
        
        foreach ($result as $reg) {
            $this->primer_registro_empresa = $reg;
            break;
        } // end foreach
        
        $opciones = \Application\Classes\Combo::getComboDataResultset($result, 'empresa_id', 'nombre_corto', $empresa_id, $texto_1er_elemento, $color_1er_elemento);
        return $opciones;
    } // end function getComboEmpresasAsignadas
    
    /* ----------------------------------------------------------------------------- */
    public function getComboSucursalesAsignadas($usuario_id, $empresa_id, $sucursal_id, $texto_1er_elemento = "&lt;Seleccione&gt;", $color_1er_elemento = "#FFFFAA")	
	/*-----------------------------------------------------------------------------*/	
	{
        $UsuarioEmpresaSucursalDAO = new UsuarioEmpresaSucursalDAO();
        
        $UsuarioEmpresaSucursalDAO->setEntityManager($this->getEntityManager());
        
        $result = $UsuarioEmpresaSucursalDAO->consultarSucursalPorEmpresaPorUsuario($usuario_id, $empresa_id);
        
        $opciones = \Application\Classes\Combo::getComboDataResultset($result, 'sucursal_id', 'nombre_corto', $sucursal_id, $texto_1er_elemento, $color_1er_elemento);
        
        // die(var_dump($opciones));
        return $opciones;
    } // end function getComboSucursalesAsignadas
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Listado
     *
     * @param string $opcion            
     * @param array $condiciones            
     * @return array
     */
    function listado($opcion, $condiciones)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $UsuarioDAO->setPage($this->page);
        $UsuarioDAO->setLimit($this->limit);
        $UsuarioDAO->setSidx($this->sidx);
        $UsuarioDAO->setSord($this->sord);
        
        $result = $UsuarioDAO->listado($opcion, $condiciones);
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
    function login($usuario, $clave, $ipAcceso, $nombreHost, $AgenteUsuario)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $resultDatosUsuario = $UsuarioDAO->login($usuario, $clave, $ipAcceso, $nombreHost, $AgenteUsuario);
        if (isset($resultDatosUsuario['perfil_id'])) {
            $resultPerfilPermisos = $UsuarioDAO->getPerfilPermisos($resultDatosUsuario['perfil_id']);
            return array(
                $resultDatosUsuario,
                $resultPerfilPermisos
            );
        } else {
            return array(
                $resultDatosUsuario,
                null
            );
        }
    } // end function login
    
    /* ----------------------------------------------------------------------------- */
    function cambioClave($usuario_id, $clave, $clave_antigua, $ipAcceso, $nombreHost, $AgenteUsuario)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $result = $UsuarioDAO->setCambioClave($usuario_id, $clave, $clave_antigua, $ipAcceso, $nombreHost, $AgenteUsuario);
        return $result;
    } // end function login
    
    /* ----------------------------------------------------------------------------- */
    function getPerfilPermisos($perfilId)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $result = $UsuarioDAO->getPerfilPermisos($perfilId);
        return $result;
    } // end function getPerfilPermisos
    
    /* ----------------------------------------------------------------------------- */
    function getMenuDinamicoPerfil($usuarioId, $dispositivo, $tipoMenu)
    {
        /* ----------------------------------------------------------------------------- */
        $menuDinamico = "";
        $cont = 0;
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $result = $UsuarioDAO->getModulosPerfilUsuario($usuarioId);
        
        foreach ($result as $modulo) {
            if ($cont > 0) {
                $menuDinamico .= "</div>";
            }
            $menuDinamico .= "<h3>&#8226;&nbsp;" . strtoupper($modulo['modulo']) . "</h3>";
            $menuDinamico .= "<div id='accordion_modulo' class='modulo'>";
            $menuDinamico .= "<div class='accordion_opciones'>";
            
            // $menuDinamico .= "<div id='accordion_seguridad_opciones' class='accordion_opciones'>";
            
            $result2 = $UsuarioDAO->getOpcionesModuloPerfilUsuario($modulo['modulo_id'], $modulo['perfil_id']);
            
            if (count($result2) > 0) {
                switch ($tipoMenu) {
                    case 1: // Menu completo con submenus de MANTENIMIENTO, PROCESOS, REPORTES, ETC..
                        $tipoOpcion = "";
                        $flagTipoOpcion = 0;
                        
                        foreach ($result2 as $opcion) {
                            if ($tipoOpcion != $opcion['tipo_opcion']) {
                                if ($flagTipoOpcion != 0) {
                                    $menuDinamico .= "</ul></div>";
                                    $flagTipoOpcion = 0;
                                } else {
                                    $flagTipoOpcion = 1;
                                }
                                
                                $tipoOpcion = $opcion['tipo_opcion'];
                                $menuDinamico .= "<h1>" . strtoupper($opcion['tipo_opcion']) . "</h1>";
                                $menuDinamico .= "<div class='div_opciones'>";
                                $menuDinamico .= "<ul class='ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom'>";
                                
                                switch ($dispositivo) {
                                    case "1":
                                        $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                                        break;
                                    case "2":
                                        $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                                        break;
                                }
                            } else {
                                switch ($dispositivo) {
                                    case "1":
                                        $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                                        break;
                                    case "2":
                                        $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                                        break;
                                }
                            }
                        }
                        $menuDinamico .= "</ul></div></div>";
                        break;
                    case 2: // Menu sencillo con opciones directas
                        $menuDinamico .= "<ul>";
                        foreach ($result2 as $opcion) {
                            switch ($dispositivo) {
                                case "1":
                                    $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                                    break;
                                case "2":
                                    $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                                    break;
                            }
                        }
                        $menuDinamico .= "</ul>";
                        break;
                }
            }
            $cont ++;
        }
        $menuDinamico .= "</div>";
        return $menuDinamico;
    } // end function getMenuDinamicoPerfil
    
    
    
    
    
    /* ----------------------------------------------------------------------------- */
    function listadoPerfilOpciones($usuarioId)
    {
        /* ----------------------------------------------------------------------------- */
        $cont = 0;
        $UsuarioDAO = new UsuarioDAO();
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $result2 = $UsuarioDAO->getOpcionesModuloPerfilUsuario($modulo['modulo_id'], $modulo['perfil_id']);
        $menu_html="<div><ul>";
        $opciones = $UsuarioDAO->getPerfilOpciones($usuarioId);
        if (count($opciones) > 0) {
            foreach ($opciones as $opcion) {
                $menu_html.="<li><a href='#'   url='".$opcion['url']."'> <span> ".$opcion['nombre']."</span></li>";
                
            }//end for
        }//end if
        $menu_html.="</ul></div>";
        return  $menu_html;
        
        
        
        
        
        /*
            if (count($result2) > 0) {
                switch ($tipoMenu) {
                	case 1: // Menu completo con submenus de MANTENIMIENTO, PROCESOS, REPORTES, ETC..
                	    $tipoOpcion = "";
                	    $flagTipoOpcion = 0;
    
                	    foreach ($result2 as $opcion) {
                	        if ($tipoOpcion != $opcion['tipo_opcion']) {
                	            if ($flagTipoOpcion != 0) {
                	                $menuDinamico .= "</ul></div>";
                	                $flagTipoOpcion = 0;
                	            } else {
                	                $flagTipoOpcion = 1;
                	            }
    
                	            $tipoOpcion = $opcion['tipo_opcion'];
                	            $menuDinamico .= "<h1>" . strtoupper($opcion['tipo_opcion']) . "</h1>";
                	            $menuDinamico .= "<div class='div_opciones'>";
                	            $menuDinamico .= "<ul class='ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom'>";
    
                	            switch ($dispositivo) {
                	            	case "1":
                	            	    $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                	            	    break;
                	            	case "2":
                	            	    $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                	            	    break;
                	            }
                	        } else {
                	            switch ($dispositivo) {
                	            	case "1":
                	            	    $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                	            	    break;
                	            	case "2":
                	            	    $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                	            	    break;
                	            }
                	        }
                	    }
                	    $menuDinamico .= "</ul></div></div>";
                	    break;
                	case 2: // Menu sencillo con opciones directas
                	    $menuDinamico .= "<ul>";
                	    foreach ($result2 as $opcion) {
                	        switch ($dispositivo) {
                	        	case "1":
                	        	    $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                	        	    break;
                	        	case "2":
                	        	    $menuDinamico .= "<li><a href='#' class='opcion_app' opcion_id='" . $opcion['opcion_id'] . "' url='" . $opcion['ruta_acceso'] . "'><span>" . $opcion['opcion'] . "</span></a></li>";
                	        	    break;
                	        }
                	    }
                	    $menuDinamico .= "</ul>";
                	    break;
                }
            }
            $cont ++;
        }
        $menuDinamico .= "</div>";
        return $menuDinamico;*/
    } // end function getMenuDinamicoPerfil
    
    
    
    
    
    
    /* ----------------------------------------------------------------------------- */
    function empresasucursalListado($tipoConsulta, $usuarioId)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $UsuarioDAO->setPage($this->page);
        $UsuarioDAO->setLimit($this->limit);
        $UsuarioDAO->setSidx($this->sidx);
        $UsuarioDAO->setSord($this->sord);
        
        $result = $UsuarioDAO->getEmpresaSucursales($tipoConsulta, $usuarioId);
        return $result;
    } // end function empresasucursalListado
    
    /* ----------------------------------------------------------------------------- */
    function usuarioextensionListado($tipoConsulta, $usuarioId)
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $UsuarioDAO->setPage($this->page);
        $UsuarioDAO->setLimit($this->limit);
        $UsuarioDAO->setSidx($this->sidx);
        $UsuarioDAO->setSord($this->sord);
        
        $result = $UsuarioDAO->getUsuarioExtensiones($tipoConsulta, $usuarioId);
        return $result;
    } // end function usuarioextensionListado
    function getComboTipoExtensionDataGrid()
    {
        /* ----------------------------------------------------------------------------- */
        $UsuarioDAO = new UsuarioDAO();
        $UsuarioDAO->setEntityManager($this->getEntityManager());
        $result = $UsuarioDAO->getTiposExtension(2);
        $opciones = \Application\Classes\Combo::getComboDataResultset($result, 'id', 'nombre', null, null, null, \Application\Classes\Combo::$tipo_combo_datagrid);
        return $opciones;
    } // end function getComboDispositivoDataGrid
}//end class UsuarioBO
