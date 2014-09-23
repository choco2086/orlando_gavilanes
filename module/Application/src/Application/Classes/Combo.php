<?php

namespace Application\Classes;


class Combo {

	public static $tipo_combo_dropdown = 1;
	public static $tipo_combo_datagrid = 2;

	/*-----------------------------------------------------------------------------*/		
	public static function getComboDataArray($arrData, $id, $texto_1er_elemento = "&lt;Seleccione&gt;", $color_1er_elemento = "", $tipo_cbo = 1)
	/*-----------------------------------------------------------------------------*/		
	{
		$opciones = "";	
		if ($tipo_cbo==self::$tipo_combo_dropdown){
			if ($texto_1er_elemento!=''){
				$opciones = '<option value="" style="color:\''.$color_1er_elemento.'\'">'.$texto_1er_elemento.'</option>';
			}//end if
			
			$selected = "";
			
			foreach($arrData as $clave => $valor){
				$selected  = "";
	
				if ($id==$clave){
					$selected = "selected";	
				}//end if
				$opciones = $opciones . '<option value="'.$clave.'" '.$selected.'>'.$valor.'</option>';
			}//end foreach
		}//end if

		
		return $opciones;
	}//end function


	/*-----------------------------------------------------------------------------*/		
	public static function getComboDataResultset($rsData, $campo_id, $campo_texto, $id, $texto_1er_elemento = "&lt;Seleccione&gt;", $color_1er_elemento = "", $tipo_cbo = 1)
	/*-----------------------------------------------------------------------------*/		
	{
		$opciones = " ";
		
		if ($tipo_cbo==self::$tipo_combo_dropdown)
		{		
			if ($texto_1er_elemento!=''){
			$opciones .= '<option value="" style="color:\''.$color_1er_elemento.'\'">'.$texto_1er_elemento.'</option>';
			
			}//end if
			
		
			if (isset($rsData))
			{
				foreach($rsData as $reg){
				   
					$selected  = "";
					if ($reg[$campo_id]==$id){
						$selected = "selected";	
					}//end if
					$opciones .=  '<option value="'.$reg[$campo_id].'" '.$selected.'>'.$reg[$campo_texto].'</option>';
				}//end foreach
				
				
			}//end if
		}//end if
		//$opciones .= "</select>";
		return $opciones;
	}//end function

}//end class Combo
