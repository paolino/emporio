<td>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="nuovo_acquisto"> 
	<table>
	<tr><td> utente </td><td> <input class=text type=text name="utente"  size=5 ></td></tr>
	<tr><td><input type="submit" value="Apri acquisto"></td></tr>
	</table>
	</form>
</td>
<td>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="chiusura_acquisto"> 
	<table>

	<tr><td> acquisto </td><td><?php
	if ($_SESSION['acquisto'] == "") 
	echo '<input class=text type=text name="acquisto"  size=5 ></td></tr>';
	else echo "<input class=text type=text name=\"acquisto\"  size=5 value={$_SESSION['acquisto']}></td></tr>";
	?>
	<tr><td> PIN </td><td><input class=text type=password name="pin"  size=5 ></td></tr>
	<tr><td><input type="submit" value="Fine acquisto"></td></tr>
	</table>
	</form>
</td>
<td>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="fallimento_acquisto"> 
	<table>

	<tr><td> acquisto </td><td><?php
	if ($_SESSION['acquisto'] == "") 
	echo '<input class=text type=text name="acquisto"  size=5 ></td></tr>';
	else echo "<input class=text type=text name=\"acquisto\"  size=5 value={$_SESSION['acquisto']}></td></tr>";
	?>
	<tr><td><input type="submit" value="Fallimento acquisto"></td></tr>
	</table>
	</form>
</td>

</tr><tr>
<td>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="spesa_semplice"> 
	<table>
	<tr><td> spesa </td><td> <input class=text type=text name="spesa"  size=5 ></td></tr>
	<tr><td><input type="submit" value="Spesa semplice"></td></tr>
	</table>
	</form>
</td>
</tr><tr>
</tr><tr>

