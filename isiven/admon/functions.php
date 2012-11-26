<?php
function clear_for_file($s) {
	$s = ereg_replace("[АЮБЦ╙]","a",$s);
	$s = ereg_replace("[аюбц]","A",$s);
	$s = ereg_replace("[ИХЙ]","e",$s);
	$s = ereg_replace("[ихй]","E",$s);
	$s = ereg_replace("[МЛН]","i",$s);
	$s = ereg_replace("[млн]","I",$s);
	$s = ereg_replace("[СРТУ╨]","o",$s);
	$s = ereg_replace("[срту]","O",$s);
	$s = ereg_replace("[ЗЫШ]","u",$s);
	$s = ereg_replace("[зыш]","U",$s);
	$s = str_replace(" ","-",$s);
	$s = str_replace("Я","n",$s);
	$s = str_replace("я","N",$s);
	$s = ereg_replace("[^A-Za-z0-9]", "", $s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return strtolower($s);
}