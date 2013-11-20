
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
 <HEAD>
  <TITLE>Emporio</TITLE>
  <link href="emporio.css" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="/jquery-ui-1.10.3/themes/base/jquery.ui.all.css">
  <script src="jquery-ui-1.10.3/jquery-1.9.1.js"></script>
  <script src="jquery-ui-1.10.3/ui/jquery.ui.core.js"></script>
  <script src="jquery-ui-1.10.3/ui/jquery.ui.widPOST.js"></script>
  <script src="jquery-ui-1.10.3/ui/jquery.ui.datepicker.js"></script>
</head>
<BODY >


 

  <?php
  session_start();
  if($_POST['acquisto'] != "") $_SESSION['acquisto'] = $_POST['acquisto'];


  try {
      $db = new PDO('sqlite:emporio4');  
      $db-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $db-> query("PRAGMA foreign_keys=on;");
   	} catch(PDOException $e) 
   		{echo "<script> alert('{$e->getMessage()}') </script>";}
  
  function removeprob($s){return str_replace("'", "", $s);}
  switch($_POST['sql']) {

			case "nuovo_acquisto":
			      $q="insert into acquisti (utente) values ({$_POST['utente']})";
			      break;
			case "chiusura_acquisto":
			      $q="insert into chiusura (acquisto,pin) values ({$_POST['acquisto']},{$_POST['pin']})";
			      break;
			case "fallimento_acquisto":
			      $q="insert into fallimento (acquisto) values ({$_POST['acquisto']})";
			      break;
			case "nuova_spesa":
			      $q = "insert into spese (acquisto,articolo) values ({$_SESSION['acquisto']},{$_POST['articolo']})";
			      break;
			case "cancella_articolo":
			      $q = "insert into cancella (acquisto,articolo) values ({$_SESSION['acquisto']},{$_POST['articolo']})";
			      break;
			case "spesa_semplice":
			      $q="insert into spese_semplici (acquisto,spesa) values ({$_SESSION['acquisto']},{$_POST['spesa']})";
			      break;
			default:$q="";
			}
  unset($_POST['sql']);

  try {$db->query($q);} catch(PDOException $e) {echo "<script> alert(\"bingo {$e->getMessage()}\") </script>";}
  ?> 
  <header>
  
  <div id=nav>
	<ul>
			<li>
		<a href=index.php> Emporio solidale val taro </a>
	</li>

	<li>
		<a href=cassa.php> Cassa </a>
	</li>
		<li>
		<a href=amministrazione.php> Amministrazione</a>
		</li>
		</ul>
	</div>

  </header>
    <div class=content>

<table style="width:100%">
	<tr>
		<td>
			<table class=CSSTableGenerator2>
				<tr>
					<td>
					   <table class=CSSTableGenerator >
						<tr></tr>
							<tr>
							<td>
							  <form name="input" action="cassa.php" method="post">
									<input type=hidden name="sql" value="nuovo_acquisto"> 
								<table>
								  <tr><td> utente </td><td> <input class=text type=text name="utente"  size=5 ></td></tr>
								  <tr><td><input type="submit" value="Apri acquisto"></td></tr>
								</table>
							  </form>
							</td>
						</tr>					
<tr>
							<td>
							  <form name="input" action="cassa.php" method="post">
									<input type=hidden name="sql" value="spesa_semplice"> 
								<table>
								  <tr><td> spesa </td><td> <input class=text type=text name="spesa"  size=5 ></td></tr>
								  <tr><td><input type="submit" value="Spesa semplice"></td></tr>
								</table>
							  </form>
							</td>
						</tr>
