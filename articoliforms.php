    <td class=magazzino>
      <form name="input" action="articoli.php" method="post">
      <input type=hidden name="sql" value="nuovo_articolo"> 
        <table >
          <tr><td class=magazzino> nome </td><td class=magazzino><input class=text type=text name="descrizione"  value=
		'<?php echo $_SESSION['articolo'] ?>' size=20></td></tr>
          <tr><td class=magazzino> valore </td><td class=magazzino><input class=text type=text name="valore"  size=20></td></tr>
          <tr><td class=magazzino></td><td class=magazzino><input class=magazzino type="submit" value="Definizione articolo"></td></tr>
        </table>
      </form>
    </td>
       
   <td class=magazzino>
      <form name="input" action="articoli.php" method="post">
      <input type=hidden name="sql" value="eliminazione_articolo"> 
        <table >
          <tr><td class=magazzino> nome </td><td class=magazzino><input class=text type=text name="descrizione"  value=
		'<?php echo $_SESSION['articolo'] ?>' size=20></td></tr>
          <tr><td class=magazzino></td><td class=magazzino><input class=magazzino type="submit" value="Eliminazione articolo"></td></tr>
        </table>
      </form>
    </td>
	
