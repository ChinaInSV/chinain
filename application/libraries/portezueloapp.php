<?php
	class PortezueloApp{
		function fechaHoraElSalvador($timestamp) {
			date_default_timezone_set('UTC');
			date_default_timezone_set("America/El_Salvador");
			$hora = strftime("%I:%M:%S %p", strtotime($timestamp));
			setlocale(LC_TIME, 'spanish');
			$fecha = utf8_encode(strftime("%A %d de %B del %Y", strtotime($timestamp)));
			return $fecha." a las ".$hora;
		}
	}
?>