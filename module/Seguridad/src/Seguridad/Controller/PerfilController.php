<?php
namespace Seguridad\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;
use Seguridad\BO\PerfilBO;
use Seguridad\Data\PerfilData;
use Seguridad\Data\PerfilPermisoData;

class PerfilController extends AbstractActionController
{

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    private $opcion_app = 37;
    
    /* ----------------------------------------------------------------------------- */
    public function listadodataAction()	
	/*-----------------------------------------------------------------------------*/
	{
        $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::CONSULTAR);
        try {
            $PerfilBO = new PerfilBO();
            $PerfilBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $request = $this->getRequest();
            $nombre_usuario = $request->getQuery('nombre_usuario', "");
            $estado = $request->getQuery('estado', "");
            $page = $request->getQuery('page');
            $limit = $request->getQuery('rows');
            $sidx = $request->getQuery('sidx', 1);
            $sord = $request->getQuery('sord', "");
            
            $PerfilBO->setPage($page);
            $PerfilBO->setLimit($limit);
            $PerfilBO->setSidx($sidx);
            $PerfilBO->setSord($sord);
            
            $result = $PerfilBO->listado(1);
            
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
    public function cargaperfilopcionaccionlistadodataAction()
	/*-----------------------------------------------------------------------------*/
	{
        $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
        $EntityManagerPlugin = $this->EntityManagerPlugin();
        $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::CONSULTAR);
        try {
            $PerfilBO = new PerfilBO();
            $PerfilBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            $request = $this->getRequest();
            $perfil_id = $request->getQuery('perfil_id', "");
            $page = $request->getQuery('page');
            $limit = $request->getQuery('rows');
            $sidx = $request->getQuery('sidx', 1);
            $sord = $request->getQuery('sord', "");
            
            $PerfilBO->setPage($page);
            $PerfilBO->setLimit($limit);
            $PerfilBO->setSidx($sidx);
            $PerfilBO->setSord($sord);
            
            $result = $PerfilBO->perfilopcionAccionListado(2, $perfil_id);
            
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
            $PerfilBO = new PerfilBO();
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $data = $SesionUsuarioPlugin->getPermisoAccion($this->opcion_app, \Application\Constants\Accion::CONSULTAR);
            $PerfilBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            
            $viewModel = new ViewModel();
            $request = $this->getRequest();
            $id = $this->params('id', "");
            $contenedor_opcion = $request->getQuery('contenedor_opcion', "");
            $objData = $PerfilBO->consultar($id);
            $cboEstado = $PerfilBO->getCboEstado($objData->getEstado());
            
            $viewModel->PerfilData = $objData;
            $viewModel->cboEstado = $cboEstado;
            $viewModel->contenedor_opcion = $contenedor_opcion;
            $viewModel->habilitarAcciones = array(
                \Application\Constants\Accion::VIRTUAL_REGRESAR => true,
                \Application\Constants\Accion::VIRTUAL_GRABAR => true,
                \Application\Constants\Accion::INGRESAR => true,
                \Application\Constants\Accion::ELIMINAR => true
            );
            $viewModel->permisos = $SesionUsuarioPlugin->getArrayPermisoAccion(); // all los permisos
            $viewModel->setTerminal(true);
            $viewModel->setTemplate('Seguridad/perfil/mantenimiento.phtml');
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
            $PerfilBO = new PerfilBO();
            $objData = new PerfilData();
            $viewModel = new ViewModel();
            
            $EntityManagerPlugin = $this->EntityManagerPlugin();
            $SesionUsuarioPlugin = $this->SesionUsuarioPlugin();
            $SesionUsuarioPlugin->getPermisoOpcion(1);
            $PerfilBO->setEntityManager($EntityManagerPlugin->getEntityManager());
            
            $request = $this->getRequest();
            $contenedor_opcion = $request->getQuery('contenedor_opcion', "");
            
            $cboEstado = utf8_encode($PerfilBO->getCboEstado(''));
            $viewModel->PerfilData = $objData;
            $viewModel->cboEstado = $cboEstado;
            $viewModel->contenedor_opcion = $contenedor_opcion;
            $viewModel->permisos = $SesionUsuarioPlugin->getArrayPermisoAccion(); // all los permisos
            $viewModel->habilitarAcciones = array(
                \Application\Constants\Accion::VIRTUAL_REGRESAR => true,
                \Application\Constants\Accion::INGRESAR => true,
                \Application\Constants\Accion::VIRTUAL_GRABAR => true
            );
            
            $viewModel->setTerminal(true);
            $viewModel->setTemplate('Seguridad/perfil/mantenimiento.phtml');
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
        $gridPerfilOpcionAccionData = $json['gridPerfilOpcionAccionData'];
        $PerfilBO = new PerfilBO();
        $PerfilBO->setEntityManager($EntityManagerPlugin->getEntityManager());
        $contenedor_opcion = $request->getQuery('contenedor_opcion', "");
        
        $objData = new PerfilData();
        $objData->setId($formData['codigo_37']);
        $objData->setNombre($formData['nombre_37']);
        $objData->setSiglas($formData['siglas_37']);
        $objData->setUsuarioIngId($id_usuario);
        $objData->setUsuarioModId($id_usuario);
        $objData->setEstado($formData['estado_37']);
        $objData->setXmlPerfilOpcionAccion($gridPerfilOpcionAccionData);
        
        switch ($opcion) {
            case 'ingresar':
                $id = $PerfilBO->ingresar($objData);
                break;
            case 'modificar':
                $id = $PerfilBO->modificar($objData);
                break;
            default:
                // Aqui se debe de lanzar una excepcion
                break;
        } // end switch
        
        $this->plugin('redirect')->toRoute('seguridad-perfil', [
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
                
                $PerfilBO = new PerfilBO();
                $objData = new PerfilData();
                $PerfilBO->setEntityManager($EntityManagerPlugin->getEntityManager());
                $request = $this->getRequest();
                $ids = $this->params()->fromPost('ids');
                $objData->setXmlIds($ids);
                $respuesta = $PerfilBO->eliminarMasivo($objData);
                
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
                
                $PerfilBO = new PerfilBO();
                $PerfilBO->setEntityManager($EntityManagerPlugin->getEntityManager());
                $request = $this->getRequest();
                
                $contenedor_opcion = $request->getQuery('contenedor_opcion', "");
                
                $objData = new ModuloData();
                $objData->setId($this->params()
                    ->fromPost('codigo_37'));
                $id = $PerfilBO->eliminar($objData);
                
                // Si tiene asignado un contenedor_opcion se redireccion el ruteo para realizar la consulta del registro
                // en caso de no tener valor se retornará un JSON como OK
                if ($contenedor_opcion != '') {
                    $this->plugin('redirect')->toRoute('seguridad-perfil', [
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
