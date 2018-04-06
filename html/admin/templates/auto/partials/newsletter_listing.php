<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Niblets - Fresh Corn Off the Cob</title>
  <link rel="stylesheet" href="<?php echo $sGblAdminSiteRoot;?>/styles.css" type="text/css" >
</head>

<body style="width:75%;">

  <table style="width: 100%;">
    <tr>
      <td align ="center">
        <img src="<?php echo $sGblAdminSiteRoot;?>/niblets-header.png" style="width:120px">
      </td>
    </tr>
  </table>

  <br>

  <table style="width: 100%;">
    <tr>
      <td align="right">Logged In :<?php echo $_SERVER['PHP_AUTH_USER']; ?></td>
    </tr>

    <tr>
      <td class="message" align="center"><?php echo @$sMessage;?></td>
    </tr>
  </table>

  <form name="form1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <?php echo @$sHidden;?>
    <table class="listing">
      <tr>
        <td>Template: <select name="template" id="template"><?php echo $template_options; ?></select></td>
        <td><input type="submit" name="submit" id="submit" value="Search..."></td>
      </tr>
    </table>
  </form>

  <table class="listing">
    <tr>
      <td colspan="5" align="right">
        <a href="addEdit.php" onclick="javascript:void window.open('addEdit.php','add','width=700,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=50,top=50');return false;">Create New Newsletter</a>
      </td>
    </tr>

    <tr class="header">
      <td colspan="5" align="center">Automated Newsletters Management</td>
    </tr>

    <tr class="header">
      <td>ID</td>
      <td>Subject</td>
      <td>Template</td>
      <td>Mailing Date</td>
      <td>Edit</td>
    </tr>

    <?php while ($oRow = dbFetchObject($rSelectResult)) { ?>
    <tr class="item">
      <td style="font-weight: bold";><?php echo $oRow->id; ?></td>
      <td>
        <a href="create.php?iId=<?php echo $oRow->id; ?>&subject=<?php echo urlencode($oRow->subject); ?>" target=_blank><?php echo $oRow->subject; ?></a>
      </td>
      <td><?php echo $oRow->template; ?></td>
      <td><?php echo $oRow->mailing_date; ?></td>
      <td>
        <a href="addEdit.php?iId=<?php echo $oRow->id; ?>"
          onclick="javascript:void window.open('addEdit.php?iId=<?php echo $oRow->id; ?>',
                                                'edit_<?php echo $oRow->id; ?>',
                                                'width=700,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
                                return false;">Edit</a></td>
    </tr>
    <?php } ?>
  </table>

  <div style="margin: 5px">
    <strong>Note:</strong>  This page will ONLY display last 50 issues.  If you need access to older issues, please contact Samir (and good luck with that).
  </div>

</body>
</html>
