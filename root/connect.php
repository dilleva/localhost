<?php 
// create db connection
$connection = mysql_connect('localhost','lightbulb','MegaMind'); // MEGAMIND'S DATABASE
//$connection = mysql_connect('localhost','sondauser','Juice'); // Normal database

if(!$connection) {
die("Database connection failed"."".mysql_error());
}
//select database
$db_select = mysql_select_db('midnight',$connection); // MEGAMIND
//$db_select = mysql_select_db('sonda',$connection); // Normal DB
if(!$db_select){die("Database selection failed".mysql_error());}
?>