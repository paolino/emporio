
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<TITLE>Emporio</TITLE>
<link href="emporio.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/jquery-ui-1.10.3/themes/base/jquery.ui.all.css">
<script src="jquery-ui-1.10.3/jquery-1.9.1.js"></script>
<script src="jquery-ui-1.10.3/ui/jquery.ui.core.js"></script>
<script src="jquery-ui-1.10.3/ui/jquery.ui.widPOST.js"></script>
<script src="jquery-ui-1.10.3/ui/jquery.ui.datepicker.js"></script>
</head>
<BODY >

<script>
$(function() {
		$( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
		});
</script>



<?php
session_start();

include "access.php";

if($_SESSION['transaction'] == "") $_SESSION['transaction'] = array();
if ($access) {
	include "transact.php";
	foreach($_POST as $k => $v) $_SESSION[$k]=$v;
}	
?>  
 <header>
	<table>
	<tr>
	<td>
	<div id=nav >
		<ul><li>
			<a href=index.php> Home </a>
			</li><li>
			<a href=cassa.php> Cassa </a>
			</li><li>
			<a href=amministrazione.php> Amministrazione</a>
			</li><li>
		</ul>
	</div>
	</td>
	<td>	
	<?php if (! $access): ?> 
	<div id=login>	
		<form name="input" action="amministrazione.php" method="post">
			<input class=text type=password name="login" size=25>
			<input type="submit" value="Login">
		</form>   
	</div>
	<?php else: ?>
	
		<form name="input" action="amministrazione.php" method="post">
		        <input type=hidden name="logout" value=1>
			<input type="submit" value="Logout">
		</form> 
	<?php endif; ?>
	</td>
	</tr>
	</table>
</header>
 


<div class=content>

	<table class=GT> 
		<tr>
			<?php 
			if($_SESSION['tabella'] == "") $_SESSION['tabella'] = 'nuovoutente';
			if ($access) include 'forms.php';
			?>
		</tr>
	</table>'
	<?php if ($access) include 'report.php';
	?>

</div> 
<footer>
	Logic and design: paolo.veronelli@gmail.com
</footer>


</BODY>
</HTML>


