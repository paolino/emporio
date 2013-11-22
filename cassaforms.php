<table class=GT>
<tr>
<td class=cassa>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="nuovo_acquisto"> 
	<table>
	<tr><td class=cassa> Utente </td><td class=cassa> <input class=text type=text name="utente"  size=5 ></td>
	<td class=cassa><input type="submit" value="Apertura"></td></tr>
	</table>
	</form>
</td>
<td class=cassa>
	<table>
	<tr><td class=cassa> Selezione </td><td class=cassa>
<?php include "selezioneacquisto.php";?></td></tr>
	</table>

</td>
</tr></table>
