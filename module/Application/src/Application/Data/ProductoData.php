<?php

namespace Application\Data;


/**
* ProductoData.
*
*/
class ProductoData
{
	/**
    * @var int
	*/
    protected $id;
    
    
    /**
     * @var int
     */
    protected $negocio_catalogo_id;
    
    
   
	/**
    * @var string
	*/
    protected $descripcion;
    
    
    /**
     * @var float
     */
    protected $precio;
    
    
    /**
     * @var string
     */
    protected $url_foto;
    

    
    /**
     * @var int
     */
    protected $categoria_id;
    

    /**
     * @var string
     */
    protected $descuento;

    
    /**
     * @var string
     */
    protected $fec_publicacion;
    
    
    /**
     * @var string
     */
    protected $fec_expiracion;
    
    
    /**
     * @var string
     */
    protected $fec_ult_actualizacion;
    
    
    /**
     * @var int
     */
    protected $nro_visitas;
    
    
    
    /**
     * @var string
     */
    protected $estado;
     
	
	
	/*------------------------------------------------------------------------------*/
	/*------------------------------- METODOS GET y SET ----------------------------*/
	/*------------------------------------------------------------------------------*/

	//Metodos GET
	public function getId()								{return $this->id;}
	public function getNegocioCatalagoId()				{return $this->negocio_catalogo_id;}
	public function getDescripcion()					{return $this->descripcion;}
	public function getPrecio()					        {return $this->precio;}
   //public function getUrlFoto()					    {return $this->url_foto;}
	public function getDescuento()		                {return $this->descuento;}
	public function getFecPublicacion()		            {return $this->fec_publicacion;}
	public function getFecExpiracion()		            {return $this->fec_expiracion;}
	public function getFecUltActualizacion()		    {return $this->fec_ult_actualizacion;}
	public function getNroVisitas()		                {return $this->nro_visitas;}
	public function getEstado()		                    {return $this->estado;}
	
	

	//Metodos SET
	
	public function setId($valor)								{ $this->id                    = $valor;}
	public function setNegocioCatalagoId($valor)				{ $this->negocio_catalogo_id   = $valor;}
	public function setDescripcion($valor)					    { $this->descripcion           = $valor;}
	public function setPrecio($valor)					        { $this->precio                = $valor;}
	//public function setUrlFoto($valor)					    { $this->url_foto              = $valor;}	
	public function setDescuento($valor)					    { $this->descuento             = $valor;}
	public function setFecPublicacion($valor)					{ $this->fec_publicacion       = $valor;}
	public function setFecExpiracion($valor)					{ $this->fec_expiracion        = $valor;}
	public function setFecUltActualizacion($valor)			    { $this->fec_ult_actualizacion = $valor;}
	public function setNroVisitas($valor)			            { $this->nro_visitas           = $valor;}
	public function setEstado($valor)		                    { $this->estado                = $valor;}
	
	
	
}//end class	