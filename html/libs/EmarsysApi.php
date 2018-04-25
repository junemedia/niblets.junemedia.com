<?php

/**
 * Based on:
 * https://gist.githubusercontent.com/EmarsysDocumentationGists/ae4475aba579423d9eed274e6061942a/raw/7ec3030fb97e394a21c75eb4cf6f79ca17fa3e5d/APIAuthenticationSamplePhp.php
 */
class EmarsysApi {
  private
    $_username,
    $_secret,
    $_apiUrl,
    $_ch,
    $_contentType = 'Content-type: application/json;charset="utf-8"';

  public function __construct($username, $secret, $apiUrl = 'https://api.emarsys.net/api/v2/') {
    $this->_username = $username;
    $this->_secret = $secret;
    $this->_apiUrl = $apiUrl;

    $this->_ch = curl_init();
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, 1);
  }


  public function get($endPoint) {
    $requestUri = $this->_apiUrl . $endPoint;
    curl_setopt($this->_ch, CURLOPT_URL, $requestUri);

    curl_setopt($this->_ch, CURLOPT_HTTPGET, 1);

    return $this->_sendRequest();
  }

  public function post($endPoint, $requestBody = '') {
    $requestUri = $this->_apiUrl . $endPoint;
    curl_setopt($ch, CURLOPT_URL, $requestUri);

    curl_setopt($this->_ch, CURLOPT_POST, 1);
    curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $requestBody);

    return $this->_sendRequest;
  }

  public function put($endPoint, $requestBody = '') {
    $requestUri = $this->_apiUrl . $endPoint;
    curl_setopt($ch, CURLOPT_URL, $requestUri);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

    return $this->_sendRequest;
  }

  public function delete($endPoint, $requestBody = '') {
    $requestUri = $this->_apiUrl . $endPoint;
    curl_setopt($ch, CURLOPT_URL, $requestUri);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

    return $this->_sendRequest;
  }

  private function _sendRequest() {
    // set headers
    curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array(
      $this->_generateWSSE(),
      $this->_contentType
    ));
    $output = curl_exec($this->_ch);
    curl_close($this->_ch);

    return $output;
  }


  /**
   * We add X-WSSE header for authentication.
   * Always use random 'nonce' for increased security.
   * timestamp: the current date/time in UTC format encoded as
   *   an ISO 8601 date string like '2010-12-31T15:30:59+00:00' or '2010-12-31T15:30:59Z'
   * passwordDigest looks sg like 'MDBhOTMwZGE0OTMxMjJlODAyNmE1ZWJhNTdmOTkxOWU4YzNjNWZkMw=='
   */
  private function _generateWSSE() {
    $nonce = $this->_generateNonce();
    $timestamp = gmdate("c");
    $passwordDigest = base64_encode(sha1($nonce . $timestamp . $this->_secret, false));
    return 'X-WSSE: UsernameToken ' .
           'Username="'.$this->_username.'", ' .
           'PasswordDigest="'.$passwordDigest.'", ' .
           'Nonce="'.$nonce.'", ' .
           'Created="'.$timestamp.'"';
  }

  /**
   * good enough for now
   * https://www.reddit.com/r/PHP/comments/276jko/is_openssl_random_pseudo_bytes_good_to_generate/
   */
  private function _generateNonce() {
    $rand = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
    $hex = bin2hex($rand);
    return substr($hex, 0, 32);
  }
}
