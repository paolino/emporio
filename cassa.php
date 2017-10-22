<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<TITLE>Emporio, cassa</TITLE>
<?php include "head.html" ?>
</head>
<BODY >



<?php
include "access.php";
if($_POST['acquisto'] != ""){
$q = "select * from acquisti_aperti where acquisto = '{$_POST['acquisto']}'";

try {$acs = $db -> query($q) -> fetchAll(PDO::FETCH_ASSOC);} 
catch (PDOException $e) {echo "<script> alert(\"{$e->getMessage()}\") </script>";}
if ($acs[0]['acquisto'] != "") {
$_SESSION['acquisto']=$acs[0]['acquisto'];
$_SESSION['utenteacquisto'] = $acs[0]['utente'];
}
}

include "cassaquery.php";
?>

<?php include "header.html" ?>

<div class=content>
  <table class = GT>
    <tr>
      <td>
        <?php include "cassaforms.php";?>
      </td>
        <?php include "vendita.php"?>
    </tr>
    <tr> 
      <td>
        <?php if ( $_SESSION['acquisto']!=""): ?>
        <table class = asc> 
          <tr>
            <td>
              <div class=acquisto>
                <table class = GT>
                  <tr>
                    <td class=cassa>
                      <form name="input" action="cassa.php" method="post">
                        <input type=hidden name="sql" value="chiusura_acquisto"> 
                        <table>
                          <tr>
                            <td> PIN </td>
                            <td ><input class=text type=password name="pin"  size=5 ></td>
                            <td> <button id=chiusura type="submit"> Chiusura </button></td></tr>
                          </table>
                        </form>
                      </td>
                    </tr>
                    <tr>
                      <td rowspan=1>
                          <?php 
                            $q="select * from utenti where utente={$_SESSION['utenteacquisto']}";
                            $acs = $db -> query($q) -> fetchAll(PDO::FETCH_ASSOC);
                          ?>
                          <table class = asc>
                          <tbody >
                            <tr>
                              <td class = info>Tessera</td>
                              <td class = info><?php echo "{$acs[0]['colloquio']}/{$acs[0]['utente']}"?></td>
                            </tr>
                            <?php if($access && $_SESSION['acquisto']!="" ): ?>
                            <tr>
                              <td class = info>Nominativo</td>
                              <td class=info> <?php print_r ($acs[0]['nominativo']);?>
                              </td>
                            </tr>
                            <tr>
                              <td class = info>Punti</td>
                              <td class=info> <?php print_r ($acs[0]['punti']);?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                              <td class = info>Credito</td>
                              <td class = info><?php print_r ($acs[0]['residuo']);?>
                              </td>
                            </tr>
                            <tr>
                              <td class = info>Spesa</td>
                              <td class = info> <?php 
                                                    $q="select valore,numero from totali where acquisto={$_SESSION['acquisto']}";
                                                    $acs = $db -> query($q) -> fetchAll(PDO::FETCH_ASSOC);
                                                    if ($acs)
                                                    print_r ($acs[0]['valore']);
                                                    else echo "0";
                                                    ?>
                              </td>
                            </tr>
                            <tr>
                              <td class = info>Confezioni</td>
                              <td class = info> <?php if ($acs) 
                                                    print_r ($acs[0]['numero']);
                                                    else echo "0";
                                                    ?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td class=cassa>
                        <form name="input" action="cassa.php" method="post">
                          <input type=hidden name="sql" value="fallimento_acquisto"> 
                          <table>
                            <tr>
                              <td><button id=fallimento type="submit"> Fallimento </button></td>
                            </tr>
                          </table>
                        </form>
                      </td>
                    </tr>
                  </table>
                </div>
              </td>
              <td>
                <table class=acquisto>
                  <tr>
                    <td class=cassa>Scontrino</td></tr><tr><td><?php  include "scontrino.php"?></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        <?php endif;?>
      </td>
      </tr>
      <tr>
        <td> 
          <div class=asc> 
            <table>
              <tr>
                <td class=cassa>Ultimi acquisti</td></tr><tr><td> <?php  include "totale.php"?></td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>
      <?php if($_SESSION['error']): ?>
        <div id=error>
          <?php echo $_SESSION['error'];
            unset($_SESSION['error']);
          ?>
        </div>
        <?php endif;?>
    </div>
<?php include "footer.html" ?>
</BODY>
</HTML>


