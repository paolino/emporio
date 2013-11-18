
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

  <script>
  $(function() {
    $( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
  });
  </script>
 

  <?php
  session_start();
  if($_SESSION['transaction'] == "") $_SESSION['transaction'] = array();
 
  if($_GET['reset'] != ""){
   $_SESSION['transaction'] = array();
   foreach($_SESSION as $k => $v) unset ($_SESSION[$k]);
   unset($_SESSION['sql']);
  	}
  if ($_POST['reset'] != ""){
   $_SESSION['transaction'] = array();
   unset($_SESSION['sql']);
   unset($_POST['reset']);
  	}
  if ($_POST['back'] != ""){
   array_pop($_SESSION['transaction']);
   unset($_POST['back']);
  	}
  foreach($_POST as $k => $v) {
  	$_SESSION[$k]=$v;
  	}


  try {
      $db = new PDO('sqlite:emporio4');  
      $db-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $db-> query("PRAGMA foreign_keys=on;");
   	} catch(PDOException $e) 
   		{echo "<script> alert('{$e->getMessage()}') </script>";}
  
  function removeprob($s){return str_replace("'", "", $s);}
  switch($_SESSION['sql']) {
  		case "nuovo_utente": 
		    $nominativo = removeprob($_POST['nominativo']);
		    $q="insert into nuovoutente (utente,colloquio,nominativo,pin,punti,valutazione,residuo) values 
		          (
		          {$_POST['utente']}
		          ,{$_POST['colloquio']}
		
		          ,'{$nominativo}'
		          ,{$_POST['pin']}
		          ,{$_POST['punti']}
		          ,'{$_POST['valutazione']}'
		          ,{$_POST['residuo']}
		          );";
		          break;
		   case  "nuovo_articolo":
		       $descrizione = removeprob($_POST['descrizione']);
		       $q="insert into articoli (descrizione) values 
          		(
          		'{$descrizione}'
          		);";
          		break;
			case "carico_magazzino":
			    $q="insert into carico (articolo,carico) values 
          			(
			          {$_POST['articolo']}
			          ,{$_POST['carico']}
			          );";
			    break;
		case "nuova_ricarica":
				$q="insert into ricariche default values";
				break;
		case "nuova_valutazione":
			$note = removeprob($_POST['nota']);
			$q="insert into valutazioni (utente,punti,note) values 
			          (
		        	  {$_POST['utente']}
		          ,{$_POST['punti']}
		          ,'{$note}'
		          );";	
		       break;
		case "nuova_tessera":
		   	    $q="insert into pin (utente,pin) values ({$_POST['utente']},{$_POST['pin']})";
		   	    break;
		case "nuovo_prezzo":
		          $q="insert into prezzi (articolo,prezzo) values (
		             {$_POST['articolo']}
			          ,{$_POST['prezzo']}
			          );";
						break;			       
		case "nuovo_acquisto":
					$q="insert into acquisti (utente) values ({$_POST['utente']})";
			      break;
			case "nuova_spesa":
					$q = "insert into spese (acquisto,articolo,numero) values (
					{$_POST['acquisto']}
					,{$_POST['articolo']}
					,{$_POST['numero']}
					)";
					break;
			default:		$q="";
			}
  if ($q!="") array_push($_SESSION['transaction'],$q);
  
  unset($_SESSION['sql']);

  $db -> beginTransaction();

  foreach($_SESSION['transaction'] as $sql){
      try {$db->query($sql);} catch(PDOException $e) 
         	{
         	array_pop($_SESSION['transaction']);
         	echo "<script> alert(\"{$e->getMessage()}\") </script>";
  	       	}
      }
   


   $tks=array();
   if($_SESSION['tabella'] != ""){
   	$rcs = $db -> query("pragma table_info ({$_SESSION['tabella']})")-> fetchAll(PDO::FETCH_ASSOC);
	   foreach($rcs as $r) array_push($tks,$r['name']);
	   if (!in_array($_SESSION['colonna'],$tks)) $rq = "SELECT * FROM '{$_SESSION['tabella']}'";
	   	else $rq = "SELECT * FROM '{$_SESSION['tabella']}' order by {$_SESSION['colonna']} asc";
   	$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
 		}
 		else {
		$trs= array();
		}

  if($_SESSION['commit'] != "") {
      try {$db -> commit();} catch(PDOException $e) {echo $e->getMessage();}    
	  	$_SESSION['transaction'] = array();
	  	unset($_SESSION['commit']);
	  	header ("Location:emporio.php");
  	  	} 
  
	if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
		$utente=$trs[$_SESSION['record']]['utente'];
		$_SESSION['lastutente']=$utente;
		$campoutente= " utente <input type=\"text\" name=\"utente\" value=\"{$utente}\" size=5 >";
		}
	elseif  ($_SESSION['lastutente'] != "") 
		$campoutente= " utente <input type=\"text\" name=\"utente\" value=\"{$_SESSION['lastutente']}\" size=5 >";
	else $campoutente= " utente <input type=\"text\" name=\"utente\"  size=5 >";
	
	if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['tessera'] != null ){
		$tessera=$trs[$_SESSION['record']]['tessera'];
		$_SESSION['lasttessera']=$tessera;
		$campotessera= " tessera <input type=\"text\" name=\"tessera\" value=\"{$tessera}\" size=5 >";
		}
	elseif  ($_SESSION['lasttessera'] != "") 
		$campotessera= " tessera <input type=\"text\" name=\"tessera\" value=\"{$_SESSION['lasttessera']}\" size=5 >";
	else $campotessera= " tessera <input type=\"text\" name=\"tessera\"  size=5 >";
	
	if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['articolo'] != null ){
		$articolo=$trs[$_SESSION['record']]['articolo'];
		$_SESSION['lastarticolo']=$articolo;
		$campoarticolo= " articolo <input type=\"text\" name=\"articolo\" value=\"{$articolo}\" size=5 >";
		}
	elseif  ($_SESSION['lastarticolo'] != "") 
		$campoarticolo= " articolo <input type=\"text\" name=\"articolo\" value=\"{$_SESSION['lastarticolo']}\" size=5 >";
	else $campoarticolo= " articolo <input type=\"text\" name=\"articolo\"  size=5 >";
	
	if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['acquisto'] != null ){
		$acquisto=$trs[$_SESSION['record']]['acquisto'];
		$_SESSION['lastacquisto']=$acquisto;
		$campoacquisto= " acquisto <input type=\"text\" name=\"acquisto\" value=\"{$acquisto}\" size=5 >";
		}
	elseif  ($_SESSION['lastacquisto'] != "") 
		$campoacquisto= " acquisto <input type=\"text\" name=\"acquisto\" value=\"{$_SESSION['lastacquisto']}\" size=5 >";
	else $campoacquisto= " acquisto <input type=\"text\" name=\"acquisto\"  size=5 >";

  ?> 
  <div style="height:1024px">
  <table>
  
  <tr><td>

