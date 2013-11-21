<?php

try {
	$db = new PDO('sqlite:emporio4');  
	$db-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$db-> query("PRAGMA foreign_keys=on;");
} catch(PDOException $e) 
{echo "<script> alert('{$e->getMessage()}') </script>";}

function removeprob($s){return str_replace("'", "", $s);}
switch($_POST['sql']) {

	case "nuovo_acquisto":
		$q="insert into acquisti (utente) values ({$_POST['utente']})";
		break;
	case "chiusura_acquisto":
		$q="insert into chiusura (acquisto,pin) values ({$_POST['acquisto']},{$_POST['pin']})";
		break;
	case "fallimento_acquisto":
		$q="insert into fallimento (acquisto) values ({$_POST['acquisto']})";
		break;
	case "nuova_spesa":
		$q = "insert into spese (acquisto,articolo) values ({$_SESSION['acquisto']},{$_POST['articolo']})";
		break;
	case "cancella_articolo":
		$q = "insert into cancella (acquisto,articolo) values ({$_SESSION['acquisto']},{$_POST['articolo']})";
		break;
	case "spesa_semplice":
		$q="insert into spese_semplici (acquisto,spesa) values ({$_SESSION['acquisto']},{$_POST['spesa']})";
		break;
	default:$q="";
}
unset($_POST['sql']);

try {$db->query($q);} catch(PDOException $e) {echo "<script> alert(\"bingo {$e->getMessage()}\") </script>";}
?> 

