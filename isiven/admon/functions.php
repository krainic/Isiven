<?php
function clear_for_file($s) {
	$s = ereg_replace("[����]","a",$s);
	$s = ereg_replace("[����]","A",$s);
	$s = ereg_replace("[���]","e",$s);
	$s = ereg_replace("[���]","E",$s);
	$s = ereg_replace("[���]","i",$s);
	$s = ereg_replace("[���]","I",$s);
	$s = ereg_replace("[�����]","o",$s);
	$s = ereg_replace("[����]","O",$s);
	$s = ereg_replace("[���]","u",$s);
	$s = ereg_replace("[���]","U",$s);
	$s = str_replace(" ","-",$s);
	$s = str_replace("�","n",$s);
	$s = str_replace("�","N",$s);
	$s = ereg_replace("[^A-Za-z0-9]", "", $s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return strtolower($s);
}