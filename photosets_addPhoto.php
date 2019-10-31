<?php

function photosets_addPhoto($photoset_id, $photo_id)
{
   $oauth_nonce = md5(uniqid(rand(), true));
   $now = time();
   $method = 'flickr.photosets.addPhoto';

   $params = 
      "format=json" .
      "&method=" . $method . 
      "&nojsoncallback=1" . 
      "&oauth_consumer_key=" . api_key . 
      "&oauth_nonce=" . $oauth_nonce . 
      "&oauth_signature_method=" . oauth_signature_method .
      "&oauth_timestamp=" . $now .
      "&oauth_token=" . dest_oauth_token .
      "&oauth_version=" . oauth_version .
      "&photo_id=" . $photo_id .
      "&photoset_id=" . $photoset_id;

   $base_string = 'POST&'. urlencode(api_endpoint) . '&' . urlencode($params);
   $hash_key = api_secret . '&' . dest_oauth_token_secret;
   $oauth_sig = base64_encode(hash_hmac('sha1', $base_string, $hash_key, true));

   $params .= '&oauth_signature=' . $oauth_sig;

   $args = array(
         'format' => 'json',
         'method' => $method,
         'nojsoncallback' => 1,
         'oauth_consumer_key' => api_key,
         'oauth_nonce' => $oauth_nonce,
         'oauth_signature_method' => oauth_signature_method,
         'oauth_timestamp' => $now,
         'oauth_token' => dest_oauth_token,
         'oauth_version' => oauth_version,
         'photo_id' => $photo_id,
         'photoset_id' => $photoset_id,
         'oauth_signature' => $oauth_sig,
         );
   
   if (debug) {
      error_log("*** addPhoto *** \n", 3, log_path);
   }

   return http_request(api_endpoint, $params, $args, 'POST');
}
