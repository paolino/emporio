<?php
        $rq = "SELECT prezzo,prodotto,numero FROM scontrino where acquisto={$_SESSION['acquisto']} order by prezzo";
        $trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
        $tks=array("prezzo","prodotto","confezioni");
?>

<table class=CSSTableGenerator>   
        <tr>
        <?php
        echo '<th style="width: 50px">storno</th>';
        foreach($tks as $k){
                echo '<th>';
                print_r ($k);
                echo '</th>';
        }
        ?>
        </tr>
        <?php
        foreach ($trs as $k => $q) {
                echo '<tr>';
                echo '<form action="cassa.php" method=POST>';  
                echo "<td style=\"width:1em\" > 
                        <input type=\"hidden\" name=\"sql\" value=\"cancella_spesa\">
			<input type=\"hidden\" name=\"prodotto\" value=\"{$q['prodotto']}\">

                        <input class=selezioni onClick=\"this.form.submit()\" type=submit name=prezzo value=\"" ;
                print_r ($q['prezzo']); 
                echo  ("\"></form> </td>") ; 

                foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
                echo '</tr>';
        }
        ?>
</table>

