
<?php		
$tks=array();
$rqp = "SELECT nome,prezzo  FROM prodotti";
$trsq = $db -> query($rqp) -> fetchAll(PDO::FETCH_ASSOC);
$tksq=array("prodotto","prezzo");	
$rqp = "SELECT nome  FROM prodotti left outer join cassa on (prodotto = nome) where prodotto isnull";
$trsp = $db -> query($rqp) -> fetchAll(PDO::FETCH_ASSOC);
$tksp=array("prodotto");	
$rqp = "SELECT *  FROM cassa";
$trsc = $db -> query($rqp) -> fetchAll(PDO::FETCH_ASSOC);
$tksc=array("prodotto");	
?>
<!-- tabella di report -->
<td>
	<table class=CSSTableGenerator >   
		<tr>
			<?php
			if($access) {
			echo '<th >Selezione</th>';
			foreach($tksq as $k){
			echo '<th>';  
				print_r ($k);
				echo '</th>';
			}}
			?>
		</tr>    

		<?php 
		if($access) foreach ($trsq as $k => $q) {
		echo '<tr>';

			echo "<td style=\"width: 50px\" >";
				echo "<form action={$_SESSION['page']} type=submit method=POST>";
					echo "<input class=selezioni onClick=\"this.form.submit()\" type=submit name=articolo value='{$q['nome']}'>" ;
					echo '</form>';
				echo  "</td>" ; 

			foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
			echo '</tr>';
		}
		?>
	</table>

</td><td>
	<table class=movearticoli>
		<th colspan=2>Articoli esposti</th>
		<tr><td>

				<table class=CSSTableGenerator >   
					<tr>
						<?php
						if($access) {
						echo '<th>Inizio vendita</th>';
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
								echo "<input type=hidden name=prodotto value ='{$q['nome']}'>";
								echo "<input class=selezioni onClick=\"this.form.submit()\" type=submit name=sql value=in_cassa>" ;
								echo '</form>';
							echo  "</td>" ; 
						foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
						echo '</tr>';
					}
					?>
				</table>

			</td><td>


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
								echo "<input class=selezioni onClick=\"this.form.submit()\" type=submit name=sql value=out_cassa>" ;
								echo '</form>';
							echo  "</td>" ; 
						foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
						echo '</tr>';
					}
					?>
				</table>

			</td>
		</tr>
	</table>
