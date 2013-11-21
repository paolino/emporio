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
<td>
<?php include "selezioneacquisto.php";?>
</td>
</tr></table>
