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
          <td class=utente><button type="submit"> Nuovo o modifica utente</button></td>
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
          <tr><td class=utente></td><td class=utente><button type="submit"> Nuova valutazione </button></td></tr>
        </table>
      </form>  
    </td>


  </tr>
  <tr><!--
    <td class=utente>
      <form name="input" action="amministrazione.php" method="post">
             <button type=hidden name="sql" value="nuova_tessera"> Nuova Tessera </button>  
        <table>
          <tr><td class=utente><?php echo $campoutente ?></td></tr>
          <tr><td class=utente> PIN </td><td class=utente><input class=text type=text name="pin"  size=7></td></tr>
          <tr><td class=utente></td><td class=utente><input type="submit" value="Nuovo PIN"></td></tr>
        </table>
      </form>
    </td>-->
 <td id=ricarica>
      <form name="input" action="amministrazione.php" method="post">
         <input type=hidden name="sql" value="nuova_ricarica"> 
        <table>
          <tr><td id=ricarica></td><td id=ricarica><button type="submit"> Ricarica mensile</button></td></tr>
        </table>
      </form>
    </td>

  </tr>
   
