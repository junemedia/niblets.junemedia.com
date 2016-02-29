<?php
/*
$Author: spatel $
$Id: index.php,v 1.6 2006/04/26 15:22:57 spatel Exp $
*/
include("../includes/paths.php");

//echo $sGblAdminSiteRoot;
$sCurrSite = $_SERVER['SERVER_ADDR'];
$sCurrSiteAddr = $_SERVER['SERVER_NAME'];
$sCurrSiteAddr = "https://".$sCurrSiteAddr;


session_start();



$sTrackingUser = $_SERVER['PHP_AUTH_USER'];


$sPageTitle = "Niblets Main Menu";

  // querying nibbles[_stage] db
$sMenuQuery = "SELECT *
                FROM menu
                WHERE parentMenu = 0
                AND   displayMenu = 'Y'
                AND category = ' Newsletters/Solo Templates'
                ORDER BY  category, menuItem";
$rMenuResult = dbQuery($sMenuQuery);

$iNum = 0;
$sMenuList = '';

while ($oMenuRow = dbFetchObject($rMenuResult)) {
  if (!isset($sOldCategory) || ($oMenuRow->category != $sOldCategory || $sOldCategory == '')) {
    if ($iNum%2 != 0) $sMenuList .= "<td bgcolor = \"eeeeee\">&nbsp;</tD>";
    $sMenuList .= "</tr><tr>
      <td colspan=\"2\" align=\"center\" bgcolor = \"c1c1c1\"><b>$oMenuRow->category</b></td>
      </tr><tr>";
    $iNum = 0;
  }

  // interpret $SERVER_NAME variable, if it's there in menuLink
  if (strstr($oMenuRow->menuLink,"\$SERVER_NAME")) {
    $sMenuLink = ereg_replace("\\\$SERVER_NAME",$SERVER_NAME,$oMenuRow->menuLink);
  } else {
    $sMenuLink = $oMenuRow->menuLink;
  }

  $sMenuList .= "<td valign=\"top\" bgcolor = \"eeeeee\" width=\"50%\">
        <ul>";
  if ($oMenuRow->menuItem == 'Newsletters Automation') {
    $sMenuList .= "<li><a href=\"". $sMenuLink."?iMenuId=$oMenuRow->id\"><b>$oMenuRow->menuItem</b></a> &nbsp;";
  } else {
    $sMenuList .= "<li><b style=\"color: #999;\">$oMenuRow->menuItem</b> &nbsp;";
  }

  /* if ($oMenuRow->description != '') { */
  /*     $sMenuList .= "<A href='JavaScript:void(window.open(\"menuDesc.php?iMenuId=$oMenuRow->id\", \"\", \"height=200, width=300, scrollbars=auto, resizable=yes, status=no\"));' class=header>?</a>"; */
  /* } */

  $sMenuList .= "</li></ul></td>";

  $iNum++;
  if ($iNum % 2 == 0) {
    $sMenuList .= "</tr>";
  }

  $sOldCategory = $oMenuRow->category;
}



// In last row, Fill the remaining empty TD with grey color
if ( $iNum%2 != 0) {
  $sMenuList .= "<td bgcolor = \"eeeeee\">&nbsp;</tD>";
}
$sMenuList .= "</tr>";

include("../includes/adminHeader.php");
?>

<!-- content starts here -->

<table align="center" width="600">
  <?php echo $sMenuList;?>
</table>

<!-- content ends here -->

<?php
  include("../includes/adminFooter.php");
