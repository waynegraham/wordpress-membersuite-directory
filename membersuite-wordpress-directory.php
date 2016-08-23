<?php

/**
 * Plugin Name: Membership Directory for Membersuite
 * Plugin URI: https://www.github.com/clirdlf/membersuite-wordpress-directory
 * Description: A WordPress plugin for creaing a membership directory from the Membersuite API.
 * Version: 0.0.1
 * Author: Wayne Graham
 * Author URI: https://waynegraham.github.io
 * License: MIT
 */

require_once('./sdk-php/lib/phpsdk.phar');

//TODO: Set these in the web ui
$config = array(
  'AccessKeyId' => '',
  'AccessKeyId' => '',
  'AssociationId' => '',
  'SecretAccessKey' => '',
  'SigningcertificateId' => '',
  'SigningcertificatePath' => '',
  'PortalUrl' => ''
);

$api = new MemberSuite();
$api->accesskeyId = Userconfig::read('AccessKeyId');
$api->associationId = Userconfig::read('AssociationId');
$api->secretaccessId = Userconfig::read('SecretAccessKey');


// TODO: list of current members
// Need the proper UUID for the response context
$contextID = '00000000-0008-4f71-8a98-45f86f1a49fd';
$getresponse = $api->Get($contextID);

$ResponseResult = new msUser($getresponse->aResultValue);
$Getresultdata = $ResponseResult->ConvertToArray($ResponseResult);

// TODO: cache this? run a cron like once a week to check for updates? Doubt there's anything sophisticted as a webhook in the web interface
// for a local cache, we can augment the data with spatial information geocoding off the address for the map
//
// Basic flow of cron
//
// - Fetch Membership data through SDK
// - Update or add membership record to WordPress (hopefully there's an id or something in the payload)
// - If there is no lng/lat, Geocode
//    * use https://github.com/geocoder-php/Geocoder
//

// Front-facing user interface
// - A map of locations
// - A filter table (i.e. http://ndsa.org/members-list/)
//
// look at the json files at https://github.com/clirdlf/ndsa.org/tree/gh-pages/data
//

// Admin panel
// Add all the required admin items
// API key from Google (with geocoding perms)
// Set a time to hit API
// Button to manually refresh cache
// Button to clear cache
// Button to send hugs
