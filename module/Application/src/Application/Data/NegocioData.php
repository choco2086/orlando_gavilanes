<?php

namespace Application\Data;

/**
* UserData.
*
*/
class NegocioData
{
	/**
    * @var int
	*/
    protected $id;
    
    
    /**
     * @var int
     */
    protected $categoria_id;
    
    
    /**
     * @var int
     */
    protected $persona_id;
    
    
   
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
    protected $telefono_mobil;
    
    /**
     * @var string
     */
    protected $telefono_fijo;
    
    
    /**
     * @var string
     */
    protected $pagina_web;
    
    
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
    protected $estado;
     
	
	
	/*------------------------------------------------------------------------------*/
	/*------------------------------- METODOS GET y SET ----------------------------*/
	/*------------------------------------------------------------------------------*/

	//Metodos GET
	public function getId()								{return $this->id;}
	public function getCategoriaId()					{return $this->categoria_id;}
	public function getPersonaId()					    {return $this->persona_id;}
	
	public function getNombre()					        {return $this->nombre;}
	public function getDireccion()					    {return $this->direccion;}
	public function getTelefonoMovil()					{return $this->telefono_movil;}
	public function getTelefonoFijo()					{return $this->telefono_fijo;}
	public function getEmail()					        {return $this->email;}
	public function getWeb()					        {return $this->web;}
	public function getDescripcion()					{return $this->descripcion;}
	public function getUrlFoto()					    {return $this->url_foto;}
	public function getLocalizacionLongitud()		    {return $this->localizacion_longitud;}
	public function getLocalizacionLatitud()		    {return $this->localizacion_latitud;}
	public function getLocalidad()		                {return $this->localidad;}
	
	

	//Metodos SET
	
	public function setId($valor)								{ $this->id                    = $valor;}
	public function setCategoriaId($valor)					    { $this->categoria_id           = $valor;}
	public function setPersonaId($valor)					    { $this->persona_id            = $valor;}
	public function setNombre($valor)					        { $this->nombre                = $valor;}
	public function setDireccion($valor)					    { $this->direccion             = $valor;}
	public function setTelefonoMovil($valor)					{ $this->telefono_movil        = $valor;}
	public function setTelefonoFijo($valor)					    { $this->telefono_fijo         = $valor;}
	public function setEmail($valor)					        { $this->email                 = $valor;}
	public function setWeb($valor)					            { $this->web                   = $valor;}
	public function setDescripcion($valor)					    { $this->descripcion           = $valor;}
	public function setUrlFoto($valor)					        { $this->url_foto              = $valor;}
	public function setLocalizacionLongitud($valor)		        { $this->localizacion_longitud= $valor;}
	public function setLocalizacionLatitud($valor)		        { $this->localizacion_latitud  = $valor;}
	public function setLocalidad($valor)		                { $this->localidad             = $valor;}
	
	
}//end class	