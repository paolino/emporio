<?php include "spesasemplice.php"; ?>
<table class=GT>
<tr><td class=magazzino>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="spesa_semplice"> 
	<table>
	<tr><td> spesa </td><td> <input class=text type=text name="spesa"  size=5 ></td></tr>
	<tr><td><input type="submit" value="Spesa semplice"></td></tr>
	</table>
	</form>
</td><td>
<table class=CSSTableGenerator style="width:100%">
<?php
$rq = "SELECT * FROM quadro_articoli order by descrizione";
$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < 12; $i++) {
	echo '<tr>';
	for ($j = 0; $j < 8; $j++) {
		echo '<td>';
		$v= $trs[$i*8 + $j]['descrizione'];
		$v2 = $trs[$i*8 + $j]['articolo'];
		echo  "<form name=\"input\" action=\"cassa.php\" method=\"POST\">"; 
		echo "<input class=merce style=\"width:100%\" type=submit name=\"desc\" value=\"{$v}\">";
		echo "<input type=hidden name=\"articolo\" value=\"{$v2}\">";
		echo "<input type=hidden name=\"sql\" value=\"nuova_spesa\">";
		echo "</form>"; 
		echo '</td>';
	}
	echo '</tr>';
}
?>
</table>
</td></tr></table>
