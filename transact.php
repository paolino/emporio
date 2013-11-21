<?php
if ($_POST['reset'] != ""){
	$_SESSION['transaction'] = array();
	unset($_SESSION['sql']);
	unset($_POST['reset']);
}
if ($_POST['back'] != ""){
	array_pop($_SESSION['transaction']);
	unset($_POST['back']);
}

include 'switch.php';

unset($_POST['sql']);


$db -> beginTransaction();

foreach($_SESSION['transaction'] as $sql){
	try {$db->query($sql);} catch(PDOException $e) 
	{
		array_pop($_SESSION['transaction']);
		echo "<script> alert(\"{$e->getMessage()}\") </script>";
	}
}
if($_POST['commit'] != "") {
	try {$db -> commit();} catch(PDOException $e) {echo $e->getMessage();}    
	$_SESSION['transaction'] = array();
	unset($_POST['commit']);
} 

?>
