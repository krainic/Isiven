<?php
	if(isset($_REQUEST['save'])){
		if ($_REQUEST['user'] == '' || $_REQUEST['pass'] == '')
			echo '<div class="error">El usuario o clave no deben estar vacios.</div>';
		else{
			$user_mail = $_REQUEST['user'];
			$pass = $_REQUEST['pass'];

			$query = "SELECT * FROM entities WHERE (user = '$user_mail' OR mail = '$user_mail') AND pass = md5('$pass') AND type_id = 1;";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			
			if(mysql_num_rows($result) > 0){
				$_SESSION['id_entity'] = $row['id'];

				header("location: main.php");
			}else
				echo '<div class="error">El usuario o clave no son validos.</div>';
		}
	}
?>
<div align="center">
	<form method="post">
		<div class="table">
			<div class="row">
				<div class="col" align="left"><label>Usuario / Correo</label></div> <div class="col"><input type="text" name="user" /></div>
			</div>
			<div class="row">
				<div class="col" align="left"><label>Clave</label></div> <div class="col"><input type="password" name="pass" /></div>
			</div>
			<div class="row">
				<div class="col">&nbsp;</div> <div class="col" align="right"><input type="submit" name="save" value="Guardar" /></div>
			</div>
		</div>
	</form>
</div>