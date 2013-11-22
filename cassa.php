
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<TITLE>Emporio</TITLE>
<link href="emporio.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/jquery-ui-1.10.3/themes/base/jquery.ui.all.css">
<script src="jquery-ui-1.10.3/jquery-1.9.1.js"></script>
</head>
<BODY >




<?php
session_start();
include "access.php";

if($_POST['acquisto'] != ""){
	$q = "select * from acquisti_aperti where acquisto = '{$_POST['acquisto']}'";
	
	try {$acs = $db -> query($q) -> fetchAll(PDO::FETCH_ASSOC);} 
		catch (PDOException $e) {echo "<script> alert(\"{$e->getMessage()}\") </script>";}
	if ($acs[0]['acquisto'] != "") {
		$_SESSION['acquisto']=$acs[0]['acquisto'];
		$_SESSION['utenteacquisto'] = $acs[0]['utente'];
		}	
	}

include "cassaquery.php";

?>
 <header>
	<div id=nav >
		<form name="input" action="cassa.php" method="post">
		<ul><li class=header>
			<a href=index.php> Home </a>
			</li><li class=header>
			<a href=amministrazione.php> Amministrazione</a>
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

<table class = GT>
<tr>
<td>
<?php include "cassaforms.php";?>
<?php if ( $_SESSION['acquisto']!=""): ?>
 
<div class=acquisto>

<table class = GT>
<tr>		<td class=cassa>
		<form name="input" action="cassa.php" method="post">
		<input type=hidden name="sql" value="chiusura_acquisto"> 
		<table>

		<tr><td> PIN </td><td class=cassa><input class=text type=password name="pin"  size=5 ></td>
		<td><input type="submit" value="Chiusura"></td></tr>
		</table>
		</form>
		</td>

	<td rowspan=3>
	<?php  include "scontrino.php"?>
	</td>
	<?php include "vendita.php"?>

</tr>
<tr>
	<td rowspan=1><div id=acquistoselezionato>

		<table class = GT><tr><td class = cassa>Utente</td>
			<td class = cassa><?php echo $_SESSION['utenteacquisto']?></td>
			</tr>
		<td class = cassa>Credito</td>
		<td class = cassa><?php 
			$q="select residuo from utenti where utente={$_SESSION['utenteacquisto']}";
			$acs = $db -> query($q) -> fetchAll(PDO::FETCH_ASSOC);
			print_r ($acs[0]['residuo']);
		?>
		</td></tr></table>

	</td>	
</tr>
<tr>
		<td class=cassa>
		<form name="input" action="cassa.php" method="post">
		<input type=hidden name="sql" value="fallimento_acquisto"> 
		<table>

		<td><input type="submit" value="Fallimento"></td></tr>
		</table>
		</form>
	</td>

</tr>

</table>
</div>
<?php endif;?>
</td>
<td> <?php  include "totale.php"?></td>
</tr>
</table>
</div>
<?php if($_SESSION['error']): ?>
<div id=error>
<?php 	echo $_SESSION['error'];
	unset($_SESSION['error']);
?>
</div>
<?php endif;?>

<footer>
Logic and design: paolo.veronelli@gmail.com
</footer>

</BODY>
</HTML>


