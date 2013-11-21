<table class = GT>
<tr>

<td class=cassa>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="chiusura_acquisto"> 
	<table>

	<tr><td class=cassa> PIN </td><td class=cassa><input class=text type=password name="pin"  size=5 ></td>
	<td><input type="submit" value="Fine acquisto"></td></tr>
	</table>
	</form>
</td>
<td class=cassa>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="fallimento_acquisto"> 
	<table>

	<tr><td class=cassa><input type="submit" value="Fallimento acquisto"></td></tr>
	</table>
	</form>
</td>
</tr></table>

