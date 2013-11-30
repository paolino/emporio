



    
  </tr>

  <tr>
  </tr>
  <tr>
  </tr>
 <tr>      <td class=magazzino>
      <form name="input" action="articoli.php" method="post">
      <input type=hidden name="sql" value="nuovo_prezzo"> 
        <table >
          <tr><td class=magazzino> valore </td><td class=magazzino><input class=text type=text name="descrizione"  size=7></td></tr>

          <tr><td class=magazzino></td><td class=magazzino><input class=magazzino type="submit" value="Nuovo prezzo"></td></tr>
        </table>
      </form>
    </td>    
   <td class=magazzino>
      <form name="input" action="articoli.php" method="post">
      <input type=hidden name="sql" value="eliminazione_prezzo"> 
        <table >
          <tr><td class=magazzino> valore </td><td class=magazzino><input class=text type=text name="prezzo" value=
	"<?php echo $trs[$_SESSION['record']]['prezzo'] ?>"	 size=7></td></tr>

          <tr><td class=magazzino></td><td class=magazzino><input class=magazzino type="submit" value="Elimina prezzo"></td></tr>
        </table>
      </form>
    </td>    
 
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
       
  </tr>
 <tr>      

 <td class=transaction>
	 <form name="input" action="articoli.php" method="post">
		<input type=submit name = "reset" value="annulla tutte le modifiche">
			</form>

		    </td>
    <td class=transaction>
	 <form name="input" action="articoli.php" method="post">
		<input type=submit name = "back" value="annulla l'ultima modifica">
			</form>

		    </td>
    <td class=transaction>
	 <form name="input" action="articoli.php" method="post">
		<input type=submit name = "commit" value="applica indelebilmente le modifiche">
			</form>

		    </td>
	
