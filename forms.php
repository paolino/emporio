<?php		$tks=array();
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

include "forms.html";
?>

