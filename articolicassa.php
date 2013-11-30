
<?php		$tks=array();
			$rqp = "SELECT nome,prezzo  FROM prodotti left outer join cassa on (prodotto = nome) where prodotto isnull";
			$trsp = $db -> query($rqp) -> fetchAll(PDO::FETCH_ASSOC);
			$tksp=array("prodotto","prezzo");	
			$rqp = "SELECT *  FROM cassa";
			$trsc = $db -> query($rqp) -> fetchAll(PDO::FETCH_ASSOC);
			$tksc=array("prodotto");	
?>
<div id=prodotti_cassa>
<table class=GT>
<tr><td>
		
		
<!-- tabella di report -->
    <div style="height:400px;overflow-y: scroll; ">

    <table class=CSSTableGenerator >   
      <tr>
        <?php
          if($access) {
        echo '<th >Selezione</th>';
        echo '<th>Inizia vendita</th>';
        foreach($tksp as $k){
          echo '<th>';  
          print_r ($k);
          echo '</th>';
        }}
        ?>
      </tr>
      <?php 
      if($access) foreach ($trsp as $k => $q) {
        echo '<tr>';

        echo "<td style=\"width: 50px\" >";
     	echo "<form action={$_SESSION['page']} type=submit method=POST>";
	echo "<input style=\"width: 50px\" class=selezioni onClick=\"this.form.submit()\" type=submit name=articolo value='{$q['nome']}'>" ;
	echo '</form>';
        echo  "</td>" ; 
        echo "<td style=\"width: 50px\" >";
     	echo "<form action={$_SESSION['page']} type=submit method=POST>";
	echo "<input type=hidden name=prodotto value ='{$q['nome']}'>";
	echo "<input class=selezioni onClick=\"this.form.submit()\" type=submit name=in_cassa value=1>" ;
	echo '</form>';
        echo  "</td>" ; 
        foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
        echo '</tr>';
      }
      ?>
    </table>
		</div>

</td><td>
     <form action=<?php echo "{$_SESSION['page']}" ?> type="submit" method="POST">
		
<!-- tabella di report -->
    <div style="height:400px;overflow-y: scroll; ">

    <table class=CSSTableGenerator >   
      <tr>
        <?php
          if($access) {
        echo '<th >Fine vendita</th>';
        foreach($tksc as $k){
          echo '<th>';  
          print_r ($k);
          echo '</th>';
        }}
        ?>
      </tr>
      <?php 
      if($access) foreach ($trsc as $k => $q) {
        echo '<tr>';

        echo "<td style=\"width: 50px\" >";
     	echo "<form action={$_SESSION['page']} type=submit method=POST>";
	echo "<input type=hidden name=prodotto value ='{$q['prodotto']}'>";
	echo "<input class=selezioni onClick=\"this.form.submit()\" type=submit name=out_cassa value=1>" ;
	echo '</form>';
        echo  "</td>" ; 
        foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
        echo '</tr>';
      }
      ?>
    </table>
		</div>
		</form>

</td></tr></table>
</div>
