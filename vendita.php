<td  rowspan=2>
<table class=CSSTableGenerator>
<tbody  >
<?php
$rq = "SELECT nome,prezzo FROM cassa join prodotti on prodotto=nome order by nome";
$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
foreach($trs as $tr) {
	echo '<tr>';
	echo '<td>';
	echo '<form  action="cassa.php" method="POST">';
	echo "<input class=merce style=\"width:100%\" type=submit name=\"nome\" value=\"{$tr['nome']}\">";
	echo "<input type=hidden name=\"sql\" value=\"nuova_spesa\">";
	echo "<input type=hidden name=\"prezzo\" value=\"{$tr['prezzo']}\">";
	echo '</form>';
	echo '</td>';
	echo '</tr>';
	}
?>
</tbody>
</table>
</td>
<td rowspan=2>
 <form  action="cassa.php" method="POST">
<table class=CSSTableGenerator >
<?php
$rq = "SELECT * FROM prezzi order by prezzo";
$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < 10; $i++) {
	echo '<tr>';
	for ($j = 0; $j < 1; $j++) {
		$v= 1 + $i*1 + $j;
		if ($v == $_SESSION['moltiplicatore'])
			echo '<td id=moltiplicatore>';
		else echo '<td>';		
		echo "<input class=molt style=\"width:100%\" type=submit name=\"moltiplicatore\" value=\"{$v}\">";
		echo "<input type=hidden name=\"sql\" value=\"imposta_moltiplicatore\">";
		echo '</td>';
	}
	echo '</tr>';
}
?>
</table>
</form>

</td>
<td  rowspan=2>
<form  action="cassa.php" method="POST">
<table class=CSSTableGenerator>
<tbody  >
<?php
$rq = "SELECT * FROM prezzi order by prezzo";
$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
function snake($r,$k,$x) { 
	if ($r % 2 == 0) return $x;
	else return ($k - $x);
	}
for ($i = 0; $i < 9; $i++) {
	echo '<tr>';
	for ($j = 0; $j < 3; $j++) {
		echo '<td>';
		$v= $trs[$j*9 + snake($j,9,$i)]['prezzo'];
		echo "<input class=merce style=\"width:100%\" type=submit name=\"prezzo\" value=\"{$v}\">";
		echo "<input type=hidden name=\"sql\" value=\"nuova_spesa\">";
		echo '</td>';
	}
	echo '</tr>';
}
?>
</tbody>
</table>
</form>
</td>

