

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<TITLE>Emporio, prodotti</TITLE>
<link href="emporio.css" rel="stylesheet" type="text/css">
<link rel="icon" href="favicon.png?v=1">

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
$_SESSION['page'] = "articoli.php";
include "access.php";

if($_SESSION['transaction'] == "") $_SESSION['transaction'] = array();
if ($access) {
include "transact.php";
foreach($_POST as $k => $v) $_SESSION[$k]=$v;
}	
?>   
<header>
	<div id=nav >
		<form name="input" action="articoli.php" method="post">
			<ul><li class=header>
				<a href=amministrazione.php>Amministrazione</a>
				</li><li class=header>
				<a href=cassa.php>Cassa</a>
				</li><li class=headerR>
				<a href=articoli.php>Articoli</a>
				</li><li>
				<?php if (! $access): ?> 
				<input class=text type=password name="login" size=25></li><li>
				<input type="submit" value="Login">
				<?php else: ?>

				<input type=hidden name="logout" value=1></li><li>
				<input type="submit" value="Logout">
				<?php endif; ?>
			</li></ul>
		</form>   
	</div>
</header>




<div class=content>

	<table class=GT> 	
		<tr><td><table class=GT id=prezzi> 	
			<th colspan=2> Gestione prezzi </th>
			<tr>
			<?php include "default.php"; ?>
			<?php if ($access) include 'prezziforms.php';?>
			</tr></table>
			</td>
		<td><table class=GT id=articoli>  
			<th colspan=2> Gestione articoli </th>
			<tr> <?php if ($access) include 'articoliforms.php';?> </tr>
			<tr> <?php if ($access) include 'articolicassa.php';?> </tr>
			</table>
			</td></tr>
		<tr>
		<table class=GT id=transazione>  
		<tr>
			<td class=transaction>
				<form name="input" action="articoli.php" method="post">
					<input type=submit name = "reset" value="annulla tutte le modifiche">
				</form>

			</td>
			<td class=transaction>
				<form name="input" action="articoli.php" method="post">
					<input type=submit name = "back" value="annulla l'ultima modifica">
				</form>

			</td>
			<td class=transaction>
				<form name="input" action="articoli.php" method="post">
					<input type=submit name = "commit" value="applica indelebilmente le modifiche">
				</form>

			</td>
		</tr>
			</table>
			</tr>
	</table>

</div> 
<?php include "footer.html" ?>

</BODY>
</HTML>