<div>
  <table class=CSSTableGenerator> 
  <tr> </tr> 
  <tr>
    <td>
      <form name="input" action="emporio.php" method="post">
      <input type=hidden name="sql" value="nuovo_utente"> 
        <ul>      
          <li> utente <input type="text" name="utente" size=5></li>
          <li> colloquio <input type="text" name="colloquio"  size=5></li>

          <li> nome <input type="text" name="nominativo" size=25></li>
          <li> punti <input type="text" name="punti" size=7></li>
          <li> PIN <input type="text" name="pin" size=7></li>
          <li> valutazione <input type="text" name="valutazione" id="date" size=9></li>
          <li> residuo <input type="text" name="residuo" size=7></li>
          <li><input type="submit" value="Nuovo utente"></li>
        </ul>
      </form>   
    </td>    
  </tr>
  <tr>
    <td>
      <form name="input" action="emporio.php" method="post">
         <input type=hidden name="sql" value="nuova_ricarica"> 
        <ul>
          <li><input type="submit" value="Nuova ricarica"></li>
        </ul>
      </form>
    </td>
  </tr>

  <tr> 
    <td>
      <form name="input" action="emporio.php" method="post">
      <input type=hidden name="sql" value="nuova_valutazione">       
              <ul>      
          <li><?php echo $campoutente ?></li>
          <li> punti <input type="text" name="punti"  size=7></li>
          <li> annotazione <input type="text" name="nota"  size=50></li>
          <li><input type="submit" value="Nuova valutazione"></li>
        </ul>
      </form>  
    </td>
  </tr>
  <tr>
    <td>
      <form name="input" action="emporio.php" method="post">
            <input type=hidden name="sql" value="nuova_tessera"> 
        <ul>
          <li><?php echo $campoutente ?></li>
          <li> PIN <input type="text" name="pin"  size=7></li>
          <li><input type="submit" value="Nuovo PIN"></li>
        </ul>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <form name="input" action="emporio.php" method="post">
      <input type=hidden name="sql" value="nuovo_articolo"> 
        <ul>
          <li> descrizione <input type="text" name="descrizione"  size=50></li>

          <li><input type="submit" value="Nuovo articolo"></li>
        </ul>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <form name="input" action="emporio.php" method="post">
            <input type=hidden name="sql" value="carico_magazzino"> 
        <ul>
          <li> <?php echo $campoarticolo ?></li>
          <li> carico <input type="text" name="carico"  size=7></li>
          <li><input type="submit" value="Carico magazzino"></li>
        </ul>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <form name="input" action="emporio.php" method="post">
            <input type=hidden name="sql" value="nuovo_prezzo"> 
        <ul>
          <li> <?php echo $campoarticolo ?></li>
          <li> prezzo <input type="text" name="prezzo"  size=7></li>
          <li><input type="submit" value="Nuovo prezzo"></li>
        </ul>
      </form>
    </td>
  </tr>
  
 </table>
