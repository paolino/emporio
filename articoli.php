

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
print_r ($_POST);
}	
?>   
<header>
	<div id=nav >
		<form name="input" action="articoli.php" method="post">
		<ul><li class=header>
			<a href=index.php> Home </a>
			</li><li class=header>
			<a href=amministrazione.php>Amministrazione</a>
			</li><li class=header>
			<a href=cassa.php>Cassa</a>
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
		<tr>
			<?php include "default.php"; ?>
			<?php 
			if($_SESSION['tabella'] == "") $_SESSION['tabella'] = 'nuovoutente';
			if ($access) include 'articoliforms.php';
			?>
		</tr>
	</table>'
	<?php if ($access) include 'articolicassa.php';
	?>

</div> 
<?php include "footer.html" ?>

</BODY>
</HTML>


