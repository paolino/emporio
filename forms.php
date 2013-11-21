<?php include "default.php"; ?>



    
  </tr>

  <tr>
    <td colspan=1 rowspan=3 class=utente>
      <form name="input" action="amministrazione.php" method="post">
      <input type=hidden name="sql" value="nuovo_utente"> 
        <table>      
          <tr><td class=utente> colloquio </td><td class=utente><input class=text type=text name="colloquio"  size=5></td></tr>
          <tr><td class=utente> utente </td><td class=utente><input class=text type=text name="utente" size=5></td></tr>

          <tr><td class=utente> nome </td><td class=utente><input class=text type=text name="nominativo" size=25></td></tr>
          <tr><td class=utente> punti </td><td class=utente><input class=text type=text name="punti" size=7></td></tr>
          <tr><td class=utente> PIN </td><td class=utente><input class=text type=text name="pin" size=7></td></tr>
          <tr><td class=utente> valutazione </td><td class=utente><input class=text type=text name="valutazione" id="date" size=9></td></tr>
          <tr><td class=utente> residuo </td><td class=utente><input class=text type=text name="residuo" size=7></td>
          <td class=utente><input type="submit" value="Nuovo utente"></td></tr>
        </table>
      </form>   
    </td>    
    <td colspan = 1 class=utente>
      <form name="input" action="amministrazione.php" method="post">
      <input type=hidden name="sql" value="nuova_valutazione">       
              <table>      
          <tr><td class=utente><?php echo $campoutente ?></td></tr>
          <tr><td class=utente> punti </td><td class=utente><input class=text type=text name="punti"  size=7></td></tr>
          <tr><td class=utente> annotazione </td><td class=utente><input class=text type=text name="nota"  size=30></td></tr>
          <tr><td class=utente></td><td class=utente><input type="submit" value="Nuova valutazione"></td></tr>
        </table>
      </form>  
    </td>
    <td class=magazzino>
      <form name="input" action="amministrazione.php" method="post">
      <input type=hidden name="sql" value="nuovo_articolo"> 
        <table >
          <tr><td class=magazzino> valore </td><td class=magazzino><input class=text type=text name="descrizione"  size=30></td></tr>

          <tr><td class=magazzino></td><td class=magazzino><input class=magazzino type="submit" value="Nuovo prezzo"></td></tr>
        </table>
      </form>
    </td>

  </tr>
  <tr>
    <td class=utente>
      <form name="input" action="amministrazione.php" method="post">
            <input type=hidden name="sql" value="nuova_tessera"> 
        <table>
          <tr><td class=utente><?php echo $campoutente ?></td></tr>
          <tr><td class=utente> PIN </td><td class=utente><input class=text type=text name="pin"  size=7></td></tr>
          <tr><td class=utente></td><td class=utente><input type="submit" value="Nuovo PIN"></td></tr>
        </table>
      </form>
    </td>
 <td id=ricarica>
      <form name="input" action="amministrazione.php" method="post">
         <input type=hidden name="sql" value="nuova_ricarica"> 
        <table>
          <tr><td id=ricarica></td><td id=ricarica><input type="submit" value="Nuova ricarica"></td></tr>
        </table>
      </form>
    </td>

  </tr>
 <tr>         
  </tr>
 <tr>      

 <td class=transaction>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "reset" value="annulla tutte le modifiche">
			</form>

		    </td>
    <td class=transaction>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "back" value="annulla l'ultima modifica">
			</form>

		    </td>
    <td class=transaction>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "commit" value="applica indelebilmente le modifiche">
			</form>

		    </td>
	
