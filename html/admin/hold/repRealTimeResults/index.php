<?php

/*********

Script to Display

**********/


include("../../includes/paths.php");
include("$sGblLibsPath/dateFunctions.php");
include("$sGblLibsPath/stringFunctions.php");
include("$sGblIncludePath/reportInclude.php");


$iScriptStartTime = getMicroTime();

$sPageTitle = "Real Time Post Results Report";

session_start();

mysql_connect ($reportingHost, $reportingUser, $reportingPass);
mysql_select_db ($reportingDbase);


if (hasAccessRight($iMenuId) || isAdmin()) {
	
	// Hidden fields to be passed with form submission
	$sHidden = "<input type=hidden name=iMenuId value='$iMenuId'>
				<input type=hidden name=iId value='$iId'>";	
	
	
	$iCurrYear = date('Y');
	$iCurrMonth = date('m');
	$iCurrDay = date('d');
	
	$iCurrHH = date('H');
	$iCurrMM = date('i');
	$iCurrSS = date('s');
	
	$sRunDateAndTime = "$iCurrMonth-$iCurrDay-$iCurrYear $iCurrHH:$iCurrMM:$iCurrSS";
	
	$sYesterday = DateAdd("d", -1, date('Y')."-".date('m')."-".date('d'));
	
	
$sViewReport = stripslashes($sViewReport);

if (! $sViewReport) {
	$sViewReport = "Today's Report";
}


if ($sViewReport != "Today's Report") {
	
	if (DateDiff("d",mktime(0,0,0,date('m'),date('d'),date('Y')),mktime(0,0,0,$iMonthTo,$iDayTo,$iYearTo)) >= 0 || $iYearTo=='') {
			$iYearTo = substr( $sYesterday, 0, 4);
			$iMonthTo = substr( $sYesterday, 5, 2);
			$iDayTo = substr( $sYesterday, 8, 2);
		}
		
		if (DateDiff("d",mktime(0,0,0,date('m'),date('d'),date('Y')),mktime(0,0,0,$iMonthFrom,$iDayFrom,$iYearFrom)) >= 0 || $iYearFrom=='') {
			$iYearFrom = substr( $sYesterday, 0, 4);
			$iMonthFrom = substr( $sYesterday, 5, 2);
			$iDayFrom = "01";
		}
		
} else  {
	$iYearFrom = date('Y');
	$iMonthFrom = date('m');
	$iDayFrom = date('d');
		
	$iMonthTo = $iMonthFrom;
	$iDayTo = $iDayFrom;
	$iYearTo = $iYearFrom;
	
}

	
	// prepare month options for From and To date
	for ($i = 0; $i < count($aGblMonthsArray); $i++) {
		
		$value = $i+1;
		
		if ($value < 10) {
			$value = "0".$value;
		}
		
		if ($value == $iMonthFrom) {
			$fromSel = "selected";
		} else {
			$fromSel = "";
		}
		if ($value == $iMonthTo) {
			$toSel = "selected";
		} else {
			$toSel = "";
		}
		
		$sMonthFromOptions .= "<option value='$value' $fromSel>$aGblMonthsArray[$i]";
		$sMonthToOptions .= "<option value='$value' $toSel>$aGblMonthsArray[$i]";
	}
	
	// prepare day options for From and To date
	for ($i = 1; $i <= 31; $i++) {
		
		if ($i < 10) {
			$value = "0".$i;
		} else {
			$value = $i;
		}
		
		if ($value == $iDayFrom) {
			$fromSel = "selected";
		} else {
			$fromSel = "";
		}
		if ($value == $iDayTo) {
			$toSel = "selected";
		} else {
			$toSel = "";
		}
		$sDayFromOptions .= "<option value='$value' $fromSel>$i";
		$sDayToOptions .= "<option value='$value' $toSel>$i";
	}
	
	// prepare year options
	for ($i = $iCurrYear; $i >= $iCurrYear-5; $i--) {
		
		if ($i == $iYearFrom) {
			$fromSel = "selected";
		} else {
			$fromSel ="";
		}
		if ($i == $iYearTo) {
			$toSel = "selected";
		} else {
			$toSel ="";
		}
		
		$sYearFromOptions .= "<option value='$i' $fromSel>$i";
		$sYearToOptions .= "<option value='$i' $toSel>$i";
	}
	
	
	// prepare offers list
	
	$sOffersQuery = "SELECT offers.*
				 	 FROM   offers, offerLeadSpec
					 WHERE  offers.offerCode = offerLeadSpec.offerCode
					 AND    deliveryMethodId IN (2,3) 
				 	 ORDER BY offers.offerCode";
	$rOffersResult = dbQuery($sOffersQuery);
	
	while ($oOffersRow = dbFetchObject($rOffersResult)) {		
		$sTempOfferCode = $oOffersRow->offerCode;
			
		if ($sTempOfferCode == $sOfferCode || $sOfferCode == '') {
			$sSelected = "selected";							
			$sOfferCode = $sTempOfferCode;
		} else {
			$sSelected = '';
		}
		
		$sOffersOptions .= "<option value='$sTempOfferCode' $sSelected>$sTempOfferCode";
	}		
	
	
	
	if (checkdate($iMonthFrom, $iDayFrom, $iYearFrom) && checkdate($iMonthTo, $iDayTo, $iYearTo)) {

	if ($sAllowReport == 'N') {
		$sMessage = "Server Load Is High. Please check back soon...";
	} else {
	
		$sDateFrom = "$iYearFrom-$iMonthFrom-$iDayFrom";
		$sDateTo = "$iYearTo-$iMonthTo-$iDayTo";	
	
		$sDateTimeFrom = $sDateFrom." 00:00:00";
		$sDateTimeTo = $sDateTo." 23:59:59";
	
		if ($sViewReport != 'History Report') {
			$sReportQuery = "SELECT offerCode, dateTimeAdded, realTimeResponse
							 FROM   otData
							 WHERE  offerCode = '$sOfferCode'
							 AND    date_format(dateTimeAdded,'%Y-%m-%d') = CURRENT_DATE							 
							 ORDER BY dateTimeAdded DESC";
			
		} else {
			
			$sReportQuery = "SELECT offerCode, dateTimeAdded, realTimeResponse
							 FROM   otDataHistory
							 WHERE  offerCode = '$sOfferCode'
							 AND    dateTimeAdded BETWEEN '$sDateTimeFrom' AND '$sDateTimeTo'							 
							 ORDER BY dateTimeAdded DESC";
			
		}

		// start of track users' activity in nibbles 
		$sTrackingUser = $_SERVER['PHP_AUTH_USER']; 
		mysql_connect ($host, $user, $pass); 
		mysql_select_db ($dbase); 

		$sAddQuery = "INSERT INTO nibbles.trackNibbleUse(userName, pageName, dateTimeLogged, action) 
		  VALUES('$sTrackingUser', '$PHP_SELF', now(), \"View report: $sReportQuery\")"; 
		$rResult = dbQuery($sAddQuery); 
		echo  dbError(); 
		mysql_connect ($reportingHost, $reportingUser, $reportingPass); 
		mysql_select_db ($reportingDbase); 
		// end of track users' activity in nibbles		
		
		
		$rReportResult = dbQuery($sReportQuery);
		echo dbError();
		//echo $sReportQuery. mysql_num_rows($rReportResult);
		while ($oReportRow = dbFetchObject($rReportResult)) {
			$sReportContent .= "<tr><td>$oReportRow->offerCode</td>
									<td nowrap>$oReportRow->dateTimeAdded</td>
									<td>".htmlentities($oReportRow->realTimeResponse)."</td>
								</tr>";			
		}		
	}
	}
			
	
	include("../../includes/adminHeader.php");
	
	$iScriptEndTime = getMicroTime();
	$iScriptExecutionTime = round($iScriptEndTime - $iScriptStartTime);
		
	// display javascript from reportInclude.php which defined funcReportClicked() function
	echo $sReportJavaScript;
?>

<form name=form1 action='<?php echo $PHP_SELF;?>'>
<?php echo $sHidden;?>

<input type=hidden name=reportClicked>
<input type=hidden name=sViewReport>

<table cellpadding=5 cellspacing=0 bgcolor=c9c9c9 width=95% align=center>

<tr><td>Date From</td><td><select name=iMonthFrom><?php echo $sMonthFromOptions;?>
	</select> &nbsp;<select name=iDayFrom><?php echo $sDayFromOptions;?>
	</select> &nbsp;<select name=iYearFrom><?php echo $sYearFromOptions;?>
	</select></td><td>Date To</td>
	<td><select name=iMonthTo><?php echo $sMonthToOptions;?>
	</select> &nbsp;<select name=iDayTo><?php echo $sDayToOptions;?>
	</select> &nbsp;<select name=iYearTo><?php echo $sYearToOptions;?>
	</select></td></tr>		
	<tr><td>Select Offers</td>
		<td colspan=3><select name='sOfferCode'>
		<?php echo $sOffersOptions;?>
		</select></td></tr>
	
<tr><td colspan=2><input type=button name=sSubmit value='History Report' onClick="funcReportClicked('history');">  &nbsp; &nbsp; 
	<input type=button name=sSubmit value="Today's Report"  onClick="funcReportClicked('today');">  &nbsp; &nbsp; 
	</td>
	<td colspan=2><input type=checkbox name=sShowQueries value='Y' <?php echo $sShowQueriesChecked;?>> Show Queries</td>
</tr>
</table>


<table cellpadding=5 cellspacing=0 bgcolor=c9c9c9 width=95% align=center>
<tr><td class=header>Offer Code</td><td class=header>Date Time Added</td><td class=header>Real Time Post Result</td></tr>

<?php echo $sReportContent;?>

<tr><td colspan=3><B>Notes-</b>
			<BR><BR> Approximate time to run this report - <?php echo $iScriptExecutionTime;?> second(s)</td></tr>

</table>

</form>

<?php
include("../../includes/adminFooter.php");
} else {
	echo "You are not authorized to access this page...";
}
?>