<table class=GT>
<tr>
<td class=cassa>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="nuovo_acquisto"> 
	<table>
	<tr><td class=cassa> utente </td><td class=cassa> <input class=text type=text name="utente"  size=5 ></td></tr>
	<tr><td class=cassa><input type="submit" value="Apri acquisto"></td></tr>
	</table>
	</form>
</td>
<td class=cassa>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="chiusura_acquisto"> 
	<table>

	<tr><td class=cassa> acquisto </td><td class=cassa><?php
	if ($_SESSION['acquisto'] == "") 
	echo '<input class=text type=text name="acquisto"  size=5 ></td></tr>';
	else echo "<input class=text type=text name=\"acquisto\"  size=5 value={$_SESSION['acquisto']}></td></tr>";
	?>
	<tr><td class=cassa> PIN </td><td class=cassa><input class=text type=password name="pin"  size=5 ></td></tr>
	<tr><td><input type="submit" value="Fine acquisto"></td></tr>
	</table>
	</form>
</td>
<td class=cassa>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="fallimento_acquisto"> 
	<table>

	<tr><td class=cassa> acquisto </td><td><?php
	if ($_SESSION['acquisto'] == "") 
	echo '<input class=text \type=text name="acquisto"  size=5 ></td></tr>';
	else echo "<input class=text type=text name=\"acquisto\"  size=5 value={$_SESSION['acquisto']}></td></tr>";
	?>
	<tr><td class=cassa><input type="submit" value="Fallimento acquisto"></td></tr>
	</table>
	</form>
</td>

</tr></table>
