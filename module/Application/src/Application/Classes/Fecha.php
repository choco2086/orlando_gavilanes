<?php

namespace Application\Classes;


class Fecha {
    public static $formatoFecha = null;
    public static $arr_mes_corto = array(
    		1 => 'ENE',
    		2 => 'FEB',
    		3 => 'MAR',
    		4 => 'ABR',
    		5 => 'MAY',
    		6 => 'JUN',
    		7 => 'JUL',
    		8 => 'AGO',
    		9 => 'SEP',
    		10 => 'OCT',
    		11 => 'NOV',
    		12 => 'DIC'
 	);
    		
    public static $arr_mes_completo = array(
    		1 => 'ENERO',
    		2 => 'FEBRERO',
    		3 => 'MARZO',
    		4 => 'ABRIL',
    		5 => 'MAYO',
    		6 => 'JUNIO',
    		7 => 'JULIO',
    		8 => 'AGOSTO',
    		9 => 'SEPTIEMBRE',
    		10 => 'OCTUBRE',
    		11 => 'NOVIEMBRE',
    		12 => 'DICIEMBRE'
    );
    
    
    public static function getArrMesCorto()
    {
    	return self::$arr_mes_corto;
    }

	public static function getArrMesCompleto()
	{
		return self::$arr_mes_completo;
	}
    
    
	/*-----------------------------------------------------------------------------*/		
	public static function setFormato($valor)
	/*-----------------------------------------------------------------------------*/			
	{
		self::$formatoFecha = $valor;
	}
	
	
	
	/*-----------------------------------------------------------------------------*/			
	public static function getFormato()
	/*-----------------------------------------------------------------------------*/			
	{
		return self::$formatoFecha; 
	}

	/*-----------------------------------------------------------------------------*/	
	public static function getFechaFormato($fecha, $formato)
	/*-----------------------------------------------------------------------------*/		
	{
        if (empty($formato)){
            return ''; //'Formato invalido';
        }
 
 		//var_dump($fecha);echo("<br>");
		if (empty($fecha)){
            return '';
        }

		$dato = $fecha instanceof \DateTime;
		if ($fecha instanceof \DateTime){  //Pregunta si es tipo DateTime
			$fecha_new = $fecha;
		}else{  						   //Caso contrario es String y hay que convertilo en clase DateTime
			$fecha_new = new \DateTime($fecha);
		}//end if
		
		$dato = $fecha_new->format($formato);
		return $dato;
	}//end function


	/*-----------------------------------------------------------------------------*/		
	public static function SepararDMY($fecha)
	/*-----------------------------------------------------------------------------*/		
	{
		if (empty($fecha)){
            return '';
        }

		$dato = $fecha instanceof \DateTime;
		if ($fecha instanceof \DateTime){  //Pregunta si es tipo DateTime
			$fecha_new = $fecha;
		}else{  						   //Caso contrario es String y hay que convertilo en clase DateTime
			$fecha_new = new \DateTime($fecha);
		}//end if

		$dia = $fecha_new->format('d');
		$mes = $fecha_new->format('m');
		$anio = $fecha_new->format('Y');				
		
		return array('dia'=>$dia, 'mes'=>$mes, 'anio'=>$anio);
	}//end function


	/*-----------------------------------------------------------------------------*/			
	public static function getFechaActualServidor()
	/*-----------------------------------------------------------------------------*/			
	{
		//$formato = self::getFormato()['corta']['servidor'];   //REVISAR HAY FALLO
		$arr_fecha_data = self::getFormato();
		$formato = $arr_fecha_data['corta']['servidor'];
		$now = new \Datetime("now");
		$fecha = \Application\Classes\Fecha::getFechaFormato($now, $formato);
	
		return self::getFechaFormato($now, $formato); 
	}//end function getFechaActualServidor


	/*-----------------------------------------------------------------------------*/			
	public static function getFechaHoraActualServidor()
	/*-----------------------------------------------------------------------------*/			
	{		
		//$formato = self::getFormato()['larga']['servidor'];
		$arr_fecha_data = self::getFormato();
		$formato = $arr_fecha_data['larga']['servidor'];
		$now = new \Datetime("now");
		$fecha = \Application\Classes\Fecha::getFechaFormato($now, $formato);
	
		return self::getFechaFormato($now, $formato); 
	}//end function getFechaHoraActualServidor



	/*-----------------------------------------------------------------------------*/			
	public static function getFechaActualFrontEnd()
	/*-----------------------------------------------------------------------------*/			
	{		
		//$formato = self::getFormato()['corta']['frontend'];
		$arr_fecha_data = self::getFormato();	
		$formato = $arr_fecha_data['corta']['frontend'];
		$now = new \Datetime("now");
		$fecha = \Application\Classes\Fecha::getFechaFormato($now, $formato);

		return self::getFechaFormato($now, $formato); 
	}//end function getFechaActualFrontEnd


	/*-----------------------------------------------------------------------------*/			
	public static function getFechaHoraActualFrontEnd()
	/*-----------------------------------------------------------------------------*/			
	{
		//$formato = self::getFormato()['larga']['frontend'];
		$arr_fecha_data = self::getFormato();
		$formato = $arr_fecha_data['larga']['frontend'];
		
		$now = new \Datetime("now");
		$fecha = \Application\Classes\Fecha::getFechaFormato($now, $formato);
	
		return self::getFechaFormato($now, $formato); 
	}//end function getNowLargo


	/*-----------------------------------------------------------------------------*/			
	/**
	 * Retorna Fecha con el formato del servidor 
	 *
	 * @param string|Date $fecha
	 * @return string 
	 */	
	public static function convertirFechaPHPToFechaServidor($fecha)
	/*-----------------------------------------------------------------------------*/				
	{
		//$formato = self::getFormato()['corta']['servidor'];
		$arr_fecha_data = self::getFormato();
		$formato = $arr_fecha_data['corta']['servidor'];
		
		$fecha_new = self::getFechaFormato($fecha, $formato);
		return $fecha_new; 
	}//end function 


	/*-----------------------------------------------------------------------------*/			
	/**
	 * Retorna Fecha con el formato del servidor 
	 *
	 * @param string|Date $fecha
	 * @return string 
	 */	
	public static function convertirFechaServidorToFechaFrontEnd($fecha)
	/*-----------------------------------------------------------------------------*/				
	{
		//$formato = self::getFormato()['corta']['frontend'];
		$arr_fecha_data = self::getFormato();
		$formato = $arr_fecha_data['corta']['frontend'];
		
		$fecha_new = self::getFechaFormato($fecha, $formato);
		return $fecha_new; 
	}//end function 

	
	/*-----------------------------------------------------------------------------*/			
	/**
	 * Retorna Fecha con el formato del servidor 
	 *
	 * @param string|Date $fecha
	 * @return string 
	 */	
	public static function convertirFechaServidorToFechaFrontEnd_MesTexto($fecha)
	/*-----------------------------------------------------------------------------*/				
	{
		//Aqui falta reconocer en que posicion se encuentra el mes para realizar el reemplazo
		//por el momento se asumir� que el fronend siempre ser� con el formato d/m//yy
		$arr = self::SepararDMY($fecha);
		$dato = $arr['dia'].'/'.self::$arr_mes_corto[intval($arr['mes'])].'/'.$arr['anio'];
		unset($mes_corto, $arr);
		return $dato;
	}//end function convertirFechaServidorToFechaFrontEnd_MesTexto


}//end class Fecha
