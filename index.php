<?php
  session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<?php include "head.html"?>
<BODY>

<?php
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
<?php include "footer.html" ?>
</BODY>
</HTML>


