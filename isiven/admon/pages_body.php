<?php if(isset($_SESSION['id_entity'])){?>
<?php
	if(isset($_REQUEST['save'])){
		if ($_REQUEST['user'] == '' || $_REQUEST['pass'] == '')
			echo '<div class="error">El usuario o clave no deben estar vacios.</div>';
		else{
			$user_mail = $_REQUEST['user'];
			$pass = $_REQUEST['pass'];

			$query = "SELECT * FROM entities WHERE (user = '$user_mail'OR mail = '$user_mail') AND pass = '$pass' AND type_id = 1;";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			
			if(mysql_num_rows($result) > 0){
				$_SESSION['id_entity'] = $row['id'];
			}else
				echo '<div class="error">El usuario o clave no son validos.</div>';
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
				<div class="col" align="left" style="vertical-align: top;"><label>T&iacute;tulo</label></div> <div class="col" align="right" style="vertical-align: top;"><input type="text" name="title" /></div>
			</div>
			<div class="row">
				<div class="col" align="left" style="vertical-align: top;"><label>Contenido</label></div>
				<div class="col" align="right" style="vertical-align: top;">
					<textarea id="body" name="body" rows="15" cols="80" style="width: 100%">
						&lt;p&gt;
							This is some example text that you can edit inside the &lt;strong&gt;TinyMCE editor&lt;/strong&gt;.
						&lt;/p&gt;
						&lt;p&gt;
						Nam nisi elit, cursus in rhoncus sit amet, pulvinar laoreet leo. Nam sed lectus quam, ut sagittis tellus. Quisque dignissim mauris a augue rutrum tempor. Donec vitae purus nec massa vestibulum ornare sit amet id tellus. Nunc quam mauris, fermentum nec lacinia eget, sollicitudin nec ante. Aliquam molestie volutpat dapibus. Nunc interdum viverra sodales. Morbi laoreet pulvinar gravida. Quisque ut turpis sagittis nunc accumsan vehicula. Duis elementum congue ultrices. Cras faucibus feugiat arcu quis lacinia. In hac habitasse platea dictumst. Pellentesque fermentum magna sit amet tellus varius ullamcorper. Vestibulum at urna augue, eget varius neque. Fusce facilisis venenatis dapibus. Integer non sem at arcu euismod tempor nec sed nisl. Morbi ultricies, mauris ut ultricies adipiscing, felis odio condimentum massa, et luctus est nunc nec eros.
						&lt;/p&gt;
					</textarea>
					<div>
						<!-- Some integration calls -->
						<a href="javascript:;" onclick="tinyMCE.get('elm1').show();return false;">[Show]</a>
						<a href="javascript:;" onclick="tinyMCE.get('elm1').hide();return false;">[Hide]</a>
						<a href="javascript:;" onclick="tinyMCE.get('elm1').execCommand('Bold');return false;">[Bold]</a>
						<a href="javascript:;" onclick="alert(tinyMCE.get('elm1').getContent());return false;">[Get contents]</a>
						<a href="javascript:;" onclick="alert(tinyMCE.get('elm1').selection.getContent());return false;">[Get selected HTML]</a>
						<a href="javascript:;" onclick="alert(tinyMCE.get('elm1').selection.getContent({format : 'text'}));return false;">[Get selected text]</a>
						<a href="javascript:;" onclick="alert(tinyMCE.get('elm1').selection.getNode().nodeName);return false;">[Get selected element]</a>
						<a href="javascript:;" onclick="tinyMCE.execCommand('mceInsertContent',false,'<b>Hello world!!</b>');return false;">[Insert HTML]</a>
						<a href="javascript:;" onclick="tinyMCE.execCommand('mceReplaceContent',false,'<b>{$selection}</b>');return false;">[Replace selection]</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">&nbsp;</div> <div class="col" align="right"><input type="submit" name="save" value="Guardar" /></div>
			</div>
		</div>
	</form>
</div>
</body>
</html>

<?php }?>