</div>
</td></tr>
  <tr><td>

  <form action ="emporio.php" type= submit method="POST">
  <div id="trans">
  <ul >
    <li >
		<input type=submit name = "reset" value="annulla tutte le modifiche">
	</li>
		<li >
		<input type=submit name = "back" value="annulla l'ultima modifica">
		</li >
	<li>
		<input type=submit name = "commit" value="applica indelebilmente le modifiche">
	</li>
</ul>
</div>
</td></tr>


    <tr><td>
  <div style="height:400px;overflow-y: scroll; ">

		</form>    
     <form action="emporio.php" type="submit" method="POST">

      <select onChange=this.form.submit() name="tabella">  
        <?php   
        try {
          $result = $db->query("SELECT * FROM sqlite_master WHERE type='table' or type = 'view'");
          $r = $result->fetchAll(PDO::FETCH_ASSOC);
          foreach($r as $s) if($s['name'] == $_SESSION['tabella']) {
           echo "<option value='{$s['name']}' selected >{$s['name']}</option>";
         } else {
           echo "<option value='{$s['name']}'>{$s['name']}</option>";
         }
       }
       catch(PDOException $e) {
        echo $e->POSTMessage();
      }

      ?>
    </select>

  </form>
  
  <form action="emporio.php" type="submit" method="POST">
    <table class=CSSTableGenerator >   

      <?php   

      ?>
      <tr>
        <?php
        echo '<th style="width: 50px">selezione</th>';
        foreach($tks as $k){
          echo '<th>';  
	  echo '<div style="width:100%">';
          echo "<input class=orderer type=submit onclick=\"this.form.submit()\" name=colonna value=\"";
          print_r ($k);
          echo "\">";
          echo '</div></th>';
        }
        ?>
      </tr>
      <?php
      foreach ($trs as $k => $q) {
        echo '<tr>';

        echo "<td style=\"width: 50px\" > <input onClick=\"this.form.submit()\" type=radio name=record value=\"" ;
        print_r ($k); 
        echo  ("\"> </td>") ; 

        foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
        echo '</tr>';
      }
      ?>
    </table>

  </form>
</div>
</td></tr>
<tr><td>
<h1 class="c1"><a name="h.iytujk9760va"></a><span>Aiuto</span></h1><h2 class="c1"><a name="h.juic71i43yai"></a><span>Eventi</span></h2><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Nuovo utente</span><span>: definizione di un nuovo utente. Sia numero utente che numero colloquio devono essere unici nell&rsquo;archivio. (Colloquio progressivo?). Il pin deve essere un numero maggiore di mille. Punti e valutazione si riferiscono alla valutazione derivata dal colloquio. Il residuo sono i punti che la tessera si ritrova al momento dell&rsquo;inserimento per un utente gi&agrave; attivo, o per tenere conto del mese iniziato.</span></p><p class="c1 c2"><span></span></p><p class="c1"><span class="c0">Nuova ricarica</span><span>: ricarica di tutti i residui ai punti assegnati nell&rsquo;ultima valutazione dell&rsquo;utente o annullamento del residuo nel caso di un tempo di 6 mesi trascorso dall&rsquo;ultima valutazione.</span></p><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Nuova valutazione</span><span>: inserimento dei punti assegnati ad un utente durante l&rsquo;ultima valutazione</span></p><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Nuovo PIN</span><span>: assegnazione di un nuovo PIN nel caso di perdita di affidabilit&agrave;</span></p><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Nuovo articolo</span><span>: semplice descrizione della confezione</span></p><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Carico magazzino</span><span>: carico in magazzino per ingresso di un numero di confezioni per un articolo</span></p><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Nuovo prezzo</span><span>: assegnamento del prezzo attuale ad un articolo</span></p><h2 class="c1"><a name="h.vkho6hvm6rtj"></a><span>Transazioni</span></h2><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Annulla tutte le modifiche</span><span>: annulla la transazione cancellando lo stack di eventi in prova.</span></p><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Annulla l&rsquo;ultima modifica</span><span>: cancella l&rsquo;ultimo evento dallo stack di eventi. Avviene in automatico in caso di errore nell&rsquo;esecuzione dell&rsquo;evento.</span></p><p class="c2 c1"><span></span></p><p class="c1"><span class="c0">Applica indelebilmente le modifiche</span><span>: esegue definitivamente l&rsquo;effetto degli eventi sugli archivi.</span></p><h2 class="c1"><a name="h.smlw9zknvxqn"></a><span>Selezione</span></h2><p class="c2 c1"><span></span></p><p class="c1"><span>Selezionando una riga della tabella si inseriscono nei campi evento gli indici corrispondenti nei campi della riga selezionata.</span></p>

</td></tr>
</table>
</div>
</BODY>
</HTML>


