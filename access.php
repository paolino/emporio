<?php
  if($_POST['login'] != "")
	$_SESSION['login']=$_POST['login'];
  if($_SESSION['login']!=""){

$access=false;
try {
	$db = new PDO('sqlite:emporio4');  
	$db-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$db-> query("PRAGMA foreign_keys=on;");

	$q = "select * from amministrazione where login='{$_SESSION['login']}'";
	$acs = $db -> query($q) -> fetchAll(PDO::FETCH_ASSOC);
	foreach($acs as $ac)$access=true;
	} 
	catch(PDOException $e) 
		{echo "<script> alert(\"{$e->getMessage()}\") </script>";}
  	  
      }
 if($_GET['logout'] != ""){
   $_SESSION['transaction'] = array();
   foreach($_SESSION as $k => $v) unset ($_SESSION[$k]);
   unset($_SESSION['sql']);
   }

?>

