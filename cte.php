<?php
function cte($template_file, $array){
$sito = file_get_contents($template_file);
while (list($key, $val) = each($array)) $sito = str_replace('', $val, $sito);
$sito = preg_replace('{\{-(.*?)\-\}}','', $sito);
return $sito;
}
?>
