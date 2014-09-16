<?php
namespace Seguridad\DAO;

use Doctrine\ORM\EntityManager, Seguridad\Entity\Usuario, Application\Classes\Conexion;
use Seguridad\Data\UsuarioData;
use General\Data\PersonaData;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UsuarioDAO extends Conexion
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
    private function getLimitIni()
    {
        /* ----------------------------------------------------------------------------- */
        return ($this->page - 1) * $this->limit;
    } // end function getLimitIni
    
    /* ----------------------------------------------------------------------------- */
    public function setUsuario($tipoAccion, UsuarioData $UsuarioData, $isGenerarClave)
    {
        /* ----------------------------------------------------------------------------- */
        $resultado = 0;
        $sql = "EXEC SEGURIDAD.SET_usuario :prmId,:prmPersonaId,:prmPerfilId,:prmGrupoEmpresarialId,:prmNombreUsuario,:prmCambioClave,:prmGenerarClave,:prmEstado,:prmUsuarioId,:prmEmpresasSucursales,:prmExtensiones,:prmAccion";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmId', $UsuarioData->getId());
        $stmt->bindValue(':prmPersonaId', $UsuarioData->getPersonaId());
        $stmt->bindValue(':prmPerfilId', $UsuarioData->getPerfilId());
        $stmt->bindValue(':prmGrupoEmpresarialId', $UsuarioData->getGrupoEmpresarialId());
        $stmt->bindValue(':prmNombreUsuario', $UsuarioData->getNombreUsuario());
        $stmt->bindValue(':prmCambioClave', $UsuarioData->getEstadoCambioClave());
        $stmt->bindValue(':prmGenerarClave', $isGenerarClave);
        $stmt->bindValue(':prmEstado', $UsuarioData->getEstado());
        $stmt->bindValue(':prmUsuarioId', $UsuarioData->getUsuarioIngId());
        $stmt->bindValue(':prmEmpresasSucursales', $UsuarioData->getXmlEmpresaSurcursal());
        $stmt->bindValue(':prmExtensiones', $UsuarioData->getXmlExtension());
        $stmt->bindValue(':prmAccion', $tipoAccion);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    } // end function setUsuario
    
    /* ----------------------------------------------------------------------------- */
    public function setCambioClave($usuario_id, $clave, $clave_antigua, $ipAcceso, $nombreHost, $AgenteUsuario)
    {
        /* ----------------------------------------------------------------------------- */
        $resultado = 0;
        $sql = "EXEC SEGURIDAD.SET_cambio_clave :prmId,:prmClaveAntigua,:prmClave,:prmIpAcceso,:prmNombreHost,:prmAgenteUsuario";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmId', $usuario_id);
        $stmt->bindValue(':prmClaveAntigua', $clave_antigua);
        $stmt->bindValue(':prmClave', $clave);
        $stmt->bindValue(':prmIpAcceso', $ipAcceso);
        $stmt->bindValue(':prmNombreHost', $nombreHost);
        $stmt->bindValue(':prmAgenteUsuario', $AgenteUsuario);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    } // end function setUsuario
    
    /*
     * ----------------------------------------------------------------------------- public function ingresar(UsuarioData $UsuarioData){ /*----------------------------------------------------------------------------- $usuario = new \Seguridad\Entity\Usuario(); $Persona 			= $this->getEntityManager()->getRepository('General\Entity\Persona')->find($UsuarioData->getPersonaId()); $Perfil 			= $this->getEntityManager()->getRepository('Seguridad\Entity\Perfil')->find($UsuarioData->getPerfilId()); $GrupoEmpresarial 	= $this->getEntityManager()->getRepository('General\Entity\GrupoEmpresarial')->find($UsuarioData->getGrupoEmpresarialId()); $UsuarioRegistro	= $this->getEntityManager()->getRepository('Seguridad\Entity\Usuario')->find($UsuarioData->getUsuarioIngId()); $usuario->setPersona($Persona); $usuario->setPerfil($Perfil); $usuario->setGrupoEmpresarial($GrupoEmpresarial); $usuario->setNombreUsuario($UsuarioData->getNombreUsuario()); $usuario->setEstadoCambioClave($UsuarioData->getEstadoCambioClave()); $usuario->setNroIntentos($UsuarioData->getNroIntentos()); $usuario->setEstado($UsuarioData->getEstado()); $usuario->setFechaIng(new \Datetime("now")); $usuario->setUsuarioIng($UsuarioRegistro); $this->getEntityManager()->persist($usuario); $this->getEntityManager()->flush(); return $usuario->getId(); }//end function ingresar
     */
	
	/*-----------------------------------------------------------------------------	 		
	public function modificar(UsuarioData $UsuarioData){
	/*-----------------------------------------------------------------------------	 		
		$usuario = $this->getEntityManager()->find('Seguridad\Entity\Usuario', $UsuarioData->getId());	
		
		$fecha = new \DateTime();

		$usuario->setPersonaId			($UsuarioData->getPersonaId());
		$usuario->setPerfilId			($UsuarioData->getPerfilId());
		$usuario->setGrupoEmpresarialId	($UsuarioData->getGrupoEmpresarialId());
		$usuario->setNombreUsuario		($UsuarioData->getNombreUsuario());
		$usuario->setEstadoCambioClave	($UsuarioData->getEstadoCambioClave());
		$usuario->setEstado				($UsuarioData->getEstado());
		$usuario->setFechaMod			(new \Datetime("now"));
		$usuario->setUsuarioModId		($UsuarioData->getUsuarioModId());

		$this->getEntityManager()->persist($usuario);
		$this->getEntityManager()->flush();
		return $usuario->getId();		
	}//end function modificar*/

	/*-----------------------------------------------------------------------------	 		
	public function eliminar(UsuarioData $UsuarioData){
	/*-----------------------------------------------------------------------------	 		
		$usuario = $this->getEntityManager()->find('Seguridad\Entity\Usuario', $UsuarioData->getId());	
		
		$fechaActual = new \DateTime();

		$usuario->setEstado('I');
		$usuario->setFechaMod($fechaActual);		
		$usuario->setUsuarioModId($UsuarioData->getUsuarioModId());

		$this->getEntityManager()->persist($usuario);
		$this->getEntityManager()->flush();
		return $usuario->getId();		
	}//end function modificar*/
	
	/*-----------------------------------------------------------------------------*/	 		
	public function consultar($id)
	/*-----------------------------------------------------------------------------*/	 			
	{
        $sql = "SELECT usuario.*, persona.nombre, persona.tipo_identificacion, persona.nro_identificacion, " . "       persona.estado_proveedor, persona.estado_cliente, persona.estado_empleado " . " FROM seguridad.usuario " . "      LEFT JOIN general.persona " . "           ON persona.id = usuario.persona_id " . "WHERE usuario.id = :id";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue("id", $id);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $UsuarioData = new UsuarioData();
        $PersonaData = new PersonaData();
        
        foreach ($result as $row) {
            // \Zend\Debug\Debug::dump($row->getPerfilId());
            $UsuarioData->setId($row['id']);
            $UsuarioData->setPersonaId($row['persona_id']);
            $UsuarioData->setPerfilId($row['perfil_id']);
            $UsuarioData->setGrupoEmpresarialId($row['grupo_empresarial_id']);
            $UsuarioData->setNombreUsuario($row['nombre_usuario']);
            $UsuarioData->setClave($row['clave']);
            $UsuarioData->setEstadoCambioClave($row['estado_cambio_clave']);
            $UsuarioData->setNroIntentos($row['nro_intentos']);
            $UsuarioData->setEstado($row['estado']);
            $UsuarioData->setFechaIng($row['fecha_ing']);
            $UsuarioData->setFechaMod($row['fecha_mod']);
            $UsuarioData->setUsuarioIngId($row['usuario_ing_id']);
            $UsuarioData->setUsuarioModId($row['usuario_mod_id']);
            
            $PersonaData->setId($row['persona_id']);
            $PersonaData->setNombre($row['nombre']);
            $PersonaData->setTipoIdentificacion($row['tipo_identificacion']);
            $PersonaData->setNroIdentificacion($row['nro_identificacion']);
            $PersonaData->setEstadoProveedor($row['estado_proveedor']);
            $PersonaData->setEstadoCliente($row['estado_cliente']);
            $PersonaData->setEstado($row['estado']);
        } // end foreach
        
        return array(
            $UsuarioData,
            $PersonaData
        );
    } // end functionconsultar
    
    /* ----------------------------------------------------------------------------- */
    public function consultar2($id)
    {
        /* ----------------------------------------------------------------------------- */
        $sql = "SELECT u, p " . " FROM Seguridad\Entity\Usuario u " . "  LEFT JOIN u.persona p " . "WHERE u.id = :id";
        
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter('id', $id);
        
        $result = $query->getResult();
        
        $UsuarioData = new UsuarioData();
        
        foreach ($result as $row) {
            $Persona = $row->getPersona();
            // \Zend\Debug\Debug::dump($row->getPerfilId());
            $UsuarioData->setId($row->getId());
            $UsuarioData->setPersonaId($Persona->getId());
            $UsuarioData->setNombre($Persona->getNombre());
            $UsuarioData->setTipoIdentificacion($Persona->getTipoIdentificacion());
            $UsuarioData->setNroIdentificacion($Persona->getNroIdentificacion());
            $UsuarioData->setEstadoProveedor($Persona->getEstadoProveedor());
            $UsuarioData->setEstadoCliente($Persona->getEstadoCliente());
            $UsuarioData->setEstadoEmpleado($Persona->getEstadoEmpleado());
            $UsuarioData->setEstado_Persona($Persona->getEstado());
            $UsuarioData->setPerfilId($row->getPerfilId());
            $UsuarioData->setGrupoEmpresarialId($row->getGrupoEmpresarialId());
            $UsuarioData->setNombreUsuario($row->getNombreUsuario());
            $UsuarioData->setClave($row->getClave());
            $UsuarioData->setEstadoCambioClave($row->getEstadoCambioClave());
            $UsuarioData->setNroIntentos($row->getNroIntentos());
            $UsuarioData->setEstado($row->getEstado());
            $UsuarioData->setFechaIng($row->getFechaIng());
            $UsuarioData->setFechaMod($row->getFechaMod());
            $UsuarioData->setUsuarioIngId($row->getUsuarioIngId());
            $UsuarioData->setUsuarioModId($row->getUsuarioModId());
        } // end foreach
        
        return $UsuarioData;
    } // end function consultar
    
    /* ----------------------------------------------------------------------------- */
    /**
     * Listado
     *
     * @param string $opcion            
     * @param array $condiciones            
     * @return array int Exception\InvalidArgumentException
     */
    public function listado($opcion, $condiciones)
    {
        /* ----------------------------------------------------------------------------- */
        if ($opcion == 1) {
            // $this->getEntityManager()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
            $sql = "SELECT u.id id, u.nombre_usuario nombre_usuario, u.estado_cambio_clave estado_cambio_clave, " . "	   u.nro_intentos nro_intentos, u.estado estado, " . "       c.nombre nombre_perfil, p.nombre nombre_persona ";
        } // end if
        if ($opcion == 2) {
            $sql = "SELECT COUNT(u.id) tot_reg ";
        } // end if
        
        $sql = $sql . " FROM Seguridad\Entity\Usuario u" . "  JOIN u.perfil c" . "  LEFT JOIN u.persona p " . " WHERE 1 = 1";
        
        if (! empty($condiciones['nombre_usuario'])) {
            $sql = $sql . " and u.nombre_usuario like :nombre_usuario";
        } // end if
        if (! empty($condiciones['estado'])) {
            $sql = $sql . " and u.estado = :estado";
        } // end if
        
        if ((! empty($this->sidx)) && ($opcion == 1)) {
            $sql = $sql . " ORDER BY " . $this->sidx . " " . $this->sord;
        }
        
        $query = $this->getEntityManager()->createQuery($sql);
        
        if ($opcion == 1) {
            $query->setFirstResult($this->getLimitIni())
                ->setMaxResults($this->limit);
        } // end if
        
        if (! empty($condiciones['nombre_usuario'])) {
            $query->setParameter('nombre_usuario', '%' . $condiciones['nombre_usuario'] . '%');
        } // end if
        if (! empty($condiciones['estado'])) {
            $query->setParameter('estado', $condiciones['estado']);
        } // end if
        
        try {
            if ($opcion == 1) {
                // return $query->getResult();
                return $query->getArrayResult();
            } // end if
            
            if ($opcion == 2) {
                // $result = $query->getResult();
                $result = $query->getArrayResult();
                $tot_reg = 0;
                foreach ($result as $row) {
                    $tot_reg = $row["tot_reg"];
                } // end foreach
                return $tot_reg;
            } // end if
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage() . ' DQL:' . $query->getDql());
        } // end try
    } // end function listado
    
    /* ----------------------------------------------------------------------------- */
    function login($usuario, $clave, $ipAcceso, $nombreHost, $AgenteUsuario)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_acceso_seguridad :prmUsuario,:prmClave,:prmIpAcceso,:prmNombreHost,:prmAgenteUsuario";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmUsuario', $usuario);
        $stmt->bindValue(':prmClave', $clave);
        $stmt->bindValue(':prmIpAcceso', $ipAcceso);
        $stmt->bindValue(':prmNombreHost', $nombreHost);
        $stmt->bindValue(':prmAgenteUsuario', $AgenteUsuario);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    } // end function login
    
    /* ----------------------------------------------------------------------------- */
    function getPerfilPermisos($perfilId)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_perfil_permisos :prmIdPerfil";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmIdPerfil', $perfilId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getPerfilPermisos
    
    /* ----------------------------------------------------------------------------- */
    function getModulosPerfilUsuario($usuarioId)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_modulos_perfil_usuario :prmIdUsuario";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmIdUsuario', $usuarioId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getModulosPerfilUsuario
    
    /* ----------------------------------------------------------------------------- */
    function getOpcionesModuloPerfilUsuario($moduloId, $perfilId)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_opciones_modulo_perfil_usuario :prmIdModulo,:prmIdPerfil";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmIdModulo', $moduloId);
        $stmt->bindValue(':prmIdPerfil', $perfilId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getOpcionesModuloPerfilUsuario
    
    
    
    
   /* ----------------------------------------------------------------------------- */
    /**
     * ListadoPerfilOpciones
     *
     * @param array $perfil_opciones            
     * @return array
     */
    public function listadoPerfilOpciones($id)
    {
        /* ----------------------------------------------------------------------------- */
        // $this->getEntityManager()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        $sql = ' SELECT perfil_opciones.* ';
        $sql .= ' FROM perfil_opciones ';
        $sql .= ' WHERE 1 = 1';
        
        $em = $this->getEntityManager();
        $stmt = $em->getConnection();
        $stmt = $stmt->executeQuery($sql);
        $result = $stmt->fetchAll();
        return $result;
    } // end function listado
    
    
    
    
    
    
    /* ----------------------------------------------------------------------------- */
    function getEmpresaSucursales($tipoConsulta, $usuarioId)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_usuario_empresas_sucursales :prmAccion,:prmUsuarioId";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $tipoConsulta);
        $stmt->bindValue(':prmUsuarioId', $usuarioId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getEmpresaSucursales
    
    /* ----------------------------------------------------------------------------- */
    function getUsuarioExtensiones($tipoConsulta, $usuarioId)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_usuario_extensiones :prmAccion,:prmUsuarioId";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $tipoConsulta);
        $stmt->bindValue(':prmUsuarioId', $usuarioId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getUsuarioExtensiones
    
    /* ----------------------------------------------------------------------------- */
    function getTiposExtension($tipoConsulta)
	/*-----------------------------------------------------------------------------*/
	{
        $sql = "EXEC SEGURIDAD.GET_tipos_extension :prmAccion";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->bindValue(':prmAccion', $tipoConsulta);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    } // end function getTiposExtension
}//end class