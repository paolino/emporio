<?php

try {
	$db = new PDO('sqlite:emporio4');  
	$db-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$db-> query("PRAGMA foreign_keys=on;");
} catch(PDOException $e) 
{echo "<script> alert('{$e->getMessage()}') </script>";}

function removeprob($s){return str_replace("'", "", $s);}
$r = false;
$q="";
$z=1;
$s="";
switch($_POST['sql']) {

	case "nuovo_acquisto":
		$q="insert into acquisti (utente) values ({$_POST['utente']})";
		$s="utente inesistente o acquisto gia' aperto";
		break;
	case "chiusura_acquisto":
		$q="insert into chiusura (acquisto,pin) values ({$_SESSION['acquisto']},{$_POST['pin']})";
		$r=true;
		$s="PIN errato";
		break;
	case "fallimento_acquisto":
		$q="insert into fallimento (acquisto) values ({$_SESSION['acquisto']})";
		$r=true;
		break;
	case "nuova_spesa":
		if ($_SESSION['moltiplicatore']!=""){
			$z=$_SESSION['moltiplicatore'];
			unset ($_SESSION['moltiplicatore']);			
		}
		if($_POST['nome']) $p = "\"{$_POST['nome']}\"";
		else $p= 'null';
		$q = "insert into spese (acquisto,prezzo,prodotto) values ({$_SESSION['acquisto']},{$_POST['prezzo']},{$p})";
		$s="credito insufficiente";
		break;
	case "cancella_spesa":	
		if ($_SESSION['moltiplicatore']!=""){
			$z=$_SESSION['moltiplicatore'];
			unset ($_SESSION['moltiplicatore']);			
		}
		if($_POST['prodotto']) $p = "\"{$_POST['prodotto']}\"";
		else $p= 'null';
		 $q = "insert into cancella (acquisto,prezzo,prodotto) values ({$_SESSION['acquisto']},{$_POST['prezzo']},{$p})";
		break;
	case "imposta_moltiplicatore":
		$_SESSION['moltiplicatore'] = $_POST['moltiplicatore'];
		break;
	default:
		
}
unset($_POST['sql']);
for ($i = 0; $i < $z; $i ++)
try {$db->query($q);} catch(PDOException $e) {
	if($s!= "")
		$_SESSION['error']=$s;
	else 
		echo "<script> alert(\"bingo {$e->getMessage()}\") </script>";
	}
if ($r) 
	{
	unset($_SESSION['acquisto']);
	unset($_SESSION['utenteacquisto']);
	}
?> 

