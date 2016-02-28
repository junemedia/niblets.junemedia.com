<?php

include_once("/var/www/html/admin.popularliving.com/subctr/functions.php");
include_once("../../../includes/paths.php");

mysql_select_db('maropost');

iconv_set_encoding("input_encoding", "UTF-8");
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");

// upload an image to Campaigner library
// duplicates templates/auto/addImageToLibrary.php
function generateImgUrl($imageurl) {
  if (!strstr($imageurl,'maropost.s3.amazonaws.com')) {

    // expecting to get back an object here
    $response = addImageToLibrary($imageurl);

    // if image_url is in response then it was successful
    if (true || isset($response->{'image_url'})) {
      return $response->{'image_url'};
    }
    else {
      mail('johns@junemedia.com','MOVE upload image error', json_encode($response));
      return json_encode($response);
    }
  }
}

// initialize default value
$CreateUpdateCampaign = false;

// if "Generate" button was pushed, update the
// `newsletter_templates`.`automated_map` table
// with new/updated field values
if (isset($submit) && $submit == 'Generate') {
  $fields_name = explode(',', $fields_name);
  foreach ($fields_name as $field) {
    $val = addslashes($$field);
    //$val = mb_convert_encoding($val, 'ISO-8859-1', 'UTF-8');
    $query = "UPDATE automated_map SET  tag_value = \"$val\" WHERE automated_id = '$iId' AND tag_key=\"[$field]\"";
    $rSelectResult = mysql_query($query);
    echo mysql_error();
  }
  $CreateUpdateCampaign = true;
}

// generate key=>value pairs for all of the newsletters fields as well
// as a string of field names that gets put into hidden form field
$fields = array();
$fields_name = "";
$query = "SELECT * FROM automated_map WHERE automated_id = '$iId'";
$rSelectResult = mysql_query($query);
while ($oRow = mysql_fetch_object($rSelectResult)) {
  // strip square brackets from tag_key
  $tag_key = str_replace(array('[', ']'), '', $oRow->tag_key);
  $fields[$tag_key] = stripslashes($oRow->tag_value);
  $fields_name .= "$tag_key,";
}
// remove trailing comma
if ($fields_name != '') {
  $fields_name = substr($fields_name, 0, strlen($fields_name) - 1);
}

// get newsletter details
$query = "SELECT * FROM automated WHERE id = '$iId'";
$rSelectResult = mysql_query($query);
echo mysql_error();
while ($oRow = mysql_fetch_object($rSelectResult)) {
  $template = $oRow->template;
  $NL_mailDate = $oRow->mailing_date;
}

// generate Sweeps content automatically via api call
if (isset($initSubmit) && $initSubmit == 'Get Sweeps') {
  $rawPrizes = file_get_contents("http://win.betterrecipes.com/api/getPrize/$NL_mailDate");
  $prizes = json_decode($rawPrizes);
  $sweepBaseUrl = 'http://win.betterrecipes.com/';
  if ($template =='r4l_sweeps.php') {
    $sweepBaseUrl = 'http://win.recipe4living.com/';
  }

  foreach($prizes->prizes as $key => $prize) {
    if($key == 0) {
      $fields['FEATURE_IMAGE'] = stripslashes(generateImgUrl($sweepBaseUrl.stripslashes($prize->img1)));
      $fields['FEATURE_LINK'] = stripslashes($sweepBaseUrl.'/prize/'.$prize->date);
      $fields['FEATURE_TEXT'] = stripslashes($prize->desc1);
      $fields['FEATURE_TITLE'] = stripslashes($prize->title);
    } else if ($key <= 4) {
      $fields['PRIZE_'.$key.'_IMAGE'] = stripslashes(generateImgUrl($sweepBaseUrl.stripslashes($prize->img1)));
      $fields['PRIZE_'.$key.'_URL'] = stripslashes($sweepBaseUrl.'prize/'.$prize->date);
      $fields['PRIZE_'.$key.'_TITLE'] = stripslashes($prize->title);
    } else {
      break;
    }
  }
}

?>
<html>
<head>
  <title>Generate Newsletter</title>
  <link rel="stylesheet" href="<?php echo $sGblAdminSiteRoot;?>/styles.css" type="text/css" >
  <style>
    * {
      font-family: verdana;
      font-size:12px;
    }
  </style>
  <script src="http://r4l.popularliving.com/subctr/js/ajax.js"></script>
  <script src="/admin/js/niblets.js"></script>
</head>

<body>
  <table align="center">
    <tr>
      <td><h2><?php echo $subject; ?></h2> </td>
    </tr>
  </table>

  <?php
  /*
   * why load this hidden iframe? because we want to create campaign
   * first and capture campaignId so we can use it again to push updates
   * and replace jobid tag from template with campaignId. this is
   * important so keep this hidden iframe. it will not harm.
   */
  if ($CreateUpdateCampaign == true) { ?>
  <!--iframe src="push_campaign.php?iId=<?php echo $iId; ?>" id="iframe2" frameborder="0" scrolling="No" width="1" height="1"></iframe-->
  <iframe src="push_contents.php?iId=<?php echo $iId; ?>" id="iframe2" frameborder="0"></iframe>
  <?php } ?>

  <table align="center" cellpadding="5" cellspacing="5" style="border:1px solid #383838;background-color: #fff">
    <tr>
      <td valign="top">
        <table cellpadding="5" cellspacing="5" style="border: 1px solid #383838;">
          <form name='form1' action='<?php echo $_SERVER['PHP_SELF'];?>' method="POST">
            <input type="hidden" name="iId" id="iId" value="<?php echo $iId; ?>">
            <input type="hidden" name="subject" id="subject" value="<?php echo $subject; ?>">
            <input type="hidden" name="fields_name" id="fields_name" value="<?php echo $fields_name; ?>">
            <?php foreach ($fields AS $key => $value) { ?>
            <tr>
              <td>
                <?php echo $key; ?>
              </td>
              <td>
                <?php if (strstr($key,'ADS_') || strstr($key,'TEXT')) { ?>
                  <textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" cols="37" rows="5"><?php echo $value; ?></textarea>
                <?php } else { ?>
                  <input type="text" size="50" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>" onblur="addImageToLibrary('<?php echo $key; ?>');">
                <?php } ?>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <td align="right" colspan="2">
                <input type="hidden" name="templateName" value="<?php echo $template; ?>">
                <?php if($template =='br_sweeps.php' || $template =='r4l_sweeps.php'){?>
                <input type="submit" name="initSubmit" id="initSubmit" value="Get Sweeps">&nbsp;&nbsp;&nbsp;&nbsp;
                <?php }?>
                <input type="submit" name="submit" id="submit" value="Generate">
                <br><br><br>
                <a href="push_campaign.php?iId=<?php echo $iId; ?>" onclick="javascript:void window.open('push_campaign.php?iId=<?php echo $iId; ?>','edit_<?php echo $iId; ?>','width=500,height=400,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Push to Campaigner</a>
                <br><p>Make sure to click Generate button before you click Push to Campaigner link...</p>
              </td>
            </tr>
          </form>
          <p>Supported file formats are: JPEG, JPG, GIF, and PNG</p>
        </table>
      </td>
      <td valign="top">
        <a href="arcamax_preview.php?iId=<?php echo $iId; ?>" target="_blank">Arcamax Preview</a><br>
        <iframe src="campaigner_preview.php?iId=<?php echo $iId; ?>" id="iframe1" frameborder="0" scrolling="auto" width="800" height="1500"></iframe>
      </td>
    </tr>
  </table>
</body>
</html>
