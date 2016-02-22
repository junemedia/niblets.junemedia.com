<?php

/*********
Script to Display List/Delete Type Codes
**********/

include("../../includes/paths.php");
include("$sGblLibsPath/stringFunctions.php");


session_start();

$sPageTitle = "Nibbles Campaign Types - List/Delete Campaign Types";
$sTrackingUser = $_SERVER['PHP_AUTH_USER'];


// Check user permission to access this page

if (hasAccessRight($iMenuId) || isAdmin()) {		
	if ($sDelete) {
		// if record deleted
		
		
		$sCheckCamp = "SELECT * FROM links WHERE campaignTypeId = '$iId'";
		$rCheckCamp = dbQuery($sCheckCamp);
		
		if (dbNumRows($rCheckCamp) == 0) {
			$sDeleteQuery = "DELETE FROM campaignTypes WHERE  id = $iId";
	
			// start of track users' activity in nibbles
			$sLogAddQuery = "INSERT INTO nibbles.trackNibbleUse(userName, pageName, dateTimeLogged, action) 
			  VALUES('$sTrackingUser', '$PHP_SELF', now(), \"Delete: $sDeleteQuery\")";
			$rLogResult = dbQuery($sLogAddQuery);
			// end of track users' activity in nibbles
	
	
			$rResult = dbQuery($sDeleteQuery);
			if (!($rResult)) {
				$sMessage = dbError();
			}
		} else {
			$sMessage = "Can't Delete - campaign type is in use.";
		}
		$iId = '';
	}

	// Select Query to display list of reason codes
	
	$sSelectQuery = "SELECT * FROM campaignTypes";
	
	$rSelectResult = dbQuery($sSelectQuery);
	
	while ($oRow = dbFetchObject($rSelectResult)) {
		
		// For alternate background color
		if ($sBgcolorClass=="ODD") {
			$sBgcolorClass="EVEN";
		} else {
			$sBgcolorClass="ODD";
		}
		$sCampaignTypesList .= "<tr class=$sBgcolorClass><TD>$oRow->campaignType</td>
						<TD>".ascii_encode($oRow->description)."</td>
						<TD><a href='JavaScript:void(window.open(\"addCampaignType.php?iMenuId=$iMenuId&iId=".$oRow->id."\", \"campTypes\", \"height=450, width=600, scrollbars=yes, resizable=yes, status=yes\"));'>Edit</a>
					    &nbsp;<a href='JavaScript:confirmDelete(this,".$oRow->id.");' >Delete</a>
						</td></tr>";
	}
	
	if (dbNumRows($rSelectResult) == 0) {
		$sMessage = "No Records Exist...";
	}
	
	// Hidden fields to pass with form submission
	$sHidden = "<input type=hidden name=iMenuId value='$iMenuId'>
			<input type=hidden name=iId value='$iId'>";

	$sAddButton ="<input type=button name=sAdd value=Add onClick='JavaScript:void(window.open(\"addCampaignType.php?iMenuId=$iMenuId\", \"campTypes\", \"height=450, width=600, scrollbars=yes, resizable=yes, status=yes\"));'>";
		
	include("../../includes/adminHeader.php");	
	
	?>
	
<script language=JavaScript>
	function confirmDelete(form1,id)
	{
		if(confirm('Are you sure to delete this record ?'))
		{							
			document.form1.elements['sDelete'].value='Delete';
			document.form1.elements['iId'].value=id;
			document.form1.submit();								
		}
	}						
</script>

<form name=form1 action='<?php echo $PHP_SELF;?>'>
<?php echo $sHidden;?>
<input type=hidden name=sDelete>
<table cellpadding=5 cellspacing=0 bgcolor=c9c9c9 width=95% align=center>
<tr><td colspan=7 align=left><?php echo $sAddButton;?></td></tr>
<tr><td class=header>Campaign Type</td>
<td class=header>Description</td>
</tr>

<?php echo $sCampaignTypesList;?>
<tr><td colspan=7 align=left><?php echo $sAddButton;?></td></tr>
</table>

</form>
	
<?php
	include("../../includes/adminFooter.php");
} else {
	echo "You are not authorized to access this page...";
}
?>