<?php
require("$sGblWebRoot/libs/EmarsysApi.php");


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

  $ch = curl_init("$apiRoot/$apiEndpoint?auth_token=$apiKey");
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $apiMethod);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $apiHeaders);
  $response = curl_exec($ch);
  curl_close($ch);

  return json_decode($response);
}

/**
 * Given an image url, upload it to media library
 *
 * returns an object containing the API response
 */
function addImageToLibrary($imgURL) {

  $payload = array(
    "filename" => getFileNameFromUrl($imgURL),
    "file" => retrieveImageFromUrl($imgURL),
    "folder" => 744
  );
  $payload = json_encode($payload);

  $emarsys = new EmarsysApi('June_Media001', 'QT7gl8vVef165syjLO4r');
  $response = $emarsys->post('file', $payload);

  /* sample response from Emarsys on success:
  {
    "replyCode": 0,
    "replyText": "OK",
    "data": {
      "id": "9385",
      "folder": "744",
      "filename": "md_9385.jpg",
      "size": "40560",
      "original_name": "featured_8c8f960a578044de5e60f51a0f2d2ba7_pulled pork with apple cider bbq sauce dreamstimesmall_88523593.jpg",
      "url": "https:\/\/suite24.emarsys.net\/custloads\/785861579\/md_9385.jpg"
    }
  }
  */

  return json_decode($response);

}

/**
 * good enough for now
 */
function getFileNameFromUrl($url) {
  return basename(parse_url($url)['path']);
}

/**
 * retrieve an image file from a url and base64 encode it
 */
function retrieveImageFromUrl($url) {
  // some of our images include spaces in their names
  $url = str_replace(' ', '%20', $url);

  $ch = curl_init ($url);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

  $raw = curl_exec($ch);
  curl_close ($ch);

  return base64_encode($raw);

}

// upload an image to Campaigner library
// duplicates templates/auto/addImageToLibrary.php
function generateImgUrl($imageurl) {
  if (!strstr($imageurl, MEDIALIBRARY)) {

    // expecting to get back an object here
    $response = addImageToLibrary($imageurl);

    // if image_url is in response then it was successful
    if (isset($response->data->url)) {
      return $response->data->url;    // a string
    }
    else {
      mail('johns@junemedia.com','MOVE upload image error', json_encode($response));
      return json_encode($response);
    }
  }
}
