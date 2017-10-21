<?php
function removeprob($s){return str_replace("'", "", $s);}

switch($_POST['sql']) {
	case "nuovo_utente": 
		$nominativo = removeprob($_POST['nominativo']);
		$q="insert or replace into nuovoutente (utente,colloquio,nominativo,pin,punti,valutazione,residuo) values 
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
	case  "eliminazione_prezzo":
		$q="delete from prezzi where prezzo= ({$_POST['prezzo']});";
		break;

	case  "nuovo_prezzo":
		$descrizione = removeprob($_POST['descrizione']);
		$q="insert into prezzi values 
			(
			 '{$descrizione}'
			);";
		break;
	case  "nuovo_articolo":
		$descrizione = removeprob($_POST['descrizione']);
		$q="replace into prodotti values 
			(
			 '{$descrizione}',
			{$_POST['valore']}
			);";
		break;
	case  "eliminazione_articolo":
		$descrizione = removeprob($_POST['descrizione']);
		$q="delete from prodotti where nome='{$descrizione}'";
		break;
	case "in_cassa":
		$prodotto = removeprob($_POST['prodotto']);
		$q="insert into cassa values ('{$prodotto}')";
		break;
	case "out_cassa":
		$prodotto = removeprob($_POST['prodotto']);
		$q="delete from cassa where prodotto='{$prodotto}'";
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
	default:		$q="";
}
if ($q!="") array_push($_SESSION['transaction'],$q);
?>