<tr>
							<td>
							  <form name="input" action="cassa.php" method="post">
									<input type=hidden name="sql" value="chiusura_acquisto"> 
								<table>
							  
								  <tr><td> acquisto </td><td><?php
								if ($_SESSION['acquisto'] == "") 
									echo '<input class=text type=text name="acquisto"  size=5 ></td></tr>';
									else echo "<input class=text type=text name=\"acquisto\"  size=5 value={$_SESSION['acquisto']}></td></tr>";
								?>
								  <tr><td> PIN </td><td><input class=text type=password name="pin"  size=5 ></td></tr>
								  <tr><td><input type="submit" value="Fine acquisto"></td></tr>
								</table>
							  </form>
							</td>
						</tr><tr>

							<td>
							  <form name="input" action="cassa.php" method="post">
									<input type=hidden name="sql" value="fallimento_acquisto"> 
								<table>
							  
								  <tr><td> acquisto </td><td><?php
								if ($_SESSION['acquisto'] == "") 
									echo '<input class=text type=text name="acquisto"  size=5 ></td></tr>';
									else echo "<input class=text type=text name=\"acquisto\"  size=5 value={$_SESSION['acquisto']}></td></tr>";
								?>
								  <tr><td><input type="submit" value="Fallimento acquisto"></td></tr>
								</table>
							  </form>
							</td>
						  </tr>
						 </table>
						</td>
						<td>
							          <table class=CSSTableGenerator style="width:auto">   

      <?php   
	   $rq = "SELECT acquisto,utente,residuo FROM acquisti_aperti join utenti using(utente)";
   	$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
   	$tks= array("acquisto","utente","residuo");
      ?>
      <tr>
        <?php
        echo '<th style="width: 50px">selezione</th>';
        foreach($tks as $k){
          echo '<th>';
          print_r ($k);
          echo '</th>';
        }
        ?>
      </tr>
      
      <?php
      
      foreach ($trs as $k => $q) {
        echo '<tr>';
        echo '<form action="cassa.php" method=POST>';  
        echo "<td style=\"width: 50px\" > <input class=selezioni onClick=\"this.form.submit()\" type=submit name=acquisto value=\"" ;
        echo $q['acquisto']; 
        echo  ("\"></td></form>") ; 

        foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
        echo '</tr>';
      }
  
      ?>
    </table>
    <table class=CSSTableGenerator style="width:auto" >   

      <?php   
	   $rq = "SELECT articolo,descrizione,numero,valore FROM scontrino where acquisto={$_SESSION['acquisto']} order by descrizione";
   	$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
   	$tks=array("articolo","descrizione","numero","valore");
      ?>
      <tr>
        <?php
        echo '<th style="width: 50px">storno</th>';
        foreach($tks as $k){
          echo '<th>';
          print_r ($k);
          echo '</th>';
        }
        ?>
      </tr>
      <?php
      foreach ($trs as $k => $q) {
        echo '<tr>';
        echo '<form action="cassa.php" method=POST>';  
        echo "<td style=\"width: 50px\" > 
		<input type=\"hidden\" name=\"sql\" value=\"cancella_articolo\">
		<input class=selezioni onClick=\"this.form.submit()\" type=submit name=articolo value=\"" ;
        print_r ($q['articolo']); 
        echo  ("\"></form> </td>") ; 

        foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
        echo '</tr>';
      }
      ?>
    </table>
	</td>
	</tr>
	

<tr>
<td  colspan=2>
  <table class=CSSTableGenerator style="width:100%">
  <tr> </tr>   
  <?php
  $rq = "SELECT * FROM quadro_articoli order by descrizione";
  $trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);

  for ($i = 0; $i < 12; $i++) {
  		echo '<tr>';
  		for ($j = 0; $j < 8; $j++) {
  			echo '<td>';
  			$v= $trs[$i*8 + $j]['descrizione'];
  			$v2 = $trs[$i*8 + $j]['articolo'];
 			echo  "<form name=\"input\" action=\"cassa.php\" method=\"POST\">"; 
  			echo "<input class=merce style=\"width:100%\" type=submit name=\"desc\" value=\"{$v}\">";
  			echo "<input type=hidden name=\"articolo\" value=\"{$v2}\">";
  			 echo "<input type=hidden name=\"sql\" value=\"nuova_spesa\">";
  			echo "</form>"; 
  			echo '</td>';
  			}
  		echo '</tr>';
  		}
  	?>
 </table>
</td>
</tr>
</table>
</div>
<footer>
Logic and design: paolo.veronelli@gmail.com
</footer>

</BODY>
</HTML>


