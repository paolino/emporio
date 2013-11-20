
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
 
  if($_GET['logout'] != ""){
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
  if($_SESSION['tabella'] == "") $_SESSION['tabella'] = 'nuovoutente';
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
  $access=false;
  if($_SESSION['login']){
		 try {
			 $q = "select * from amministrazione where login='{$_SESSION['login']}'";
			 $acs = $db -> query($q) -> fetchAll(PDO::FETCH_ASSOC);
			 foreach($acs as $ac)$access=true;} catch(PDOException $e) 
         	{
					unset($_SESSION['login']);
         	echo "<script> alert(\"{$e->getMessage()}\") </script>";
  	      }
  	  
      }
	if ($access){
		$db -> beginTransaction();

		foreach($_SESSION['transaction'] as $sql){
				try {$db->query($sql);} catch(PDOException $e) 
						{
						array_pop($_SESSION['transaction']);
						echo "<script> alert(\"{$e->getMessage()}\") </script>";
							}
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
				header ("Location:amministrazione.php");
					} 
		
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
			$utente=$trs[$_SESSION['record']]['utente'];
			$_SESSION['lastutente']=$utente;
			$campoutente= " utente</td><td><input class=text type=text name=\"utente\" value=\"{$utente}\" size=5 >";
			}
		elseif  ($_SESSION['lastutente'] != "") 
			$campoutente= " utente</td><td><input class=text type=text name=\"utente\" value=\"{$_SESSION['lastutente']}\" size=5 >";
		else $campoutente= " utente</td><td><input class=text type=text name=\"utente\"  size=5 >";
		
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['articolo'] != null ){
			$articolo=$trs[$_SESSION['record']]['articolo'];
			$_SESSION['lastarticolo']=$articolo;
			$campoarticolo= " articolo</td><td><input class=text type=text name=\"articolo\" value=\"{$articolo}\" size=5 >";
			}
		elseif  ($_SESSION['lastarticolo'] != "") 
			$campoarticolo= " articolo</td><td><input class=text type=text name=\"articolo\" value=\"{$_SESSION['lastarticolo']}\" size=5 >";
		else $campoarticolo= " articolo</td><td><input class=text type=text name=\"articolo\"  size=5 >";

		
	
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

  <table class=CSSTableGenerator> 
  <tr> </tr> 
    <tr>
    <td>
      <form name="input" action="amministrazione.php" method="post">
        <table>      
          <tr><td> password </td><td><input class=text type=password name="login" size=12></td>
          <td><input type="submit" value="Login"></td></tr>
        </table>
      </form>   
    </td>
        <td>
      <form name="input" action="amministrazione.php" method="post">
         <input type=hidden name="sql" value="nuova_ricarica"> 
        <table>
          <tr><td></td><td><input type="submit" value="Nuova ricarica"></td></tr>
        </table>
      </form>
    </td>

        <td>
      <form name="input" action="amministrazione.php?logout=1" method="post">
        <table>      
          <tr><td></td><td><input type="submit" value="Logout"></td></tr>
        </table>
      </form>   
    </td>    
    
  </tr>

  <tr>
    <td colspan=1>
      <form name="input" action="amministrazione.php" method="post">
      <input type=hidden name="sql" value="nuovo_utente"> 
        <table>      
          <tr><td> colloquio </td><td><input class=text type=text name="colloquio"  size=5></td></tr>
          <tr><td> utente </td><td><input class=text type=text name="utente" size=5></td></tr>

          <tr><td> nome </td><td><input class=text type=text name="nominativo" size=25></td></tr>
          <tr><td> punti </td><td><input class=text type=text name="punti" size=7></td></tr>
          <tr><td> PIN </td><td><input class=text type=text name="pin" size=7></td></tr>
          <tr><td> valutazione </td><td><input class=text type=text name="valutazione" id="date" size=9></td></tr>
          <tr><td> residuo </td><td><input class=text type=text name="residuo" size=7></td>
          <td><input type="submit" value="Nuovo utente"></td></tr>
        </table>
      </form>   
    </td>    
    <td colspan = 1>
      <form name="input" action="amministrazione.php" method="post">
      <input type=hidden name="sql" value="nuova_valutazione">       
              <table>      
          <tr><td><?php echo $campoutente ?></td></tr>
          <tr><td> punti </td><td><input class=text type=text name="punti"  size=7></td></tr>
          <tr><td> annotazione </td><td><input class=text type=text name="nota"  size=30></td></tr>
          <tr><td></td><td><input type="submit" value="Nuova valutazione"></td></tr>
        </table>
      </form>  
    </td>

    <td>
      <form name="input" action="amministrazione.php" method="post">
            <input type=hidden name="sql" value="nuova_tessera"> 
        <table>
          <tr><td><?php echo $campoutente ?></td></tr>
          <tr><td> PIN </td><td><input class=text type=text name="pin"  size=7></td></tr>
          <tr><td></td><td><input type="submit" value="Nuovo PIN"></td></tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <form name="input" action="amministrazione.php" method="post">
      <input type=hidden name="sql" value="nuovo_articolo"> 
        <table>
          <tr><td> descrizione </td><td><input class=text type=text name="descrizione"  size=30></td></tr>

          <tr><td></td><td><input type="submit" value="Nuovo articolo"></td></tr>
        </table>
      </form>
    </td>
    <td>
      <form name="input" action="amministrazione.php" method="post">
            <input type=hidden name="sql" value="carico_magazzino"> 
        <table>
          <tr><td> <?php echo $campoarticolo ?></td></tr>
          <tr><td> carico </td><td><input class=text type=text name="carico"  size=7></td>
          <td><input type="submit" value="Carico magazzino"></td></tr>
        </table>
      </form>
    </td>
    <td>
      <form name="input" action="amministrazione.php" method="post">
            <input type=hidden name="sql" value="nuovo_prezzo"> 
        <table>
          <tr><td> <?php echo $campoarticolo ?></td></tr>
          <tr><td> prezzo </td><td><input class=text type=text name="prezzo"  size=7></td>
          <td><input type="submit" value="Nuovo prezzo"></td></tr>
        </table>
      </form>
    </td>
  </tr>
 <tr>      

 <td>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "reset" value="annulla tutte le modifiche">
			</form>

		    </td>
    <td>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "back" value="annulla l'ultima modifica">
			</form>

		    </td>
    <td>
	 <form name="input" action="amministrazione.php" method="post">
		<input type=submit name = "commit" value="applica indelebilmente le modifiche">
			</form>

		    </td>
    </tr>
 </table>

<div id=report>
     <form action="amministrazione.php" type="submit" method="POST">

				<select onChange=this.form.submit() name="tabella">  
					<?php   
					if ($access) {
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
					}
					?>
				</select>

		
		
<!-- tabella di report -->
    <div style="height:400px;overflow-y: scroll; ">

    <table class=CSSTableGenerator >   
      <tr>
        <?php
          if($access) {
        echo '<th style="width: 50px">selezione</th>';
        foreach($tks as $k){
          echo '<th>';  
	  echo '<div style="width:100%">';
          echo "<input class=orderer type=submit onclick=\"this.form.submit()\" name=colonna value=\"";
          print_r ($k);
          echo "\">";
          echo '</div></th>';
        }}
        ?>
      </tr>
      <?php 
      if($access) foreach ($trs as $k => $q) {
        echo '<tr>';

        echo "<td style=\"width: 50px\" > <input onClick=\"this.form.submit()\" type=radio name=record value=\"" ;
        print_r ($k); 
        echo  ("\"> </td>") ; 

        foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
        echo '</tr>';
      }
      ?>
    </table>
		</div>
		</form>
</div> 
</div> 

<footer>
Logic and design: paolo.veronelli@gmail.com
</footer>


</BODY>
</HTML>


