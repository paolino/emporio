<td rowspan=2>
 <form  action="cassa.php" method="POST">
<table class=CSSTableGenerator >
<?php
$rq = "SELECT * FROM prezzi order by prezzo";
$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < 4; $i++) {
	echo '<tr>';
	for ($j = 0; $j < 4; $j++) {
		$v= 1 + $i*4 + $j;
		if ($v == $_SESSION['moltiplicatore'])
			echo '<td id=moltiplicatore>';
		else echo '<td>';		
		echo "<input class=merce style=\"width:100%\" type=submit name=\"moltiplicatore\" value=\"{$v}\">";
		echo "<input type=hidden name=\"sql\" value=\"imposta_moltiplicatore\">";
		echo '</td>';
	}
	echo '</tr>';
}
?>
</table>
</form>

</td><td  rowspan=2>
<form  action="cassa.php" method="POST">
<table class=CSSTableGenerator >
<?php
$rq = "SELECT * FROM prezzi order by prezzo";
$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < 5; $i++) {
	echo '<tr>';
	for ($j = 0; $j < 5; $j++) {
		echo '<td>';
		$v= $trs[$i*5 + $j]['prezzo'];
		echo "<input class=merce style=\"width:100%\" type=submit name=\"prezzo\" value=\"{$v}\">";
		echo "<input type=hidden name=\"sql\" value=\"nuova_spesa\">";
		echo '</td>';
	}
	echo '</tr>';
}
?>
</table>
</form>
</td>
