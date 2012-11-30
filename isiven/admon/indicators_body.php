<?php if(isset($_SESSION['id_entity'])){?>
<?php
	$entity_id =$_SESSION['id_entity'];
	
	if(isset($_REQUEST['save'])){
		if ($_REQUEST['title'] == '' || $_REQUEST['price'] == '')
			echo '<div class="error">El campo T&iacute;tulo y Precio son obligatorio.</div>';
		else{
			$lang = utf8_encode($_REQUEST['lang']);
			$price = utf8_encode($_REQUEST['price']);
			$title = utf8_encode($_REQUEST['title']);

			$query = "INSERT INTO indicators (lang, title, price, status_id, date_admission)VALUES('$lang', '$title', '$price', 2, NOW());";
			$result = mysql_query($query);
			
			if($result){
				echo '<div class="success">El indicador se ha guardado correctamente.</div>';
			}else
				echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('agregando archivo') .'</div>';
		}
	}
	if(isset($_REQUEST['edit'])){
		if ($_REQUEST['title'] == '' || $_REQUEST['price'] == '')
			echo '<div class="error">El campo T&iacute;tulo es obligatorio.</div>';
		else{
			$lang = utf8_encode($_REQUEST['lang']);
			$price = utf8_encode($_REQUEST['price']);
			$title = utf8_encode($_REQUEST['title']);
			$status = $_REQUEST['editStatus'];
			$id = $_REQUEST['editId'];

			$query = "UPDATE indicators SET lang='$lang', title='$title', price='$price', status_id=$status, date_modified=NOW() WHERE id = $id;";
			$result = mysql_query($query);
			
			if($result){
				echo '<div class="success">El indicador se a editado correctamente.</div>';
			}else
				echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('actualizando archivo') .'</div>';
		}
	}
	if(isset($_REQUEST['mod'])){
		if ($_REQUEST['mod'] == 'edit') {
			$id = $_REQUEST['id'];
			
			$qryEdit = "SELECT * FROM indicators WHERE id = $id AND status_id <> 4;";
			$rstEdit = mysql_query($qryEdit);
			$rowEdit = mysql_fetch_array($rstEdit);
		}elseif($_REQUEST['mod'] == 'remove'){
			$id = $_REQUEST['id'];
			
			$qryRemove = "DELETE FROM indicators WHERE id = $id;";
			if(mysql_query($qryRemove))
				echo '<div class="success">El indicador se elimin&oacute; correctamente.</div>';
			else
				echo '<div class="error">Hubo un error al eliminarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('eliminando registro') .'</div>';
			
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- TinyMCE -->
<script type="text/javascript" src="lib/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "lib/css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lib/tinymce/lists/template_list.js",
		external_link_list_url : "lib/tinymce/lists/link_list.js",
		external_image_list_url : "lib/tinymce/lists/image_list.js",
		media_external_list_url : "lib/tinymce/lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

</head>
<body role="application">
<div align="center">
	<form method="post">
		<div class="table">
			<div class="row">
				<div class="col" align="left" style="vertical-align: top;"><label for="lang">Idioma</label></div>
				<div class="col" align="left" style="vertical-align: top;">
					<select name="lang" id="lang">
						<?php if(isset($rowEdit)){?>
						<option value="<?=$rowEdit['lang']?>">
							<?php if($rowEdit['lang'] == 'es'){
								echo "Espa&ntilde;ol";
							}elseif($rowEdit['lang'] == 'en'){
								echo "English";
							}?>
						</option>
						<?php }?>
						<option value="es">Espa&ntilde;ol</option>
						<option value="en">English</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col" align="left" style="vertical-align: top;"><label for="title">T&iacute;tulo</label> <span class="text-error">*</span></div><div class="col" align="left" style="vertical-align: top;"><input type="text" name="title" id="title" value="<?=(isset($rowEdit))?utf8_decode($rowEdit['title']):''?>" /></div>
			</div>
			<div class="row">
				<div class="col" align="left" style="vertical-align: top;"><label for="Price">Precio</label> <span class="text-error">*</span><br><span class="text-info"></span></span></div> <div class="col" align="left" style="vertical-align: top;"><input type="text" name="price" id="price" value="<?=(isset($rowEdit))?utf8_decode($rowEdit['price']):''?>" /></div>
			</div>
			<div class="row">
				<div class="col">&nbsp;</div>
				<div class="col" align="right">
					<?php if(isset($rowEdit)){?>
					<input type="hidden" name="editFile" value="<?=utf8_decode($rowEdit['filename'])?>" />
					<input type="hidden" name="editStatus" value="<?=$rowEdit['status_id']?>" />
					<input type="hidden" name="editId" value="<?=$rowEdit['id']?>" />
					<input type="submit" name="edit" value="Editar" />
					<?php }else{?>
					<input type="submit" name="save" value="Guardar" />
					<?php }?>
				</div>
			</div>
		</div>
	</form>
</div>
<div align="center" style="padding: 10px;">
<div align="center" class="table">
	<div class="row">
		<div class="col" align="center"><b>Idioma</b></div>
		<div class="col" align="center"><b>T&iacute;tulo</b></div>
		<div class="col" align="center"><b>Precio</b></div>
		<div class="col" align="center"><b>Acciones</b></div>
	</div>
	<?php
	$qryPages = "SELECT * FROM indicators WHERE status_id <> 4;";
	$rstPages = mysql_query($qryPages);
	
	while($rowPages = mysql_fetch_array($rstPages)){
		$status_id = $rowPages['status_id'];
		$qryStatus =  "SELECT * FROM status WHERE id = $status_id AND status = 1;";
		$rstStatus = mysql_query($qryStatus);
		$rowStatus = mysql_fetch_array($rstStatus);
	?>
	<div class="row">
		<div class="col" align="center"><?=utf8_decode($rowPages['lang'])?></div>
		<div class="col" align="center"><?=utf8_decode($rowPages['title'])?></div>
		<div class="col" align="center"><?=utf8_decode($rowPages['price'])?></div>
		<div class="col" align="center">
			<a href="?mod=edit&id=<?=$rowPages['id']?>" class="bgWhite">Editar</a> -
			<a href="?mod=remove&id=<?=$rowPages['id']?>" class="bgWhite">Quitar</a> -
			<a href="../" class="bgWhite" target="_blank">Ver</a>
		</div>
	</div>
	<?php }?>
</div>
</div>
</body>
</html>

<?php }else echo '<script>window.location = "./"</script>'?>