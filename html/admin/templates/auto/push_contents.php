<?php

include_once("../../../includes/paths.php");
include_once("/var/www/html/admin.popularliving.com/subctr/functions.php");

mysql_select_db('maropost');

require_once("template_class.php");

$html_code = buildPreview($iId);

// get newsletter instance data from `automated`, insert job id into
// html, and create array with db info
$get_data_result = mysql_query("SELECT * FROM automated WHERE id = \"$iId\"");
// this should only run through a single time...
while ($data_row = mysql_fetch_object($get_data_result)) {
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



// jshearer 02/23/2106: log the html that's actually getting sent to
// Campaigner; this should just be temporary during this transition to
// Maropost
echo writeToLog($html_code);

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
