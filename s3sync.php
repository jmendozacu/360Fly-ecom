<?php 

/*Sync with S3*/
#echo exec('sudo unison default');

var_dump($_SERVER['IS_AU']);echo '<br/>';
var_dump($_SERVER['COUNTRY_NAME']);echo '<br/>';
var_dump($_SERVER['COUNTRY_CODE']);echo '<br/>';

exit;

?>