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
/**
    * upload_image()
 * 
 * Sube una imagen al servidor  al directorio especificado teniendo el Atributo 'Name' del campo archivo.
 * 
 * @param string $destination_dir Directorio de destino dСnde queremos dejar el archivo
 * @param string $name_media_field Atributo 'Name' del campo archivo
 * @return boolean
 */
function upload_image($destination_dir,$name_media_field){
    $tmp_name = $_FILES[$name_media_field]['tmp_name'];
    //si hemos enviado un directorio que existe realmente y hemos subido el archivo    
    if ( is_dir($destination_dir) && is_uploaded_file($tmp_name))
    {        
        $img_file  = $_FILES[$name_media_field]['name'] ;                      
        $img_type  = $_FILES[$name_media_field]['type'];   
         
        //©es una imАgen realmente?           
        if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") || strpos($img_type,"jpg")) || strpos($img_type,"png") )){
            //©Tenemos permisos para subir la imАgen?

            if(move_uploaded_file($tmp_name, $destination_dir.'/'.utf8_encode((date('Ymdhis')). '_' .$img_file))){                
                return true;
            }
        }
    }
    //si llegamos hasta aquМ es que algo ha fallado
    return false; 
}//end function