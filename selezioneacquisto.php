<table  >   

<?php   
	$rq = "SELECT acquisto,utente,colloquio FROM acquisti_aperti join utenti using(utente)";

$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
?>

<?php

foreach ($trs as $k => $q) {
	echo "<td style=\"width:1em\" > 
		<form name=input action=\"cassa.php\" method=POST>
			<input type = hidden name= acquisto value={$q['acquisto']}>
			<input class onClick=\"this.form.submit()\" type=submit  value=\"" ;
	echo "{$q['colloquio']}/{$q['utente']}"; 
	echo  ("\"></form></td>") ; 

}
if ($_SESSION['acquisto'] == "") {
	$_SESSION['acquisto'] = $trs[0]['acquisto'];
	$_SESSION['utenteacquisto'] =$trs[0]['utente'];
	}
?>
</table>

