<?php
//get the page title,mainmenulink, parentmenuLink from database
// get doc link
// get back button
//get login link

/*** 
include this file in a script 
* after creating the session,
* after any header function (BEcause this script starts html to display, if header function after this, will give error)
* before using $sMenuFolder variable in the script, because $sMenuFolder is set here.
***/
//if (session_is_registered("sSesUserId")) {
	//$sLoginLink = "$sSesLoginId | <a href='$sGblAdminSiteRoot/logout.php'>Logout</a>";
		
	// if not in OT Main Menu, display link to return to OT Main Menu
  $sMainMenuLink = '';
  $sBackButton = '';
	if(!(strstr($_SERVER['PHP_SELF'], "admin/index.php")))	
	{
		$sMainMenuLink = "<a href='$sGblAdminSiteRoot/index.php?".SID."' class=menulink>Return to Nibbles Main Menu</a><BR><BR>";
		$sBackButton = "<a href=JavaScript:history.go(-1);>Back</a>";
	}
			
	// documentation link	
	// Get the folder of this menu
	
  // jshearer 02/19/2016: quash undefined variable notices
	$sMenuFolder = @$sFolderaSesMenuFolder[$iMenuId];
	$sDocLink="<a href='JavaScript:void(window.open(\"$sGblAdminSiteRoot/documentation.php?iMenuId=".@$iMenuId."&sMenuFolder=$sMenuFolder\",\"Documentation\",\"width=600, height=450, scrollbars=yes, resizable=yes\"));'>Documentation</a>";
		
	
		
	
/*} else if (!(strstr($PHP_SELF,"login.php"))){
	$sLoginLink = "<a href='$sGblAdminSiteRoot/login.php'>Login</a>";	
}*/

$sLogoutLink = "Logged In : ".$_SERVER['PHP_AUTH_USER'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='$sGblAdminSiteRoot/phpinfo.php' target='_blank'>PHP Info</a>";

// jshearer 02/20/2016: quash undefined variable notices
$sParentMenuLink = '';
if (@$iParentMenuId) {
	// Get the folder of parent menu
	//$sParentMenuFolder = $sSesMenuFolder[$iParentMenuId];	
	$sParentMenuLink = "<a href=\"$sGblAdminSiteRoot/$sParentMenuFolder/index.php?iMenuId=$iParentMenuId&".SID."\" class=menulink>Return to Parent Menu</a><BR><BR>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>

<head>
<title><?php echo @$sPageTitle;?></title>
<LINK rel="stylesheet" href="<?php echo $sGblAdminSiteRoot;?>/styles.css" type="text/css" >
</head>

<body>


<center>
<table width="85%">

<tr>

<td align ="center">

<img src="<?php echo $sGblAdminSiteRoot;?>/niblets-header.png" style="width:120px">

</td>

</tr>

</table>

</center>
<br>
<center><?php echo $sMainMenuLink;?></center>
<center><?php echo $sParentMenuLink;?></center>
<table align=center width=85%><tr><td align=center class=header><?php echo @$sPageTitle;?></td></tr></table>
<table width=85% align=center>
  <tr>
    <td align=left><?php echo $sBackButton;?></td>
    <td align=right>
      <?php echo $sLogoutLink;?>
    </td></tr>
<tr><td class=message align=center colspan=2><?php echo @$sMessage;?></td></tr>
</table>

