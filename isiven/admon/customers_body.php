<?php if(isset($_SESSION['id_entity'])){?>
<?php
	$entity_id =$_SESSION['id_entity'];
	
	if(($_POST['enviar'])){
		if(upload_image('files/imgs/customers','uploadImage')){
			echo '<div class="success">La imagen se a subi&oacute; correctamente. Ahora debe terminar de llenar los dem&aacute;s campos para que se publique en la galer&iacute;a.</div>';
		}
	}
	
	if(isset($_REQUEST['save'])){
		if ($_REQUEST['image'] == '')
			echo '<div class="error">La imagen es obligatoria.</div>';
		else{
			$url = utf8_encode($_REQUEST['url']);
			$name = utf8_encode($_REQUEST['name']);
			$image = utf8_encode($_REQUEST['image']);

			$query = "INSERT INTO customers (uri, name, image, status_id, date_admission)VALUES('$url', '$name', '$image', 2, NOW());";
			$result = mysql_query($query);
			
			if($result){					
				echo '<div class="success">La im&aacute;gen se a guardado correctamente.</div>';
			}else
				echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('agregando archivo') .'</div>';
		}
	}
	if(isset($_REQUEST['edit'])){
		if ($_REQUEST['image'] == '')
			echo '<div class="error">La im&aacute;gen es obligatoria.</div>';
		else{
			$url = utf8_encode($_REQUEST['url']);
			$image = utf8_encode($_REQUEST['image']);
			$name = utf8_encode($_REQUEST['name']);
			$oldFile = utf8_encode($_REQUEST['editFile']);
			$status = $_REQUEST['editStatus'];
			$id = $_REQUEST['editId'];

			$query = "UPDATE customers SET uri='$url', name='$name', image='$image', status_id=$status, date_modified=NOW() WHERE id = $id;";
			$result = mysql_query($query);
			
			if(unlink('files/imgs/customers/'. $oldFile)){
				if($result){
					echo '<div class="success">La im&aacute;gen se a editado correctamente.</div>';
				}else
					echo '<div class="error">Hubo un error al guardarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('actualizando archivo') .'</div>';
			}
		}
	}
	if(isset($_REQUEST['mod'])){
		if ($_REQUEST['mod'] == 'edit') {
			$id = $_REQUEST['id'];
			
			$qryEdit = "SELECT * FROM customers WHERE id = $id AND status_id <> 4;";
			$rstEdit = mysql_query($qryEdit);
			$rowEdit = mysql_fetch_array($rstEdit);
		}elseif($_REQUEST['mod'] == 'remove'){
			$id = $_REQUEST['id'];
			
			$rmvGallery = "DELETE FROM customers WHERE id = $id;";
			
			$qryGallery = "SELECT * FROM customers WHERE id = $id;";
			$rstGallery = mysql_query($qryGallery);
			$rowGallery = mysql_fetch_array($rstGallery);
			
			if(unlink('files/imgs/customers/'. $rowGallery['image'])){
				if(mysql_query($rmvGallery))
					echo '<div class="success">La im&aacute;gen se elimin&oacute; correctamente.</div>';
				else
					echo '<div class="error">Hubo un error al eliminarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('eliminando registro') .'</div>';
			}else
				echo '<div class="error">Hubo un error al eliminarse por favor comuniquese con el administrador del sitio <a href="mailto:contacto@krainic.com" class="bgWhite">contacto@krainic.com</a>. <br>Referencia: '. base64_encode('eliminando imagen') .'</div>';
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
<div align="center" style="border: 1px solid #E5E5E5; padding: 10px; margin: 10px;">
	<form id="form1" enctype="multipart/form-data" method="post">
		  <label>Im&aacute;gen
		<input id="uploadImage" name="uploadImage" type="file" />
		  </label>
		<input id="enviar" name="enviar" type="submit" value="Subir" />
	</form>
	<?php if($_FILES['uploadImage']['name'] || isset($rowEdit)){?>
	<div>
		<img src="files/imgs/customers/<?=($_FILES['uploadImage']['name'])?utf8_decode((date('Ymdhis')). '_' .$_FILES['uploadImage']['name']):utf8_decode($rowEdit['image'])?>" width="400" style="border:1px solid #E5E5E5; padding: 10px; margin: 10px;" />
	</div>
	<?php }?>
</div>
<div align="center">
	<form method="post">
		<input type="hidden" name="image" value="<?=($_FILES['uploadImage']['name'])?utf8_decode((date('Ymdhis')). '_' .$_FILES['uploadImage']['name']):utf8_decode($rowEdit['image'])?>" />
		<div class="table">
			<div class="row">
				<div class="col" align="left" style="vertical-align: top;"><label for="url">Sitio Web</label></div> <div class="col" align="left" style="vertical-align: top;"><input type="text" name="url" id="url" value="<?=(isset($rowEdit))?utf8_decode($rowEdit['uri']):'http://'?>" /></div>
			</div>
			<div class="row">
				<div class="col" align="left" style="vertical-align: top;"><label for="name">Nombre</label></div> <div class="col" align="left" style="vertical-align: top;"><input type="text" name="name" id="name" value="<?=(isset($rowEdit))?utf8_decode($rowEdit['name']):''?>" /></div>
			</div>
			<div class="row">
				<div class="col">&nbsp;</div>
				<div class="col" align="right">
					<?php if(isset($rowEdit)){?>
					<input type="hidden" name="editImage" value="<?=utf8_decode($rowEdit['image'])?>" />
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
		<div class="col" align="center"><b>Im&aacute;gen</b></div>
		<div class="col" align="center"><b>Acciones</b></div>
	</div>
	<?php
	$qryPages = "SELECT * FROM customers WHERE status_id <> 4;";
	$rstPages = mysql_query($qryPages);
	
	while($rowPages = mysql_fetch_array($rstPages)){
		$status_id = $rowPages['status_id'];
		$qryStatus =  "SELECT * FROM customers WHERE id = $status_id AND status = 1;";
		$rstStatus = mysql_query($qryStatus);
		$rowStatus = mysql_fetch_array($rstStatus);
	?>
	<div class="row">
		<div class="col" align="center"><a href="<?=utf8_decode($rowPages['uri'])?>" title="<?=utf8_decode($rowPages['name'])?>" target="_blank"><img src="files/imgs/customers/<?=utf8_decode($rowPages['image'])?>" width="150" style="vertical-align: middle;border:1px solid #E5E5E5; padding: 10px; margin: 10px;" border="0" /></a></div>
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