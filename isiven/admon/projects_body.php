<?php if(isset($_SESSION['id_entity'])){?>
<?php
	$entity_id =$_SESSION['id_entity'];
	
	if(isset($_REQUEST['save'])){
		if ($_REQUEST['title'] == '')
			echo '<div class="error">El campo T&iacute;tulo es obligatorio.</div>';
		else{
			$lang = utf8_encode($_REQUEST['lang']);
			$filename = utf8_encode($_REQUEST['filename']);
			$title = utf8_encode($_REQUEST['title']);
			$body = utf8_encode('<fieldset><legend align="right">'. $title .'</legend>'. $_REQUEST['body'] .'</fieldset>');

			$query = "INSERT INTO pages (lang, title, filename, body, status_id, entities_id, date_admission)VALUES('$lang', '$title', '$filename', '$body', 2, $entity_id, NOW());";
			$result = mysql_query($query);
			
			if($result){
				if($fp = fopen('../cloud_'. clear_for_file($filename) .'.php', 'w')){
					fwrite($fp, $body);
					fclose($fp);
					
					echo '<div class="success">Su p&aacute;gina se a guardado correctamente, pero debe publicarse para que se vea al p&uacute;blico.</div>';
				}else
					echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('creando archivo') .'</div>';
			}else
				echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('agregando archivo') .'</div>';
		}
	}
	if(isset($_REQUEST['edit'])){
		if ($_REQUEST['title'] == '')
			echo '<div class="error">El campo T&iacute;tulo es obligatorio.</div>';
		else{
			$lang = utf8_encode($_REQUEST['lang']);
			$filename = utf8_encode($_REQUEST['filename']);
			$title = utf8_encode($_REQUEST['title']);
			$body = utf8_encode($_REQUEST['body']);
			$oldFile = utf8_encode($_REQUEST['editFile']);
			$status = $_REQUEST['editStatus'];
			$id = $_REQUEST['editId'];

			$query = "UPDATE pages SET lang='$lang', title='$title', filename='$filename', body='$body', status_id=$status, entities_id=$entity_id, date_modified=NOW() WHERE id = $id;";
			$result = mysql_query($query);
			
			if($result){
				if(rename('../cloud_'. clear_for_file($oldFile) .'.php', '../cloud_'. clear_for_file($title) .'.php')){
					if($fp = fopen('../cloud_'. clear_for_file($filename) .'.php', 'w')){
						fwrite($fp, $body);
						fclose($fp);
						
						echo '<div class="success">Su p&aacute;gina se a editado correctamente, pero debe publicarse para que se vea al p&uacute;blico.</div>';
					}else
						echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('creando archivo') .'</div>';
				}else
					echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('renombrando archivo') .'</div>';
			}
			else
				echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('actualizando archivo') .'</div>';
		}
	}
	if(isset($_REQUEST['status'])){
		$id =  $_REQUEST['id'];
		
		$query = "UPDATE pages SET status_id = 3, date_modified = NOW() WHERE id = $id;";
		$result = mysql_query($query);
		
		if($result)
			echo '<div class="success">Su p&aacute;gina se a publicado correctamente.</div>';
		else
			echo '<div class="error">Hubo un error al publicarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('actualizando estado') .'</div>';
	}
	if(isset($_REQUEST['mod'])){
		if ($_REQUEST['mod'] == 'edit') {
			$id = $_REQUEST['id'];
			
			$qryEdit = "SELECT * FROM pages WHERE id = $id AND status_id <> 4;";
			$rstEdit = mysql_query($qryEdit);
			$rowEdit = mysql_fetch_array($rstEdit);
		}elseif($_REQUEST['mod'] == 'remove'){
			$id = $_REQUEST['id'];
			
			$qryPages = "SELECT * FROM pages WHERE id = $id;";
			$rstPages = mysql_query($qryPages);
			$rowPages = mysql_fetch_array($rstPages);
			
			if(unlink('../cloud_'. clear_for_file($rowPages['filename']) .'.php')){
				$qryRemove = "DELETE FROM pages WHERE id = $id;";
				if(mysql_query($qryRemove))
					echo '<div class="success">Su p&aacute;gina se elimin&oacute; correctamente.</div>';
				else
					echo '<div class="error">Hubo un error al eliminarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('eliminando registro') .'</div>';
			}else
				echo '<div class="error">Hubo un error al eliminarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('quitando archivo') .'</div>';
			
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
				<div class="col" align="left" style="vertical-align: top;"><label for="filename">Nombre del archivo</label> <span class="text-error">*</span><br><span class="text-info">(No se admiten espacios, ni caract&eacute;res especiales)</span></span></div> <div class="col" align="left" style="vertical-align: top;"><input type="text" name="filename" id="filename" value="<?=(isset($rowEdit))?utf8_decode($rowEdit['filename']):''?>" /></div>
			</div>
			<div class="row">
				<div class="col" align="left" style="vertical-align: top;"><label for="title">T&iacute;tulo</label> <span class="text-error">*</span></div><div class="col" align="left" style="vertical-align: top;"><input type="text" name="title" id="title" value="<?=(isset($rowEdit))?utf8_decode($rowEdit['title']):''?>" /></div>
			</div>
			<div class="row">
				<div class="col" align="left" style="vertical-align: top;"><label for="body">Contenido</label></div>
				<div class="col" align="left" style="vertical-align: top;">
					<textarea id="body" name="body" rows="15" cols="80" style="width: 100%">
						<?=(isset($rowEdit))?utf8_decode($rowEdit['body']):''?>
					</textarea>
				</div>
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
		<div class="col" align="center"><b>Estado</b></div>
		<div class="col" align="center"><b>Acciones</b></div>
	</div>
	<?php
	$qryPages = "SELECT * FROM pages WHERE status_id <> 4;";
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
		<div class="col <?=($status_id == 2)?"text-process":($status_id == 3)?"text-success":($status_id == 4)?"text-error":""?>" align="center" title="<?=utf8_decode($rowStatus['description'])?>"><?=utf8_decode($rowStatus['name'])?></div>
		<div class="col" align="center">
			<?php if ($status_id == 2) {?>
				<a href="?status=<?=$rowPages['status_id']?>&id=<?=$rowPages['id']?>" class="bgWhite">Publicar</a> -
			<?php }?>
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