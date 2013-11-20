<?php		
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
