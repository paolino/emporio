<?php
function removeprob($s){return str_replace("'", "", $s);}

switch($_SESSION['sql']) {
	case "nuovo_utente": 
		$nominativo = removeprob($_POST['nominativo']);
		$q="insert into nuovoutente (utente,colloquio,nominativo,pin,punti,valutazione,residuo) values 
			(
			 {$_POST['utente']}
			 ,{$_POST['colloquio']}

			 ,'{$nominativo}'
			 ,{$_POST['pin']}
			 ,{$_POST['punti']}
			 ,'{$_POST['valutazione']}'
			 ,{$_POST['residuo']}
			);";
		break;
	case  "nuovo_articolo":
		$descrizione = removeprob($_POST['descrizione']);
		$q="insert into articoli (descrizione) values 
			(
			 '{$descrizione}'
			);";
		break;
	case "carico_magazzino":
		$q="insert into carico (articolo,carico) values 
			(
			 {$_POST['articolo']}
			 ,{$_POST['carico']}
			);";
		break;
	case "nuova_ricarica":
		$q="insert into ricariche default values";
		break;
	case "nuova_valutazione":
		$note = removeprob($_POST['nota']);
		$q="insert into valutazioni (utente,punti,note) values 
			(
			 {$_POST['utente']}
			 ,{$_POST['punti']}
			 ,'{$note}'
			);";	
			break;
	case "nuova_tessera":
		$q="insert into pin (utente,pin) values ({$_POST['utente']},{$_POST['pin']})";
		break;
	case "nuovo_prezzo":
		$q="insert into prezzi (articolo,prezzo) values (
		{$_POST['articolo']}
		,{$_POST['prezzo']}
		);";
		break;			       
	case "nuovo_acquisto":
		$q="insert into acquisti (utente) values ({$_POST['utente']})";
		break;
	case "nuova_spesa":
		$q = "insert into spese (acquisto,articolo,numero) values (
		{$_POST['acquisto']}
		,{$_POST['articolo']}
		,{$_POST['numero']}
		)";
		break;
	default:		$q="";
}
if ($q!="") array_push($_SESSION['transaction'],$q);
?>

