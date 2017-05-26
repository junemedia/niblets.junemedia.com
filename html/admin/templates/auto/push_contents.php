<?php

include_once("../../../includes/paths.php");
include_once("$sGblSubctrPath/functions.php");

mysql_select_db( $templatesDB );

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
 * Send new data to Maropost
 * ********************************************************************
 */
// if we don't already have a contents_id, then this is new content
$newContent = $data_array['content_id'] == 0;

// if not new, check to make sure the content is still in Maropost's system
// if it's not, e.g because somebody deleted it in Maropost's system,
// reset `contentid` to 0 so we're not trying to push content to
// non-existent endpoint
if (!$newContent) {
  if (!contentExists($data_array['content_id'])) {
    $data_array['content_id'] = 0;
    $newContent = true;
  };
}

$apiResult = pushNewsletterContent($data_array);

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

// Save campaigner response in db
$responseSql = "INSERT INTO `campaignerResponse` (`id`, `campaignId`, `datetime`, `response`)
                VALUES (NULL, '{$data_array['content_id']}', NOW(), '" . addslashes(json_encode($apiResult)) . "')";
mysql_query($responseSql);
echo mysql_error();

?>
<br><br><br><center><button type="button" onclick="window.open('', '_self', ''); window.close();">Close</button></center>
