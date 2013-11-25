
<?php
        $rq = "SELECT utente,valore,apertura FROM totali join chiusure using(acquisto) order by acquisto desc limit 10";
        $trs = $db -> query($rq) -> fetchAll(PDO::FETCH_ASSOC);
        $tks=array("utente","spesa","data");
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
        foreach ($trs as $k => $q) {
                echo '<tr>';
                foreach ($q as $s){echo '<td>';print_r($s); echo '</td>';}
                echo '</tr>';
        }
        ?>
</table>

