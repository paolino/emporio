<div id=report>
     <form action=<?php echo "{$_SESSION['page']}" ?> type="submit" method="POST">

				<select onChange=this.form.submit() name="tabella">  
					<?php   
					if ($access) {
					try {
						$result = $db->query("SELECT * FROM sqlite_master WHERE type='table' or type = 'view'");
						$r = $result->fetchAll(PDO::FETCH_ASSOC);
						foreach($r as $s) if($s['name'] == $_SESSION['tabella']) {
						 echo "<option value='{$s['name']}' selected >{$s['name']}</option>";
					 } else {
						 echo "<option value='{$s['name']}'>{$s['name']}</option>";
							 }
						 }
						 catch(PDOException $e) {
							echo $e->POSTMessage();
						}
					}
					?>
				</select>

		
		
<!-- tabella di report -->
    <div style="height:400px;overflow-y: scroll; ">

    <table class=CSSTableGenerator >   
      <tr>
        <?php
          if($access) {
        echo '<th style="width: 50px">selezione</th>';
        foreach($tks as $k){
          echo '<th>';  
	  echo '<div style="width:100%">';
          echo "<button class=orderer type=submit onclick=\"this.form.submit()\" name=colonna value=\"";
          print_r ($k);
          echo "\"> ";

          print_r ($k);
          echo '</div></th>';
        }}
        ?>
      </tr>
      <?php 
      if($access) foreach ($trs as $k => $q) {
        echo '<tr>';

        echo "<td style=\"width: 50px\" > 
                <button class=selezioni onClick=\"this.form.submit()\" type=submit name=record value=\"" ;
        print_r ($k); 
        echo  ("\"> Selezione</td>") ; 
        foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
        echo '</tr>';
      }
      ?>
    </table>
		</div>
		</form>
</div>
