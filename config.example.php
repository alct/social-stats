<?php

date_default_timezone_set('Europe/Brussels');

/*
 *   $identities
 *   -----------
 *
 *   Set of arrays containing account information for various identities
 *
 *   One identity = one array
 *
 *   Twitter account is mandatory
 *   
 *   Example:
 *   
 *      array(
 *        'title'    => 'Super Company', // Full name (used in the web UI), single and double quotes must be avoided
 *        'twitter'  => 'super_company', // account without the "@"
 *        'identica' => 'super_company', // account without the "@"
 *        'facebook' => 'https://facebook.com/pages/SuperCompany/0123456789', // for the time being, works only with pages (not groups nor personal profiles)
 *      ),
 *      
*/

$identities = array(
  array(
    'title'    => '',
    'twitter'  => '',
    'identica' => '',
    'facebook' => '',
  ),
);

?>