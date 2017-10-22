<?php
session_start();
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<TITLE>Emporio, prodotti</TITLE>
<?php include "head.html" ?>
</head>
<BODY >

<script>
$(function() {
		$( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
		});
</script>



<?php
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
				<button type="submit" value="Login">Login </button>
				<?php else: ?>

				<input type=hidden name="logout" value=1></li><li>
				<button type="submit" value="Logout">Logout </button>
				<?php endif; ?>
			</li></ul>
		</form>   
	</div>
</header>




<div class=content>

<ul id= transazione>
 <li class=transaction>
	 <form name="input" action="articoli.php" method="post">
		<button type=submit name = "reset" value=1> Annulla tutte le modifiche </button>
			</form>

		    </li>
    <li class=transaction>
	 <form name="input" action="articoli.php" method="post">
		<button type=submit name = "back" value=1> Annulla l'ultima modifica </button>
			</form>

		    </li>
    <li class=transaction>
	 <form name="input" action="articoli.php" method="post">
		<button type=submit name = "commit" value=1> Applica indelebilmente le modifiche </button>
			</form>

		    </li>
    </ul>
	<table class=GT> 	

		<tr>
		<!--
		<td><table class=GT id=prezzi> 	
			<th colspan=2> Gestione prezzi </th>
			<tr>
			<?php include "default.php"; ?>
			<?php if ($access) include 'prezziforms.php';?>
			</tr></table>
			</td>
		--!>
		<td><table class=GT id=articoli>  
			<th colspan=2> Gestione articoli </th>
			<tr> <?php if ($access) include 'articoliforms.php';?> </tr>
			<tr> <?php if ($access) include 'articolicassa.php';?> </tr>
		   </table>
		</td>
		</tr>
	</table>

</div> 
<?php include "footer.html" ?>

</BODY>
</HTML>


