
<br>
<center><?php echo $sMainMenuLink;?></center>

<?php

reset($aGblSites);

if( isset($_SESSION['reportsRunning']) && $_SESSION['reportsRunning'][$_SERVER['PHP_AUTH_USER']] == "1" ) {
	$_SESSION['reportsRunning'][$_SERVER['PHP_AUTH_USER']] = "0";
}

?>


</body>

</html>
