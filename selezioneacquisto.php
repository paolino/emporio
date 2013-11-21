<table class=CSSTableGenerator >   

<?php   
if(!$access){
	$rq = "SELECT acquisto,utente,residuo FROM acquisti_aperti join utenti using(utente)";
	$tks= array("acquisto","utente","residuo");
	}
else {
	$rq = "SELECT acquisto,utente,nominativo,punti,residuo FROM acquisti_aperti join utenti using(utente)";
	$tks= array("acquisto","utente","nominativo","punti","residuo");
	}

$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
?>
<tr>
<?php
echo '<th style="width: 50px">selezione</th>';
foreach($tks as $k){
	echo '<th>';
	print_r ($k);
	echo '</th>';
}
?>
</tr>

<?php

foreach ($trs as $k => $q) {
	echo '<tr>';
	echo '<form action="cassa.php" method=POST>';  
	echo "<td style=\"width: 50px\" > <input class=selezioni onClick=\"this.form.submit()\" type=submit name=acquisto value=\"" ;
	echo $q['acquisto']; 
	echo  ("\"></td></form>") ; 

	foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
	echo '</tr>';
}
if ($_SESSION['acquisto'] == "") $_SESSION['acquisto'] = $trs[0]['acquisto'];
?>
</table>

