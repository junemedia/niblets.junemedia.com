<?php


if ($_SERVER['PHP_AUTH_USER'] !='spatel') {
	//echo 'Script discontinued....';
	//exit;
}


include("../../includes/paths.php");
session_start();

$rSelectResultTest = dbQuery("SELECT * FROM nibbles_temp.be_resend_leads");
$iNumLeadsPostedTest = dbNumRows($rSelectResultTest);

for ($x = 0; $x < $iNumLeadsPostedTest; $x++) {
	$rSelectResult = dbQuery("SELECT * FROM nibbles_temp.be_resend_leads LIMIT 25");
	echo dbError();
	while ($oSelectRow= dbFetchObject($rSelectResult)) {
		$sHttpPostString = $oSelectRow->querystring;
		$sRealTimeResponse = '';
		$sPostingUrl = $oSelectRow->url;
		$aUrlArray = explode("//", $sPostingUrl);
		$sUrlPart = $aUrlArray[1];
		
		// separate host part and script path
		$sHostPart = substr($sUrlPart,0,strlen($sUrlPart)-strrpos(strrev($sUrlPart),"/"));
		$sHostPart = ereg_replace("\/","",$sHostPart);
		$sScriptPath = substr($sUrlPart,strlen($sHostPart));
		
		if (strstr($sPostingUrl, "https:")) {
			$rSocketConnection = fsockopen("ssl://".$sHostPart, 443, $errno, $errstr, 30);
		} else {
			$rSocketConnection = fsockopen($sHostPart, 80, $errno, $errstr, 30);
		}
		
		if ($rSocketConnection) {
			if ($type == 'POST' || $type == '') {
				fputs($rSocketConnection, "POST $sScriptPath HTTP/1.1\r\n");
				fputs($rSocketConnection, "Host: $sHostPart\r\n");
				fputs($rSocketConnection, "Content-type: application/x-www-form-urlencoded \r\n");
				fputs($rSocketConnection, "Content-length: " . strlen($sHttpPostString) . "\r\n");
				fputs($rSocketConnection, "User-Agent: MSIE\r\n");
				fputs($rSocketConnection, "Connection: close\r\n\r\n");
				fputs($rSocketConnection, $sHttpPostString);
			} else {
				$sScriptPath .= "?".$sHttpPostString;
				fputs($rSocketConnection, "GET $sScriptPath HTTP/1.1\r\n");
				fputs($rSocketConnection, "Host: $sHostPart\r\n");
				fputs($rSocketConnection, "Accept-Language: en\r\n");
				fputs($rSocketConnection, "User-Agent: MSIE\r\n");
				fputs($rSocketConnection, "Connection: close\r\n\r\n");
			}
			
			while(!feof($rSocketConnection)) {
				$sRealTimeResponse .= fgets($rSocketConnection, 1024);
			}
			fclose($rSocketConnection);
			$delete_result = dbQuery("DELETE FROM nibbles_temp.be_resend_leads WHERE id = '$oSelectRow->id'");
			echo dbError();
		} else {
			echo "$errstr ($errno)<br />\r\n";
		}
		
		echo $sPostingUrl.'?'.$sHttpPostString."<br>".$sRealTimeResponse."<br><br>";
		flush();ob_flush();
	}
	
	// close the connection and reconnect
	mysql_close();
	mysql_pconnect ("mydb01.amperemedia.com", "nibbles", "#a!!yu5");
	mysql_select_db ("nibbles_temp");
	echo "<br><br><br><br><br>";
	
	
	$CountResult = dbQuery("SELECT * FROM nibbles_temp.be_resend_leads LIMIT 10");
	if (dbNumRows($CountResult) == 0) {
		break;
	}
}

echo "<br><br><br>Used ".$type." method<br><br><br><br>";

echo "<br><br><br><br>DONE<br><br><br><br>";


?>
