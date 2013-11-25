
<?php
        $rq = "SELECT colloquio,utenti.utente,valore,apertura FROM totali join chiusure join utenti on (totali.acquisto = chiusure.acquisto and utenti.utente = totali.utente) order by totali.acquisto desc limit 10";
        $trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
        $tks=array("tessera","spesa","data");

?>

<table class=CSSTableGenerator>   
        <tr>
        <?php
        foreach($tks as $k){
                echo '<th>';
                print_r ($k);
                echo '</th>';
        }
        ?>
        </tr>
        <?php
        
        foreach ($trs as $q) {
                echo '<tr>';
                echo '<td>';
                echo "{$q['colloquio']}/{$q['utente']}";
                echo '</td>';
                foreach (array_slice($q,2) as $s){echo '<td>';print_r($s); echo '</td>';}
                echo '</tr>';
        }
        ?>
</table>

