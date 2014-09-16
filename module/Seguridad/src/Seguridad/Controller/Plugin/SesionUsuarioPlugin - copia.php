<?php
namespace Seguridad\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;
// Zend\Authentication\AuthenticationService;
class SesionUsuarioxPlugin extends AbstractPlugin
{

    private $auth;
    
    /* ----------------------------------------------------------------------------- */
    private function getAuthenticationService()
	/*-----------------------------------------------------------------------------*/	
	{
        $this->auth = $this->getController()
            ->getServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');
        return $this->auth;
    } // end function getAuthenticationService
    public function getUsuarioId()
    {
        return $this->getRecord()['usuario_id'];
    }

    public function getUserNombre()
    {
        return $this->getRecord()['nombre_usuario'];
    }

    public function getUserNombrePersona()
    {
        return $this->getRecord()['nombre_persona'];
    }

    public function getUserNombrePerfil()
    {
        return $this->getRecord()['nombre_perfil'];
    }

    public function getUserGrupoEmpresarial()
    {
        return $this->getRecord()['grupo_empresarial'];
    }
    
    /* ----------------------------------------------------------------------------- */
    public function getRecord()
	/*-----------------------------------------------------------------------------*/
	{
        $record = $this->getAuthenticationService()
            ->getStorage()
            ->read();
        
        $result = [
            'usuario_id' => $record->id,
            'nombre_usuario' => $record->nombre_usuario,
            'nombre' => $record->persona->getNombre(),
            'nombre_perfil' => $record->perfil->getNombre(),
            'grupo_empresarial' => $record->grupo_empresarial->getNombreGrupo()
        ];
        return $result;
    } // end function getSessionStorage
    
    /* ----------------------------------------------------------------------------- */
    public function cargarPermisos()
	/*-----------------------------------------------------------------------------*/
	{
        $record = $this->getAuthenticationService()
            ->getStorage()
            ->read();
        $dispositivo_id = $this->getDispositivoId();
        
        // Se obtiene el nombre del perfil que tiene asignado el usuario
        $PerfilPermisos = $record->perfil->getPerfilPermisos();
        
        foreach ($PerfilPermisos as $reg) {
            if ($reg->getDispositivoId() == $dispositivo_id) {
                $regs_permiso_dispositivo[$reg->getDispositivoId()] = 'OK';
                $regs_permiso_opcion[$reg->getOpcionId()] = 'OK';
                $regs_permiso_accion[$reg->getOpcionId() . '|' . $reg->getAccionId()] = 'OK';
                
                $moduloId = $reg->getOpcionAccion()
                    ->getOpcion()
                    ->getModuloId();
                $regs_permiso_modulo[$moduloId] = 'OK';
            } // end if
        } // end foreach
        
        $regs_menu_dinamico = ""; // HECTOR
        
        $session = new Container('usuario');
        $session->offsetSet('permiso_dispositivo', $regs_permiso_dispositivo);
        $session->offsetSet('permiso_modulo', $regs_permiso_modulo);
        $session->offsetSet('permiso_opcion', $regs_permiso_opcion);
        $session->offsetSet('permiso_accion', $regs_permiso_accion);
        $session->offsetSet('menu_dinamico', $regs_menu_dinamico);
        
        return true;
    } // end function cargarPermisos
    
    /* ----------------------------------------------------------------------------- */
    public function setDispositivoId($valor)
	/*-----------------------------------------------------------------------------*/
	{
        $session = new Container('usuario');
        $session->offsetSet('dispositivo_id', $valor);
    } // end function setDispositivoId
    
    /* ----------------------------------------------------------------------------- */
    public function getDispositivoId()
	/*-----------------------------------------------------------------------------*/
	{
        $session = new Container('usuario');
        return $session->offsetGet('dispositivo_id');
    } // end function getDispositivoId
    
    /* ----------------------------------------------------------------------------- */
    public function getPermisoDispositivo($flag_exit = true, $flag_check_login = true)
	/*-----------------------------------------------------------------------------*/
	{
        if ($flag_check_login) {
            if (! $this->isLogin()) {
                return false;
            }
        } // end if
        
        $dispositivo_id = $this->getDispositivoId();
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_dispositivo')) {
            $permiso_dispositivo = $session->offsetGet('permiso_dispositivo');
            
            if (isset($permiso_dispositivo[$dispositivo_id])) {
                $valor = $permiso_dispositivo[$dispositivo_id];
                if ($valor == 'OK') {
                    return true;
                } // end if
            } // end if
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para PermisoDispositivo  dispositivo:' . $dispositivo_id);
            exit();
        } // end if
        
