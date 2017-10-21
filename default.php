<?php		$tks=array();
		 if($_SESSION['tabella'] != ""){
			$rcs = $db -> query("pragma table_info ({$_SESSION['tabella']})")-> fetchAll(PDO::FETCH_ASSOC);
			 foreach($rcs as $r) array_push($tks,$r['name']);
			 if (!in_array($_SESSION['colonna'],$tks)) $rq = "SELECT * FROM '{$_SESSION['tabella']}' ";
				else $rq = "SELECT * FROM '{$_SESSION['tabella']}' order by {$_SESSION['colonna']} asc";
			$trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
			}
			else {
			$trs= array();
			}
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
			$residuo=$trs[$_SESSION['record']]['residuo'];
			$camporesiduo= " residuo</td><td class=utente><input class=text type=text name=\"residuo\" value=\"{$residuo}\" size=7 >";
			}
		else $camporesiduo= " residuo</td><td class=utente><input class=text type=text name=\"residuo\"  size=7 >";
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
			$valutazione=$trs[$_SESSION['record']]['valutazione'];
			$campovalutazione= " valutazione</td><td class=utente><input id=date class=text type=text name=\"valutazione\" value=\"{$valutazione}\" size=7 >";
			}
		else $campovalutazione= " valutazione</td><td class=utente><input id=date class=text type=text name=\"valutazione\"  size=7 >";
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
			$pin=$trs[$_SESSION['record']]['pin'];
			$campopin= " PIN</td><td class=utente><input class=text type=text name=\"pin\" value=\"{$pin}\" size=7 >";
			}
		else $campopin= " pin</td><td class=utente><input class=text type=text name=\"pin\"  size=7 >";
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
			$punti=$trs[$_SESSION['record']]['punti'];
			$campopunti= " punti</td><td class=utente><input class=text type=text name=\"punti\" value=\"{$punti}\" size=7 >";
			}
		else $campopunti= " punti</td><td class=utente><input class=text type=text name=\"punti\"  size=7 >";
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
			$nominativo=$trs[$_SESSION['record']]['nominativo'];
			$camponominativo= " nominativo</td><td class=utente><input class=text type=text name=\"nominativo\" value=\"{$nominativo}\" size=25 >";
			}
		else $camponominativo= " nominativo</td><td class=utente><input class=text type=text name=\"nominativo\"  size=25 >";
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
			$colloquio=$trs[$_SESSION['record']]['colloquio'];
			$campocolloquio= " colloquio</td><td class=utente><input class=text type=text name=\"colloquio\" value=\"{$colloquio}\" size=5 >";
			}
		else $campocolloquio= " colloquio</td><td class=utente><input class=text type=text name=\"colloquio\"  size=5 >";
		if($_SESSION['record'] != "" && $_SESSION['tabella'] != "" && $trs[$_SESSION['record']]['utente'] != null ){
			$utente=$trs[$_SESSION['record']]['utente'];
			$_SESSION['lastutente']=$utente;
			$campoutente= " utente</td><td class=utente><input class=text type=text name=\"utente\" value=\"{$utente}\" size=5 >";
			}
		elseif  ($_SESSION['lastutente'] != "") 
			$campoutente= " utente</td><td class=utente><input class=text type=text name=\"utente\" value=\"{$_SESSION['lastutente']}\" size=5 >";
		else $campoutente= " utente</td><td class=utente><input class=text type=text name=\"utente\"  size=5 >";
		
?>
