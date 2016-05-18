<?php

include_once("../../../includes/paths.php");
include_once("/var/www/html/admin.popularliving.com/subctr/functions.php");

mysql_select_db( $templatesDB );

require_once("template_class.php");

if ($iId == '' || !ctype_digit($iId)) {
  echo 'id missing';
  exit;
}

// find out which template to use
$query = "SELECT * FROM automated WHERE id = '$iId'";
$rSelectResult = mysql_query($query);
echo mysql_error();
// there should only be a single result...
while ($oRow = mysql_fetch_object($rSelectResult)) {
  $template = $oRow->template;
}
$preview  = new Template("templates/$template");

// populate template with values from database
$query = "SELECT * FROM automated_map WHERE automated_id = '$iId'";
$rSelectResult = mysql_query($query);
echo mysql_error();
while ($oRow = mysql_fetch_object($rSelectResult)) {
  // strip square brackets from tag_key
  $tag_key = str_replace(array('[', ']'), '', $oRow->tag_key);
  // if we have a value, stick it in the template
  if ($oRow->tag_value != '') {
    $preview->set($tag_key, $oRow->tag_value);
  }
}
// getting a string of html
$html_code = $preview->output();
// not sure what some of these are in there for exactly, since they're
// just getting stripped out
$html_code = str_replace('REDIR:', '', $html_code);
$html_code = str_replace("{opencount('<img src=\"{opct.url}\" width=\"1\" height=\"1\" border=\"0\" />')}",'',$html_code);
$html_code = str_replace("{datetime(job.issuedate,'','%Y%m%d')}",date('Ymd'),$html_code);
$html_code = str_replace('{to}','[Contact.Email]',$html_code);


// get newsletter instance data from `automated`, insert job id into 
// html, and create array with db info
$get_data_result = mysql_query("SELECT * FROM automated WHERE id = \"$iId\"");
// this should only run through a single time...
while ($data_row = mysql_fetch_object($get_data_result)) {
  // if we already have a Campaigner id use that, otherwise use our
  // `automated` row id
  if ($data_row->campaign_id == 0) {
    $html_code = str_replace('{job.jobid}', $iId, $html_code);
  } else {
    $html_code = str_replace('{job.jobid}', $data_row->campaign_id, $html_code);
  }
  $data_array = array(
    'campaign_id' => $data_row->campaign_id,
    'subject_line' => $data_row->subject,
    'campaign_name' => $data_row->campaign_name,
    'from_name' => $data_row->from_name,
    'from_email_id' => $data_row->from_email_id,
    'reply_email_id' => $data_row->reply_email_id,
    'template_id' => $iId,
    'html_code' => $html_code
  );
}

/*
 * ********************************************************************
 * Send new data to the remote system, ie Campaigner or Maropost
 * ********************************************************************
 */
// pushes data to Campaigner, including the html content; if the
// campaign doesn't already exist there, it will be created
$create_result = CreateUpdateCampaign($data_array);
$CampaignId = trim(getXmlValueByTag($create_result, 'CampaignId'));


// no response, something went wrong
if(trim($create_result) == ""){
    $message = "<p>Empty Server response! Could be the html content encoding error</p>";
    echo $message;
    //echo "<p><textarea width='80%' height=200>";
    //echo print_r($data_array, true);
    //echo "</textarea></p>";
}

// Save campaigner response in db
$responseSql = "INSERT INTO `campaignerResponse` (`id`, `campaignId`, `datetime`, `response`) VALUES
                (NULL, '" . $data_array['campaign_id'] . "', NOW(), '$create_result')";
mysql_query($responseSql);


// update the `automated` entry with campaign id, which may be new if
// this is the first push of this newsletter instance
if ($CampaignId !='' && ctype_digit($CampaignId)) {
  $get_data_result = mysql_query("UPDATE automated SET campaign_id=\"$CampaignId\" WHERE id = \"$iId\"");
}


echo trim(getXmlValueByTag($create_result,'ReturnMessage'))." => CampaignId: ".$CampaignId;
echo "<br><br>";
echo $create_result;

?>
<br><br><br><center><button type="button" onclick="window.open('', '_self', ''); window.close();">Close</button></center>