        exit();
    } // end function getPermisoDispositivo
    
    /* ----------------------------------------------------------------------------- */
    public function getPermisoModulo($modulo_id, $flag_exit = true, $flag_check_login = true)
	/*-----------------------------------------------------------------------------*/
	{
        if ($flag_check_login) {
            if (! $this->isLogin()) {
                return false;
            }
        } // end if
        
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_modulo')) {
            $permiso_modulo = $session->offsetGet('permiso_modulo');
            
            $clave = $modulo_id;
            if (isset($permiso_modulo[$clave])) {
                $valor = $permiso_modulo[$clave];
                if ($valor == 'OK') {
                    return true;
                } // end if
            } // end if
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para ModuloOpcion  modulo_id:' . $modulo_id);
            exit();
        } // end if
        
        return false;
    } // end function getPermisoModulo
    
    /* ----------------------------------------------------------------------------- */
    public function getPermisoOpcion($opcion_id, $flag_exit = true, $flag_check_login = true)
	/*-----------------------------------------------------------------------------*/
	{
        if ($flag_check_login) {
            if (! $this->isLogin()) {
                return false;
            }
        } // end if
          
        // $dispositivo_id = $this->getDispositivoId();
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_opcion')) {
            $permiso_opcion = $session->offsetGet('permiso_opcion');
            
            // $clave = $dispositivo_id.'|'.$opcion_id;
            $clave = $opcion_id;
            if (isset($permiso_opcion[$clave])) {
                $valor = $permiso_opcion[$clave];
                if ($valor == 'OK') {
                    return true;
                } // end if
            } // end if
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para PermisoOpcion  opcion_id:' . $opcion_id);
            exit();
        } // end if
        
        return false;
    } // end function getPermisoOpcion
    
    /* ----------------------------------------------------------------------------- */
    public function getPermisoAccion($opcion_id, $accion_id, $flag_exit = true)
	/*-----------------------------------------------------------------------------*/
	{
        // $dispositivo_id = $this->getDispositivoId();
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_accion')) {
            $permiso_accion = $session->offsetGet('permiso_accion');
            
            // $clave = $dispositivo_id.'|'.$opcion_id.'|'.$accion_id;
            $clave = $opcion_id . '|' . $accion_id;
            
            if (isset($permiso_accion[$clave])) {
                $valor = $permiso_accion[$clave];
                if ($valor == 'OK') {
                    return true;
                } // end if
            } // end if
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para PermisoAccion  opcion:' . $opcion_id . "*accion:" . $accion_id);
            exit();
        } // end if
        
        return false;
    } // end function getPermisoAccion
    
    /* ----------------------------------------------------------------------------- */
    public function getArrayPermisoModulo($flag_exit = true, $flag_check_login = true)
	/*-----------------------------------------------------------------------------*/
	{
        if ($flag_check_login) {
            if (! $this->isLogin()) {
                return false;
            }
        } // end if
        
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_modulo')) {
            $permiso_modulo = $session->offsetGet('permiso_modulo');
            
            return $permiso_modulo;
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para getArrayPermisoModulo');
            exit();
        } // end if
        
        return false;
    } // end function getArrayPermisoModulo
    
    /* ----------------------------------------------------------------------------- */
    public function getArrayPermisoOpcion($flag_exit = true, $flag_check_login = true)
	/*-----------------------------------------------------------------------------*/
	{
        if ($flag_check_login) {
            if (! $this->isLogin()) {
                return false;
            }
        } // end if
        
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_opcion')) {
            $permiso_opcion = $session->offsetGet('permiso_opcion');
            
            return $permiso_opcion;
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para getArrayPermisoOpcion');
            exit();
        } // end if
        
        return false;
    } // end function getArrayPermisoOpcion
    
    /* ----------------------------------------------------------------------------- */
    public function getArrayPermisoAccion($flag_exit = true, $flag_check_login = true)
	/*-----------------------------------------------------------------------------*/
	{
        if ($flag_check_login) {
            if (! $this->isLogin()) {
                return false;
            }
        } // end if
        
        $session = new Container('usuario');
        
        if ($session->offsetExists('permiso_accion')) {
            $permiso_accion = $session->offsetGet('permiso_accion');
            
            return $permiso_accion;
        } // end if
        
        if ($flag_exit) {
            echo ('Sin autorizacion para getArrayPermisoAccion');
            exit();
        } // end if
        
        return false;
    } // end function getArrayPermisoAccion
    
    /* ----------------------------------------------------------------------------- */
    public function isLogin()
	/*-----------------------------------------------------------------------------*/
	{
        if (! $this->getAuthenticationService()->hasIdentity()) {
            $this->getController()
                ->flashmessenger()
                ->addMessage("Debe de Iniciar Session");
            $this->getController()
                ->plugin('redirect')
                ->toRoute('home'); // seguridad-login;
            return false;
        }
        return true;
    } // end function isLogin
    
    /* ----------------------------------------------------------------------------- */
    public function logout()
	/*-----------------------------------------------------------------------------*/	
    {
        $auth = $this->getAuthenticationService();
        $auth->clearIdentity();
        
        $session = new \Zend\Session\Container();
        $session->getManager()->destroy();
        
        // $this->getSessionStorage()->forgetMe();
        // $this->getAuthService()->clearIdentity();
        $this->getController()
            ->flashmessenger()
            ->addMessage("Ud. cerró la sesión");
        $this->getController()
            ->plugin('redirect')
            ->toRoute('home'); // seguridad-login;
        
        return true;
    } // end function logout
}//end class