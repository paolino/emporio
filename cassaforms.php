<table class=GT>
<tr>
<td class=cassa>
	<form name="input" action="cassa.php" method="post">
	<input type=hidden name="sql" value="nuovo_acquisto"> 
	<table>
	<tr><td > Tessera </td><td > <input class=text type=text name="colloquio"  size=3 ></td>
	<td >/<input id=tessera class=text type=text name="utente"  size=3></td>
	<td > <button type="submit"> Apertura </button></td></tr>
	</table>
	</form>
</td>
<td class=cassa>
	<table>
	<tr><td> Selezione </td><td >
        <?php include "selezioneacquisto.php";?></td></tr>
	</table>

</td>
</tr></table>
