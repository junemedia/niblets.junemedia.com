<?php
/*
include_once("JSON.php");
*/

/**
 * check whether content exists in Maropost's system
 *
 * @param number $contentId
 *
 * @return number
 */
function contentExists($contentId) {
  $apiKey = 'c300eeefb54ee6e746260585befa15a10a947a86';
  $apiRoot = 'http://api.maropost.com/accounts/694';
  $apiEndpoint = "contents/$contentId.json";
  $apiMethod = 'GET';
  $apiHeaders = array(
    'Accept: application/json',
    'Content-Type: application/json'
  );

  $ch = curl_init("$apiRoot/$apiEndpoint?auth_token=$apiKey");
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $apiMethod);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $apiHeaders);
  $response = curl_exec($ch);
  $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  $json = json_decode($response);

  if ($statusCode == 200) {
    if (isset($json->id) && $json->id == $contentId) {
      return true;
    }
  }
  return false;
}

/**
 * build html from template and db data
 *
 * @param number $automatedId newsletter it in `maropost`.`automated`
 *
 * @return string newsletter html
 */
function buildPreview($automatedId) {

  if ($automatedId != '' && ctype_digit($automatedId)) {
    // find out which template to use
    $query = "SELECT * FROM automated WHERE id = '$automatedId'";
    $rSelectResult = mysql_query($query);
    // there should only be a single result...
    while ($oRow = mysql_fetch_object($rSelectResult)) {
      $template = $oRow->template;

      // if we already have a campaign id use that, otherwise use our
      // `automated` row id
      $campaignId = $oRow->campaign_id ? $oRow->campaign_id : $automatedId;
      $contentId = $oRow->content_id ? $oRow->content_id : $automatedId;

    }
    $preview  = new Template("templates/$template");

    // populate template with values from database
    $query = "SELECT * FROM automated_map WHERE automated_id = '$automatedId'";
    $rSelectResult = mysql_query($query);
    while ($oRow = mysql_fetch_object($rSelectResult)) {
      $tag_key = $oRow->tag_key;
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
    $html_code = str_replace("{opencount('<img src=\"{opct.url}\" width=\"1\" height=\"1\" border=\"0\" />')}", '', $html_code);
    $html_code = str_replace("{datetime(job.issuedate,'','%Y%m%d')}", date('Ymd'), $html_code);
    $html_code = str_replace('{to}', '{{contact.email}}', $html_code);
    $html_code = str_replace('{job.jobid}', $campaignId, $html_code);
  }
  else {
    $html_code = 'ID missing';

  }

  return $html_code;
}

function pushNewsletterContent($contentsArray) {
  $apiKey = 'c300eeefb54ee6e746260585befa15a10a947a86';
  $apiRoot = 'http://api.maropost.com/accounts/694';
  $apiEndpoint = 'contents';
  $apiHeaders = array(
    'Accept: application/json',
    'Content-Type: application/json'
  );

  $payload = array(
    'content' => array(
      'name' => $contentsArray['campaign_name'],
      'html_part' => $contentsArray['html_code'],
      'full_email' => false, // open content in Maropost's WYSIWYG editor
      /*
      'id': 356632
      'account_id': 694
      'text_part': null
      'created_at': '2016-02-26T16:17:48.000-05:00'
      'updated_at': '2016-02-26T16:17:48.000-05:00'
      'content_template_id': null
      'pull_url': null
      'footer_type': null
      'footer_id': null
      'folder_id': null
      'content_feed_id': null
      */
    )
  );
  $payload = json_encode($payload);

  // if it's new content, then POST the data
  if ($contentsArray['content_id'] == 0) {
    $apiEndpoint .= '.json';
    $apiMethod = 'POST';
  }
  else {
    $apiEndpoint .= "/{$contentsArray['content_id']}.json";
    $apiMethod = 'PUT';
  }

  //header('Content-type: text/plain');
  //echo "$apiRoot\n\n$apiEndpoint?auth_token=$apiKey\n\n";
  //die;
  //echo $payload;

  $ch = curl_init("$apiRoot/$apiEndpoint?auth_token=$apiKey");
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $apiMethod);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $apiHeaders);
  $response = curl_exec($ch);
  curl_close($ch);

    /*
     * example POST response:

      {"id":344309,"account_id":694,"name":"API TEST 02","html_part":"\u003c!DOCTYPE html\u003e\n\u003chtml\u003e\u003cbody\u003e\u003cp style=\"font-weight: bold;\"\u003eTest 02\u003c/p\u003e\u003c/body\u003e\u003c/html\u003e\n","text_part":null,"created_at":"2016-02-23T15:18:08.466-05:00","updated_at":"2016-02-23T15:18:08.466-05:00","content_template_id":null,"pull_url":null,"footer_type":null,"footer_id":null,"folder_id":null,"content_feed_id":null}

     * PUT response has status 204 on success, with no content
     */

  //mail('johns@junemedia.com','rest request',$response);

  return json_decode($response);
}

function addImageToLibrary($imgURL) {
  $payload = array(
    "content_image" => array(
      "image_url" => $imgURL
    )
  );
  $payload = json_encode($payload);

  $api_key = 'c300eeefb54ee6e746260585befa15a10a947a86';
  $api_root = 'http://api.maropost.com/accounts/694';
  $api_endpoint = 'content_images/upload.json';
  $api_headers = array(
    'Accept: application/json',
    'Content-Type: application/json'
  );

  $ch = curl_init("$api_root/$api_endpoint?auth_token=$api_key");
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $api_headers);
  $response = curl_exec($ch);
  curl_close($ch);

  //mail('johns@junemedia.com','rest request',$response);

  return json_decode($response);
}
