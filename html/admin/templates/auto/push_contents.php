<?php

include_once("../../../includes/paths.php");
include_once("/var/www/html/admin.popularliving.com/subctr/functions.php");

mysql_select_db('maropost_templates');

require_once("template_class.php");

$html_code = buildPreview($iId);

// get newsletter instance data from `automated`, insert job id into
// html, and create array with db info
$get_data_result = mysql_query("SELECT * FROM automated WHERE id = \"$iId\"");
// this should only run through a single time...
while ($data_row = mysql_fetch_object($get_data_result)) {
  $data_array = array(
    'campaign_id' => $data_row->campaign_id,
    'content_id' => $data_row->content_id,
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
// if we don't already have a contents_id, then this is new content
$newContent = $data_array['content_id'] == 0;

$apiResult = pushNewsletterContent($data_array);
//var_dump($apiResult);

// for new content, add the id field from the response to the db record
if ($newContent) {
  $contentId = $apiResult->id;
  if ($contentId != '' && ctype_digit($contentId)) {
    $sql = "UPDATE automated
            SET content_id='$contentId'
            WHERE id = '$iId'";
    echo "\n\n$sql\n\n";
    $get_data_result = mysql_query($sql);
    var_dump($get_data_result);
    echo mysql_error();
  }
}


// no response, something went wrong
/* if(trim($create_result) == ""){ */
/*     $message = "<p>Empty Server response! Could be the html content encoding error</p>"; */
/*     echo $message; */
/*     //echo "<p><textarea width='80%' height=200>"; */
/*     //echo print_r($data_array, true); */
/*     //echo "</textarea></p>"; */
/* } */

// Save campaigner response in db
$responseSql = "INSERT INTO `campaignerResponse` (`id`, `campaignId`, `datetime`, `response`)
                VALUES (NULL, '{$data_array['content_id']}', NOW(), '" . addslashes(json_encode($apiResult)) . "')";
mysql_query($responseSql);
echo mysql_error();



// jshearer 02/23/2106: log the html that's actually getting sent to
// Maropost; this should just be temporary during this transition
echo writeToLog($html_code);


//echo trim(getXmlValueByTag($create_result,'ReturnMessage'))." => CampaignId: ".$CampaignId;
echo "<br><br>";
//echo json_encode($apiResult);

?>
<br><br><br><center><button type="button" onclick="window.open('', '_self', ''); window.close();">Close</button></center>
