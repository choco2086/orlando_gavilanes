<?php

return array(
    'phpSettings'   => array(
							'display_startup_errors'        => true,
							'display_errors'                => true,
							'max_execution_time'            => 60,
							'date.timezone'                 => 'America/Guayaquil',
							'mbstring.internal_encoding'    => 'UTF-8',
						    ),
	'formatoFecha'	=> array(
							'corta'=> array(
											'frontend' 	=> 'd-m-Y',
											'servidor'  => 'Y-m-d',
											),
							'larga'=>array(
											'frontend' 	=> 'd-m-Y H:i:s',
											'servidor'  => 'Y-m-d H:i:s',
											),
							 ),	

);


?>