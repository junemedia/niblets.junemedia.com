<?php

include_once("../../../includes/paths.php");
include_once("$sGblSubctrPath/functions.php");

mysql_select_db( $templatesDB );

iconv_set_encoding("input_encoding", "UTF-8");
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");

// if "Generate" button was pushed, update the
// `newsletter_templates`.`automated_map` table
// with new/updated field values
if (isset($submit) && $submit == 'Generate') {
  $fields_name = explode(',', $fields_name);
  foreach ($fields_name as $field) {
    $val = addslashes($$field);

    $query = "UPDATE automated_map
              SET tag_value = \"$val\"
              WHERE automated_id = '$iId'
              AND tag_key=\"$field\"";
    $rSelectResult = mysql_query($query);
    echo mysql_error();
  }
}

// generate key=>value pairs for all of the newsletters fields as well
// as a string of field names that gets put into hidden form field
$fields = array();
$fields_name = "";
$query = "SELECT * FROM automated_map WHERE automated_id = '$iId'";
$rSelectResult = mysql_query($query);
while ($oRow = mysql_fetch_object($rSelectResult)) {
  $tag_key = $oRow->tag_key;
  $fields[$tag_key] = stripslashes($oRow->tag_value);
}
$fields_name = implode(',', array_keys($fields));

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
  if ($template =='r4l_sweeps.php' || $template == 'r4l_sweeps_marquee.php') {
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

include_once("partials/edit.html");
