
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
<BODY>

<?php
session_start();
include "access.php";
?>
 <header>
	<div id=nav >
		<form name="input" action="index.php" method="post">
		<ul><li class=header>
			<a href=cassa.php> Cassa </a>
			</li><li class=header>
			<a href=amministrazione.php> Amministrazione</a>
			</li><li>
	<?php if (! $access): ?> 
			<input class=text type=password name="login" size=25></li><li>
			<input type="submit" value="Login">
	<?php else: ?>
	
		        <input type=hidden name="logout" value=1></li><li>
			<input type="submit" value="Logout">
	<?php endif; ?>
		</li></ul>
		</form>   
	</div>
</header>

 
    <div class=content>
<img src="solidarieta.gif"></img>
</div>
<footer>
Logic and design: paolo.veronelli@gmail.com
</footer>

</BODY>
</HTML>


