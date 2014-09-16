<?php
namespace Seguridad\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;
use Seguridad\BO\OpcionBO;
use Seguridad\BO\ModuloBO;
use Seguridad\Data\OpcionData;

class OpcionController extends AbstractActionController
{

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    private $opcion_app = 36;
    
    /* ----------------------------------------------------------------------------- */
    public function listadodataAction()	
	/*-----------------------------------------------------------------------------*/
	{
        $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::CONSULTAR);
        try {
            $OpcionBO = new OpcionBO();
            $OpcionBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $request = $this->getRequest();
            $nombre_usuario = $request->getQuery('nombre_usuario', "");
            $estado = $request->getQuery('estado', "");
            $page = $request->getQuery('page');
            $limit = $request->getQuery('rows');
            $sidx = $request->getQuery('sidx', 1);
            $sord = $request->getQuery('sord', "");
            
            $OpcionBO->setPage($page);
            $OpcionBO->setLimit($limit);
            $OpcionBO->setSidx($sidx);
            $OpcionBO->setSord($sord);
            
            $result = $OpcionBO->listado(1);
            
            $response = new \stdClass();
            
            $i = 0;
            foreach ($result as $row) {
                $response->rows[$i] = $row;
                $i ++;
            }
            
            $tot_reg = $i + 1;
            // $response->total = ceil($tot_reg/$limit);
            $response->total = 1;
            $response->page = $page;
            $response->records = $tot_reg;
            
            $json = new JsonModel(get_object_vars($response));
            return $json;
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        }
    } // end function listadodataAction
    
    /* ----------------------------------------------------------------------------- */
    public function cargaopcionaccionlistadodataAction()
	/*-----------------------------------------------------------------------------*/
	{
        $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::CONSULTAR);
        try {
            $OpcionBO = new OpcionBO();
            $OpcionBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $request = $this->getRequest();
            $opcion_id = $request->getQuery('opcion_id', "");
            $page = $request->getQuery('page');
            $limit = $request->getQuery('rows');
            $sidx = $request->getQuery('sidx', 1);
            $sord = $request->getQuery('sord', "");
            
            $OpcionBO->setPage($page);
            $OpcionBO->setLimit($limit);
            $OpcionBO->setSidx($sidx);
            $OpcionBO->setSord($sord);
            
            $result = $OpcionBO->opcionAccionListado(2, $opcion_id);
            
            $response = new \stdClass();
            
            $i = 0;
            foreach ($result as $row) {
                $response->rows[$i] = $row;
                $i ++;
            }
            
            $tot_reg = $i + 1;
            // $response->total = ceil($tot_reg/$limit);
            $response->total = 1;
            $response->page = $page;
            $response->records = $tot_reg;
            
            $json = new JsonModel(get_object_vars($response));
            return $json;
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        }
    } // end function cargaopcionaccionlistadoAction
    
    /* ----------------------------------------------------------------------------- */
    public function listadoAction()
    {
        /* ----------------------------------------------------------------------------- */
        try {
            $request = $this->getRequest();
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $SesionUsuarioPlugin->getPermisoOpcion($this->opcion_app);
            
            $viewModel = new ViewModel();
            
            $viewModel->opcion_id = $this->opcion_app;
            $viewModel->contenedor_opcion = $request->getQuery('contenedor_opcion', "");
            $viewModel->permisos = $SesionUsuarioPlugin->getArrayPermisoAccion(); // Obtiene todos los permisos del usuario
            $viewModel->habilitarAcciones = array(
                \Application\Constants\Accion::INGRESAR => true,
                \Application\Constants\Accion::ACTIVAR => true,
                \Application\Constants\Accion::ELIMINAR => true
            )
            ;
            
            $viewModel->setTerminal(true);
            return $viewModel;
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        }
    } // end function listadoAction
    
    /* ----------------------------------------------------------------------------- */
    public function consultarAction()
    {
        /* ----------------------------------------------------------------------------- */
        try {
            $OpcionBO = new OpcionBO();
            $ModuloBO = new ModuloBO();
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $data = $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::CONSULTAR);
            $OpcionBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $ModuloBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            
            $viewModel = new ViewModel();
            $request = $this->getRequest();
            $id = $this->params('id', "");
            $contenedor_opcion = $request->getQuery('contenedor_opcion', "");
            $objData = $OpcionBO->consultar($id);
            $cboEstado = $OpcionBO->getCboEstado($objData->getEstado());
            
            $viewModel->OpcionData = $objData;
            $viewModel->cboEstado = $cboEstado;
            $viewModel->cboModulo = $ModuloBO->getComboModulo($objData->getModuloId());
            $viewModel->cboTipoOpcion = $OpcionBO->getCboTipoOpcion($objData->getTipoOpcion());
            $viewModel->contenedor_opcion = $contenedor_opcion;
            $viewModel->habilitarAcciones = array(
                \Application\Constants\Accion::VIRTUAL_REGRESAR => true,
                \Application\Constants\Accion::VIRTUAL_GRABAR => true,
                \Application\Constants\Accion::INGRESAR => true,
                \Application\Constants\Accion::ELIMINAR => true
            );
            $viewModel->permisos = $SesionUsuarioPlugin->getArrayPermisoAccion(); // all los permisos
            $viewModel->setTerminal(true);
            $viewModel->setTemplate('Seguridad/opcion/mantenimiento.phtml');
            return $viewModel;
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        } // end try
    } // end function consultarAction
    
    /* ----------------------------------------------------------------------------- */
    public function indexAction()
    {
        /* ----------------------------------------------------------------------------- */
        return $this->listadoAction();
    } // end function indexAction
    
    /* ----------------------------------------------------------------------------- */
    public function nuevoAction()
    {
        /* ----------------------------------------------------------------------------- */
        try {
            $OpcionBO = new OpcionBO();
            $ModuloBO = new ModuloBO();
            $objData = new OpcionData();
            $viewModel = new ViewModel();
            
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $SesionUsuarioPlugin->getPermisoOpcion(1);
            $OpcionBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $ModuloBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            
            $request = $this->getRequest();
            $contenedor_opcion = $request->getQuery('contenedor_opcion', "");
            
            $cboEstado = utf8_encode($OpcionBO->getCboEstado(''));
            $viewModel->OpcionData = $objData;
            $viewModel->cboEstado = $cboEstado;
            $viewModel->cboModulo = $ModuloBO->getComboModulo('');
            $viewModel->cboTipoOpcion = $OpcionBO->getCboTipoOpcion('');
            $viewModel->contenedor_opcion = $contenedor_opcion;
            $viewModel->permisos = $SesionUsuarioPlugin->getArrayPermisoAccion(); // all los permisos
            $viewModel->habilitarAcciones = array(
                \Application\Constants\Accion::VIRTUAL_REGRESAR => true,
                \Application\Constants\Accion::INGRESAR => true,
                \Application\Constants\Accion::VIRTUAL_GRABAR => true
            );
            
            $viewModel->setTerminal(true);
            $viewModel->setTemplate('Seguridad/opcion/mantenimiento.phtml');
            return $viewModel;
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        }
    } // end function nuevoAction
    
    /* ----------------------------------------------------------------------------- */
    private function grabar($opcion)
	/*-----------------------------------------------------------------------------*/
	{
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        $id_usuario = $SesionUsuarioPlugin->getUsuarioId();
        
        $request = $this->getRequest();
        $body = $this->getRequest()->getContent();
        $json = json_decode($body, true);
        $formData = $json['formData'];
        $gridOpcionAccionData = $json['gridOpcionAccionData'];
        $OpcionBO = new OpcionBO();
        $OpcionBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $contenedor_opcion = $request->getQuery('contenedor_opcion', "");
        
        $objData = new OpcionData();
        $objData->setId($formData['codigo_36']);
        $objData->setNombre($formData['nombre_36']);
        $objData->setModuloId($formData['modulo_36']);
        $objData->setTipoOpcion($formData['tipo_opcion_36']);
        $objData->setUrlAcceso($formData['url_acceso_36']);
        $objData->setUrlLogo($formData['url_logo_36']);
        $objData->setOrden($formData['nro_orden_36']);
        $objData->setUsuarioIngId($id_usuario);
        $objData->setUsuarioModId($id_usuario);
        $objData->setEstado($formData['estado_36']);
        $objData->setXmlOpcionAccion($gridOpcionAccionData);
        
        switch ($opcion) {
            case 'ingresar':
                $id = $OpcionBO->ingresar($objData);
                break;
            case 'modificar':
                $id = $OpcionBO->modificar($objData);
                break;
            default:
                // Aqui se debe de lanzar una excepcion
                break;
        } // end switch
        
        $this->plugin('redirect')->toRoute('seguridad-opcion', [
            'action' => 'consultar',
            'id' => $id
        ], [
            'query' => [
                'contenedor_opcion' => $contenedor_opcion
            ]
        ]);
    } // end function grabar
    
    /* ----------------------------------------------------------------------------- */
    public function modificarAction()
	/*-----------------------------------------------------------------------------*/
	{
        try {
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::MODIFICAR);
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $this->grabar('modificar');
            } // end if
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        }
    } // end function modificarAction
    
    /* ----------------------------------------------------------------------------- */
    public function ingresarAction()
	/*-----------------------------------------------------------------------------*/
	{
        try {
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::INGRESAR);
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $this->grabar('ingresar');
            } // end if
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        }
    } // end function insertarAction
    
    /* ----------------------------------------------------------------------------- */
    public function eliminarmasivoAction()
	/*-----------------------------------------------------------------------------*/
	{
        try {
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::ELIMINAR);
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $request = $this->getRequest();
                
                $OpcionBO = new OpcionBO();
                $objData = new ModuloData();
                $OpcionBO->setEntityManager($EntityManagerPlugin->getEntityManager());
                $request = $this->getRequest();
                $ids = $this->params()->fromPost('ids');
                $objData->setXmlIds($ids);
                $respuesta = $OpcionBO->eliminarMasivo($objData);
                
                $json = new JsonModel(array(
                    'cod_msg' => 'OK'
                ));
                return $json;
            } // end if
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        }
    } // end function eliminarmasivoAction
    
    /* ----------------------------------------------------------------------------- */
    public function eliminarAction()
	/*-----------------------------------------------------------------------------*/
	{
        try {
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::ELIMINAR);
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $request = $this->getRequest();
                
                $OpcionBO = new OpcionBO();
                $OpcionBO->setEntityManager($EntityManagerPlugin->getEntityManager());
                $request = $this->getRequest();
                
                $contenedor_opcion = $request->getQuery('contenedor_opcion', "");
                
                $objData = new ModuloData();
                $objData->setId($this->params()
                    ->fromPost('codigo_36'));
                $id = $OpcionBO->eliminar($objData);
                
                // Si tiene asignado un contenedor_opcion se redireccion el ruteo para realizar la consulta del registro
                // en caso de no tener valor se retornará un JSON como OK
                if ($contenedor_opcion != '') {
                    $this->plugin('redirect')->toRoute('seguridad-opcion', [
                        'action' => 'consultar',
                        'id' => $id
                    ], [
                        'query' => [
                            'contenedor_opcion' => $contenedor_opcion
                        ]
                    ]);
                } else {
                    $json = new JsonModel(array(
                        'cod_msg' => 'OK'
                    ));
                    return $json;
                } // end if
            } // end if
        } catch (\Exception $e) {
            $excepcion_msg = utf8_encode($this->ExcepcionPlugin()->getMessageFormat($e));
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $response->setContent($excepcion_msg);
            return $response;
        }
    } // end function eliminarAction
}
?>
