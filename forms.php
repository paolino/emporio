<?php include "default.php"; ?>



    
  </tr>

  <tr>
    <td colspan=1 rowspan=2 class=utente>
      <form name="input" action="amministrazione.php" method="post">
      <input type=hidden name="sql" value="nuovo_utente"> 
        <table>      
          <tr><td class=utente> <?php echo $campocolloquio ?></td></tr>
          <tr><td class=utente> <?php echo $campoutente ?></td></tr>

          <tr><td class=utente> <?php echo $camponominativo ?></td></tr>
          <tr><td class=utente> <?php echo $campopunti ?></td></tr>
          <tr><td class=utente> <?php echo $campopin ?></td></tr>
          <tr><td class=utente> <?php echo $campovalutazione ?></td></tr>
          <tr><td class=utente> <?php echo $camporesiduo ?></td></tr>
	  <tr>
          <td class=utente><input type="submit" value="Nuovo o modifica utente"></td>
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
   
<ul id= transazione>
 <li class=transaction>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "reset" value="annulla tutte le modifiche">
			</form>

		    </li>
    <li class=transaction>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "back" value="annulla l'ultima modifica">
			</form>

		    </li>
    <li class=transaction>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "commit" value="applica indelebilmente le modifiche">
			</form>

		    </li>
    </ul>
