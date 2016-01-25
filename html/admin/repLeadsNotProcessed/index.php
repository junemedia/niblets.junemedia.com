<?php

/*********

Script to Display 

**********/


include("../../includes/paths.php");
include("$sGblLibsPath/dateFunctions.php");
include("$sGblIncludePath/reportInclude.php");

$iScriptStartTime = getMicroTime();

$sPageTitle = "Leads Collected But Not Processed Report";

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

$sStartDate = DateAdd("d", -30, date('Y')."-".date('m')."-".date('d'));

$sYesterday = DateAdd("d", -1, date('Y')."-".date('m')."-".date('d'));

if (!($sViewReport)) {
	$iYearFrom = substr( $sStartDate, 0, 4);
	$iMonthFrom = substr( $sStartDate, 5, 2);
	$iDayFrom = substr( $sStartDate, 8, 2);
	
	
	$iYearTo = substr( $sYesterday, 0, 4);
	$iMonthTo = substr( $sYesterday, 5, 2);
	$iDayTo =  substr( $sYesterday, 8, 2);
} else if ($sHistoryReport) {
	
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
		
	
if (checkdate($iMonthFrom, $iDayFrom, $iYearFrom) && checkdate($iMonthTo, $iDayTo, $iYearTo)) {
		if ($sAllowReport == 'N') {
			$sMessage = "Server Load Is High. Please check back soon...";
		} else {
	
	$sDateFrom = "$iYearFrom-$iMonthFrom-$iDayFrom";
	$sDateTo = "$iYearTo-$iMonthTo-$iDayTo";
	$sDateTimeFrom = "$iYearFrom-$iMonthFrom-$iDayFrom"." 00:00:00";
	$sDateTimeTo = "$iYearTo-$iMonthTo-$iDayTo"." 23:59:59";
	
	$sUndeliveredLeadsQuery = "SELECT offers.offerCode, name, count(otDataHistory.id) undeliveredLeads, sum(otDataHistory.revPerLead) as undeliveredRev
								FROM   offers, otDataHistory
								WHERE otDataHistory.offerCode = offers.offerCode
								AND    (processStatus IS NULL || processStatus = '')
								AND    otDataHistory.dateTimeAdded BETWEEN '$sDateTimeFrom' AND '$sDateTimeTo'
								GROUP BY offers.offerCode
								ORDER BY offers.offerCode";

	// start of track users' activity in nibbles 
	$sTrackingUser = $_SERVER['PHP_AUTH_USER']; 
	mysql_connect ($host, $user, $pass); 
	mysql_select_db ($dbase); 

	$sAddQuery = "INSERT INTO nibbles.trackNibbleUse(userName, pageName, dateTimeLogged, action) 
	  VALUES('$sTrackingUser', '$PHP_SELF', now(), \"View report: $sUndeliveredLeadsQuery\")"; 
	$rResult = dbQuery($sAddQuery); 
	echo  dbError(); 
	mysql_connect ($reportingHost, $reportingUser, $reportingPass); 
	mysql_select_db ($reportingDbase); 
	// end of track users' activity in nibbles		
	
	$rUndeliveredLeadsResult = dbQuery($sUndeliveredLeadsQuery);
	
	
	echo dbError();
	
	if ($rUndeliveredLeadsResult) {
		while ($oUndeliveredLeadsRow = dbFetchObject($rUndeliveredLeadsResult)) {
			if ($bgcolorClass == "ODD") {
				$bgcolorClass = "EVEN_WHITE";
			} else {
				$bgcolorClass = "ODD";
			}
		
			$sReportContent .= "<tr class=$bgcolorClass><td>$oUndeliveredLeadsRow->offerCode</td>
								<td>$oUndeliveredLeadsRow->name</td>
								<td align=right>$oUndeliveredLeadsRow->undeliveredLeads</td>
								<td align=right>$oUndeliveredLeadsRow->undeliveredRev</td></tr>";
			
			$sExpReportContent .= "$oUndeliveredLeadsRow->offerCode\t$oUndeliveredLeadsRow->name\t";
			$sExpReportContent .= "$oUndeliveredLeadsRow->undeliveredLeads\t$oUndeliveredLeadsRow->undeliveredRev\n";
			
			$iTotalUndeliveredLeads += $oUndeliveredLeadsRow->undeliveredLeads;
			$fTotalUndeliveredLeadsRev += $oUndeliveredLeadsRow->undeliveredRev;
			
		}
		dbFreeResult($rUndeliveredLeadsResult);
	}
								 
	$fTotalUndeliveredLeadsRev = sprintf("%10.2f", round($fTotalUndeliveredLeadsRev,2));
	
	
	if ($sExportExcel) {
		
		$sExpReportContent = "Offer Code\tOffer Name\tUndelivered Leads\tRevenue"."\n".$sExpReportContent;
		$sExpReportContent .= "\nTotal\t\t$iTotalUndeliveredLeads\t$fTotalUndeliveredLeadsRev";
		$sExpReportContent .= "\n\nReport From $iMonthFrom-$iDayFrom-$iYearFrom To $iMonthTo-$iDayTo-$iYearTo";
		$sExpReportContent .= "\nRun Date/Time $sRunDateAndTime";
		$sExpReportContent .= "\n\nNotes:\nToday's Report excludes leads having address '3401 DUNDEE...'.\nTest leads are deleted after midnight and not included in history report.\nPostal Verification status not considered in this report.\nOnly leads collected as of midnight last night included.\n";

		$sFileName = "leadsNotProcessed_".$iCurrMonth.$iCurrDay."_".$iCurrHH.$iCurrMM.$iCurrSS.".xls";

		$rFpFile = fopen("$sGblWebRoot/temp/$sFileName", "w");
		if ($rFpFile) {
			fputs($rFpFile, $sExpReportContent, strlen($sExpReportContent));
			fclose($rFpFile);

			echo "<script language=JavaScript>
				void(window.open(\"$sGblSiteRoot/download.php?sFile=$sFileName\",\"\",\"height=150, width=300, scrollbars=yes, resizable=yes, status=yes\"));
			  </script>";
		} else {
			$sMessage = "Error exporting data...";
		}
	}
	
	
	if ($sExportExcel) {
		$sExportExcelChecked = "checked";
	}
	
	
	$iScriptEndTime = getMicroTime();
	$iScriptExecutionTime = round($iScriptEndTime - $iScriptStartTime);
		
	
	$sReportContent = "<table cellpadding=0 cellspacing=0 bgcolor=c9c9c9 width=80% align=center border=1 bordercolor=#000000>
		<tr><td>
		<table cellpadding=5 cellspacing=0 bgcolor=#FFFFFF width=100% align=center>
	<tr><td>
	<table cellpadding=5 cellspacing=0 bgcolor=#FFFFFF width=80% align=center>
	<tr><td colspan=5 class=bigHeader align=center><BR>$sPageTitle<BR>From $iMonthFrom-$iDayFrom-$iYearFrom to $iMonthTo-$iDayTo-$iYearTo<BR><BR><BR></td></tr>
	<tr><td colspan=4 class=header>Run Date / Time: $sRunDateAndTime</td></tr>
	<tr><td width=120 class=header>Offer Code</td><td width=250 class=header>Offer Name</td><td class=header align=right width=100>Undelivered Leads</td><td class=header align=right>Revenue</td></tr>
	
	$sReportContent
	<tr><td colspan=4 align=left><hr color=#000000></td></tr>
	<tr><td class=header colspan=2>Total</td><td class=header align=right>$iTotalUndeliveredLeads</td><td class=header align=right>$fTotalUndeliveredLeadsRev</td></tr>
	<tr><td colspan=4 class=header><BR>Notes -</td></tr>
	<tr><td colspan=4>- Today's Report excludes leads having address '3401 DUNDEE...'.
		<BR>Test leads are deleted after midnight and not included in history report.
	<BR>- Postal Verification status not considered in this report.
	<BR>- Only leads collected as of midnight last night included.
	<BR>- Approximate time to run this report - $iScriptExecutionTime second(s).</td></tr>
	<tr><td colspan=4><BR><BR></td></tr>
		</td></tr></table></td></tr></table></td></tr>
	</table>";
}
}
		
	
	include("../../includes/adminHeader.php");	

// display javascript from reportInclude.php which defined funcReportClicked() function
	echo $sReportJavaScript;	
?>

<form name=form1 action='<?php echo $PHP_SELF;?>'>
<?php echo $sHidden;?>

<input type=hidden name=reportClicked>
<input type=hidden name=sViewReport>

<table cellpadding=5 cellspacing=0 bgcolor=c9c9c9 width=95% align=center>
<tr><td colspan=2>Filter report based upon date leads collected.</td></tr>
<tr><td>Date From</td><td><select name=iMonthFrom><?php echo $sMonthFromOptions;?>
	</select> &nbsp;<select name=iDayFrom><?php echo $sDayFromOptions;?>
	</select> &nbsp;<select name=iYearFrom><?php echo $sYearFromOptions;?>
	</select></td><td>Date To</td>
	<td><select name=iMonthTo><?php echo $sMonthToOptions;?>
	</select> &nbsp;<select name=iDayTo><?php echo $sDayToOptions;?>
	</select> &nbsp;<select name=iYearTo><?php echo $sYearToOptions;?>
	</select></td></tr>		
	<tr><td colspan=2><input type=button name=sSubmit value='View Report' onClick="funcReportClicked('report');">	
	&nbsp; &nbsp; <input type=checkbox name=sExportExcel value="Y" <?php echo $sExportExcelChecked;?>> Export To Excel
	<!--<input type=submit name=sPrintReport value='Print This Report'>--></td></tr>
</table>

<table cellpadding=5 cellspacing=0 bgcolor=c9c9c9 width=95% align=center>
	<tr><td>
	
			<?php echo $sReportContent;?>
			
</td></tr>
</table>
</form>

<?php

	include("../../includes/adminFooter.php");
} else {
	echo "You are not authorized to access this page...";
}
?>