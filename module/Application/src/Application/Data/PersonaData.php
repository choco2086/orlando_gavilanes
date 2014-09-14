<?php

namespace Application\Data;

use Zend\Db\Sql\Ddl\Column\Float;
/**
* UserData.
*
*/
class PersonaData
{
	/**
    * @var int
	*/
    protected $id;
    
    
    /**
     * @var int
     */
    protected $tipo_persona_id;
    

	/**
    * @var string
	*/
    protected $nombre;
   
    
    /**
     * @var string
     */
    protected $direccion;
    
    /**
     * @var string
     */
    protected $telefono;
    
    
    /**
     * @var string
     */
    protected $email;
    
    
    /**
     * @var string
     */
    protected $clave;
    
    
    /**
     * @var string
     */
    protected $web;
    
    
    /**
     * @var string
     */
    protected $descripcion;
    
    
    
    /**
     * @var string
     */
    protected $url_foto;
    
    
    /**
     * @var float
     */
    protected $localizacion_latitud;
    
    
    /**
     * @var float
     */
    protected $localizacion_longuitud;
    
    
    /**
     * @var string
     */
    protected $localidad;
    
    /**
     * @var string
     */
    protected $estado_publicador;
    
    
    /**
     * @var string
     */
    protected $estado_cliente;
    
    
    /**
     * @var string
     */
    protected $estado;
     
	
	
	/*------------------------------------------------------------------------------*/
	/*------------------------------- METODOS GET y SET ----------------------------*/
	/*------------------------------------------------------------------------------*/

	//Metodos GET
	public function getId()								{return $this->id;}
	public function getTipoPersonaId()			        {return $this->tipo_persona_id;}
	public function getNombre()					        {return $this->nombre;}
	public function getDireccion()					    {return $this->direccion;}
	public function getTelefono()					    {return $this->telefono;}
	public function getEmail()					        {return $this->email;}
	public function getClave()					        {return $this->clave;}
	public function getWeb()					        {return $this->web;}
	public function getDescripcion()					{return $this->descripcion;}
	public function getUrlFoto()					    {return $this->url_foto;}
	public function getLocalizacionLonguitud()		    {return $this->localizacion_longuitud;}
	public function getLocalizacionLatitud()		    {return $this->localizacion_latitud;}
	public function getLocalidad()		                {return $this->localidad;}
	public function getEstadoPublicador()		        {return $this->estado_publicador;}
	public function getEstadoCliente()		            {return $this->estado_cliente;}
	
	
	
	
	
	

	//Metodos SET
	
	public function setId($valor)								{ $this->id                    = $valor;}
	public function setTipoPersonaId($valor)			        { $this->tipo_persona_id       = $valor;}
	public function setNombre($valor)					        { $this->nombre                = $valor;}
	public function setDireccion($valor)					    { $this->direccion             = $valor;}
	public function setTelefono($valor)					        { $this->telefono              = $valor;}
	public function setEmail($valor)					        { $this->email                 = $valor;}
	public function setClave($valor)					        { $this->clave                 = $valor;}
	public function setWeb($valor)					            { $this->web                   = $valor;}
	public function setDescripcion($valor)					    { $this->descripcion           = $valor;}
	public function setUrlFoto($valor)					        { $this->url_foto              = $valor;}
	public function setLocalizacionLonguitud($valor)		    { $this->localizacion_longuitud= $valor;}
	public function setLocalizacionLatitud($valor)		        { $this->localizacion_latitud  = $valor;}
	public function setLocalidad($valor)		                { $this->localidad             = $valor;}
	public function setEstadoPublicador($valor)		            { $this->estado_publicador     = $valor;}
	public function setEstadoCliente($valor)		            { $this->estado_cliente        = $valor;}
	
	
}//end class	