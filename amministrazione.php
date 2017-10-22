<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<TITLE>Emporio, amministrazione</TITLE>
<?php include "head.html" ?>
</head>
<BODY >

<script>
$(function() {
		$( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
		});
</script>



<?php
$_SESSION['page'] = "amministrazione.php";

include "access.php";

if($_SESSION['transaction'] == "") $_SESSION['transaction'] = array();
if ($access) {
	include "transact.php";
	foreach($_POST as $k => $v) $_SESSION[$k]=$v;
}	
?>   
<?php include "header.html"?> 


<div class=content>

	<table class=GT> 
		<tr>
			<?php 
			if($_SESSION['tabella'] == "") $_SESSION['tabella'] = 'nuovoutente';
			if ($access) include 'forms.php';
			?>
		</tr>
	</table>
	<?php if ($access) include 'report.php';
	?>

</div> 
<?php include "footer.html" ?>

</BODY>
</HTML>


