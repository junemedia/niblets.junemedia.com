<?php

include_once("../../../includes/paths.php");
include_once("$sGblSubctrPath/functions.php");

require_once("template_class.php");

$html_code = buildPreview($iId);

// get newsletter instance data from `automated` and create array with db info
$get_data_result = mysql_query("SELECT * FROM automated WHERE id = \"$iId\"");

// this should only run through a single time...
while ($data_row = mysql_fetch_object($get_data_result)) {
  $foreign_id = $data_row->foreign_id;
  $payload = array(
    'name' => $data_row->campaign_name,
    'subject' => $data_row->subject,
    //'fromname' => $data_row->from_name,
    //'from_email_id' => $data_row->from_email_id,
    'html_source' => $html_code
  );
}

/*
 * ********************************************************************
 * Send new data to Maropost
 * ********************************************************************
 */
// if we don't already have a contents_id, then this is new content
$newContent = $foreign_id == 0;


/* ****************** bypassing for the moment ****************** */
// if not new, check to make sure the content is still in Emarsys' system
// if it's not, e.g because somebody deleted it, reset `foreign_id` to 0 
// so we're not trying to push content to non-existent endpoint
/*
if (!$newContent) {
  if (!contentExists($foreign_id)) {
    $foreign_id = 0;
    $newContent = true;
  };
}
*/
/* ****************** bypassing for the moment ****************** */


$apiResult = pushEmarsysCampaign($foreign_id, $payload);

/* typical response on success:
{
  "replyCode": 0,
  "replyText": "OK",
  "data": {
    "additional_linktracking_parameters": "",
    "api_error": "0",
    "api_status": "0",
    "browse": "y",
    "cc_list": 0,
    "combined_segment_id": null,
    "contactlist": "0",
    "content_type": "html",
    "created": "2018-05-04 23:43:06",
    "deleted": "",
    "email_category": "0",
    "exclude_contactlist": null,
    "exclude_filter": 0,
    "external_event_id": null,
    "filter": "15979",
    "fromemail": "johns@junemedia.com",
    "fromname": "John",
    "html_source": "<html><head><title>Daily Recipes by BetterRecipes</title></head><body></body></html>",
    "id": "18101",
    "keep_raw_html": 0,
    "keep_raw_text": 0,
    "language": "en",
    "name": "TEST: BR daily 01",
    "recurring": "n",
    "root_campaign_id": "0",
    "source": "profile",
    "status": "1",
    "subject": "This is a test: BR daily 01",
    "template": "0",
    "text_only": "n",
    "text_source": "",
    "type": "1",
    "unsubscribe": "y",
    "value_control": null,
    "version_name": ""
  }
}
*/

echo "Emarsys replyCode: {$apiResult->replyCode}<br>";
echo "Emarsys replyText: {$apiResult->replyText}<br><br>";
//var_dump($apiResult);


// for new content, add the id field from the response to the db record
if ($newContent) {
  $foreign_id = $apiResult->data->id;
  if ($foreign_id != '' && ctype_digit($foreign_id)) {
    $sql = "UPDATE `automated`
            SET `foreign_id` = '$foreign_id'
            WHERE `id` = '$iId'";
    echo "\n\n$sql\n\n";
    $get_data_result = mysql_query($sql);
    var_dump($get_data_result);
    echo mysql_error();
  }
}

// Save campaigner response in db
$responseSql = "INSERT INTO `campaignerResponse` (`id`, `campaignId`, `datetime`, `response`)
                VALUES (NULL, '{$foreign_id}', NOW(), '" . addslashes(json_encode($apiResult)) . "')";
mysql_query($responseSql);
echo mysql_error();

?>

<br><br><br>
<center>
  <button type="button" onclick="window.open('', '_self', ''); window.close();">Close</button>
</center>
