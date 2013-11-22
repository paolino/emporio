<table  >   

<?php   
if(!$access){
	$rq = "SELECT acquisto,utente FROM acquisti_aperti join utenti using(utente)";
	$tks= array("selezione","utente","fallimento");
	}
else {
	$rq = "SELECT acquisto,utente,nominativo,punti,residuo FROM acquisti_aperti join utenti using(utente)";
	$tks= array("selezione","utente","nominativo","punti","residuo","fallimento");
	}

$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
?>

<?php

foreach ($trs as $k => $q) {
	echo "<td style=\"width: 50px\" > 
		<form name=input action=\"cassa.php\" method=POST>
			<input type = hidden name= acquisto value={$q['acquisto']}>
			<input class onClick=\"this.form.submit()\" type=submit  value=\"" ;
	echo $q['utente']; 
	echo  ("\"></form></td>") ; 

}
if ($_SESSION['acquisto'] == "") {
	$_SESSION['acquisto'] = $trs[0]['acquisto'];
	$_SESSION['utenteacquisto'] =$trs[0]['utente'];
	}
?>
</table>

