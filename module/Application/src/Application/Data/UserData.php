<?php

namespace Application\Data;

/**
* UserData.
*
*/
class UserData
{
	/**
    * @var int
	*/
    protected $id;

	/**
    * @var string
	*/
    protected $fullName;

	
	
	
	/*------------------------------------------------------------------------------*/
	/*------------------------------- METODOS GET y SET ----------------------------*/
	/*------------------------------------------------------------------------------*/

	//Metodos GET
	public function getId()								{return $this->id;}
	public function getFullName()					    {return $this->fullName;}
	

	//Metodos SET
	public function setId($valor)						{$this->id 			= $valor;}
	public function setFullName($valor)					{$this->fullName 	= $valor;}
	
}//end class	